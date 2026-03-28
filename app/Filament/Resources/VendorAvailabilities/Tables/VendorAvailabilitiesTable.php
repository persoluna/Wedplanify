<?php

namespace App\Filament\Resources\VendorAvailabilities\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\Filter;
use Illuminate\Database\Eloquent\Builder;

class VendorAvailabilitiesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('vendor.business_name')
                    ->searchable()
                    ->sortable()
                    ->label('Vendor'),
                TextColumn::make('date')
                    ->date()
                    ->sortable(),
                TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'available' => 'success',
                        'partially_booked' => 'warning',
                        'fully_booked' => 'danger',
                        'unavailable' => 'gray',
                        default => 'primary',
                    })
                    ->searchable(),
                TextColumn::make('available_from')
                    ->time()
                    ->sortable(),
                TextColumn::make('available_to')
                    ->time()
                    ->sortable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->options([
                        'available' => 'Available',
                        'partially_booked' => 'Partially Booked',
                        'fully_booked' => 'Fully Booked',
                        'unavailable' => 'Unavailable',
                    ]),
                Filter::make('future')
                    ->label('Upcoming Only')
                    ->query(fn (Builder $query): Builder => $query->where('date', '>=', now()->startOfDay())),
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('date', 'asc');
    }
}
