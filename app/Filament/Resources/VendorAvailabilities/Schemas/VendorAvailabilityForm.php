<?php

namespace App\Filament\Resources\VendorAvailabilities\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TimePicker;
use Filament\Schemas\Schema;

class VendorAvailabilityForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('vendor_id')
                    ->relationship('vendor', 'business_name')
                    ->searchable()
                    ->required(),
                DatePicker::make('date')
                    ->required(),
                Select::make('status')
                    ->options([
                        'available' => 'Available',
                        'partially_booked' => 'Partially Booked',
                        'fully_booked' => 'Fully Booked',
                        'unavailable' => 'Unavailable',
                    ])
                    ->required()
                    ->default('available'),
                TimePicker::make('available_from'),
                TimePicker::make('available_to'),
                Textarea::make('notes')
                    ->columnSpanFull(),
            ]);
    }
}
