<?php

namespace App\Filament\Resources\ProfessionalApplications\Tables;

use App\Models\ProfessionalApplication;
use App\Models\User;
use App\Models\Vendor;
use App\Models\Agency;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Actions\Action;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class ProfessionalApplicationsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('first_name')->searchable(),
                TextColumn::make('last_name')->searchable(),
                TextColumn::make('email')->searchable(),
                TextColumn::make('business_name')->searchable(),
                BadgeColumn::make('business_type')
                    ->colors([
                        'primary' => 'agency',
                        'success' => 'vendor',
                    ]),
                TextColumn::make('location')->searchable(),
                BadgeColumn::make('status')
                    ->colors([
                        'warning' => 'pending',
                        'success' => 'approved',
                        'danger' => 'rejected',
                    ]),
                TextColumn::make('created_at')->dateTime()->sortable(),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                Action::make('approve')
                    ->label('Approve & Setup')
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->visible(fn (ProfessionalApplication $record) => $record->status === 'pending')
                    ->requiresConfirmation()
                    ->modalHeading('Approve Application & Create Account')
                    ->modalDescription('This will automatically generate a User account and link them to a new base skeleton for their Agency or Vendor profile. They will be granted the correct permissions.')
                    ->form([
                        TextInput::make('password')
                            ->label('Initial Account Password')
                            ->password()
                            ->required()
                            ->default(Str::random(10))
                            ->helperText('Copy this password to share with the professional, or they can use the "Forgot Password" flow.'),
                        Select::make('category_id')
                            ->label('Vendor Category (If Vendor)')
                            ->options(\App\Models\Category::pluck('name', 'id'))
                            ->required(fn ($record) => $record->business_type === 'vendor')
                            ->visible(fn ($record) => $record->business_type === 'vendor'),
                    ])
                    ->action(function (array $data, ProfessionalApplication $record): void {
                        // 1. Create the User Component
                        $user = User::create([
                            'name' => $record->first_name . ' ' . $record->last_name,
                            'email' => $record->email,
                            'password' => Hash::make($data['password']),
                            'phone' => $record->phone,
                            'type' => $record->business_type,
                            'active' => true,
                            'email_verified_at' => now(),
                        ]);

                        // 2. Assign the Role
                        $user->assignRole($record->business_type);

                        // 3. Create Vendor or Agency Profile
                        if ($record->business_type === 'vendor') {
                            Vendor::create([
                                'user_id' => $user->id,
                                'business_name' => $record->business_name,
                                'slug' => Str::slug($record->business_name) . '-' . uniqid(),
                                'city' => $record->location, // Assuming location implies city
                                'category_id' => $data['category_id'] ?? null,
                                'verified' => true, // Since it's admin approved
                            ]);
                        } else {
                            Agency::create([
                                'user_id' => $user->id,
                                'business_name' => $record->business_name,
                                'slug' => Str::slug($record->business_name) . '-' . uniqid(),
                                'city' => $record->location,
                                'verified' => true,
                            ]);
                        }

                        // 4. Update Application Status
                        $record->update(['status' => 'approved']);

                        Notification::make()
                            ->success()
                            ->title('Profile Successfully Created')
                            ->body("User {$user->name} has been set up as a {$record->business_type}.")
                            ->send();
                    }),
                Action::make('reject')
                    ->label('Reject')
                    ->icon('heroicon-o-x-circle')
                    ->color('danger')
                    ->visible(fn (ProfessionalApplication $record) => $record->status === 'pending')
                    ->requiresConfirmation()
                    ->action(function (ProfessionalApplication $record): void {
                        $record->update(['status' => 'rejected']);
                        Notification::make()->success()->title('Application rejected')->send();
                    }),
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
