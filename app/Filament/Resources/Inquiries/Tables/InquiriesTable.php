<?php

namespace App\Filament\Resources\Inquiries\Tables;

use App\Models\Booking;
use App\Models\VendorAvailability;
use Filament\Actions\ActionGroup;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Actions\RestoreAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Actions\Action;
use Filament\Tables\Columns\SelectColumn;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Enums\RecordActionsPosition;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\TimePicker;
use Filament\Forms\Components\Toggle;
use Illuminate\Support\Facades\Auth;

class InquiriesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('Client')
                    ->description(fn ($record) => collect([$record->email, $record->phone])->filter()->join(' • '))
                    ->searchable()
                    ->sortable()
                    ->wrap(),
                TextColumn::make('agency.business_name')
                    ->label('Agency')
                    ->toggleable()
                    ->sortable()
                    ->searchable(),
                TextColumn::make('vendor.business_name')
                    ->label('Vendor')
                    ->toggleable()
                    ->sortable()
                    ->searchable(),
                TextColumn::make('event_date')
                    ->date()
                    ->sortable(),
                TextColumn::make('budget')
                    ->money('INR')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                SelectColumn::make('status')
                    ->options([
                        'new' => 'New',
                        'in_progress' => 'In progress',
                        'responded' => 'Responded',
                        'booked' => 'Booked',
                        'cancelled' => 'Cancelled',
                        'unavailable' => 'Unavailable',
                    ])
                    ->sortable()
                    ->searchable(),
                IconColumn::make('is_urgent')
                    ->boolean()
                    ->label('Urgent'),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable(),
                TextColumn::make('deleted_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->options([
                        'new' => 'New',
                        'in_progress' => 'In progress',
                        'responded' => 'Responded',
                        'booked' => 'Booked',
                        'cancelled' => 'Cancelled',
                        'unavailable' => 'Unavailable',
                    ]),
                TernaryFilter::make('is_urgent')
                    ->label('Urgent only'),
                TrashedFilter::make(),
            ])
            ->recordActions([
                ActionGroup::make([
                    Action::make('convert_to_booking')
                        ->label('Convert to Booking')
                        ->icon('heroicon-o-check-badge')
                        ->color('success')
                        ->visible(fn ($record) => ! $record->isBooked())
                        ->form([
                            TextInput::make('amount')
                                ->required()
                                ->numeric()
                                ->label('Total Amount')
                                ->prefix('₹')
                                ->default(fn ($record) => $record->budget),
                            TextInput::make('deposit_amount')
                                ->numeric()
                                ->label('Deposit Required')
                                ->prefix('₹'),
                            DatePicker::make('event_date')
                                ->required()
                                ->default(fn ($record) => $record->event_date),
                            TimePicker::make('start_time'),
                            TimePicker::make('end_time'),
                            TextInput::make('event_location')
                                ->default(fn ($record) => $record->event_location),
                            Toggle::make('block_vendor_calendar')
                                ->label('Block Vendor Calendar')
                                ->default(true)
                                ->visible(fn ($record) => $record->vendor_id !== null),
                        ])
                        ->action(function (array $data, $record): void {
                            Booking::create([
                                'inquiry_id' => $record->id,
                                'client_id' => $record->client_id,
                                'bookable_type' => $record->vendor_id ? \App\Models\Vendor::class : \App\Models\Agency::class,
                                'bookable_id' => $record->vendor_id ?? $record->agency_id,
                                'amount' => $data['amount'],
                                'deposit_amount' => $data['deposit_amount'] ?? null,
                                'event_date' => $data['event_date'],
                                'event_location' => $data['event_location'] ?? null,
                                'start_time' => $data['start_time'] ?? null,
                                'end_time' => $data['end_time'] ?? null,
                                'status' => 'pending',
                            ]);

                            if (($data['block_vendor_calendar'] ?? false) && $record->vendor_id) {
                                VendorAvailability::updateOrCreate(
                                    ['vendor_id' => $record->vendor_id, 'date' => $data['event_date']],
                                    ['status' => 'fully_booked', 'notes' => 'Booked via Inquiry #' . $record->id]
                                );
                            }

                            $record->close('booked');
                        })
                        ->requiresConfirmation(),
                    EditAction::make(),
                    DeleteAction::make()
                        ->visible(fn ($record) => Auth::user()?->isAdmin() && ! $record->trashed()),
                    RestoreAction::make()
                        ->visible(fn ($record) => Auth::user()?->isAdmin() && $record->trashed()),
                    ForceDeleteAction::make()
                        ->visible(fn ($record) => Auth::user()?->isAdmin() && $record->trashed()),
                ])
                    ->label('Actions')
                    ->icon('heroicon-m-ellipsis-vertical')
                    ->color('gray')
                    ->button(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                    ForceDeleteBulkAction::make(),
                    RestoreBulkAction::make(),
                ]),
            ])
            ->recordActionsPosition(RecordActionsPosition::AfterColumns);
    }
}
