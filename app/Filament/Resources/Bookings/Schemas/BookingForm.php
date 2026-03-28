<?php

namespace App\Filament\Resources\Bookings\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\MorphToSelect;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TimePicker;
use Filament\Schemas\Schema;

class BookingForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('client_id')
                    ->relationship('client.user', 'name')
                    ->searchable()
                    ->required(),

                MorphToSelect::make('bookable')
                    ->types([
                        MorphToSelect\Type::make(\App\Models\Vendor::class)
                            ->titleAttribute('business_name'),
                        MorphToSelect\Type::make(\App\Models\Agency::class)
                            ->titleAttribute('business_name'),
                    ])
                    ->required()
                    ->searchable(),

                Select::make('inquiry_id')
                    ->relationship('inquiry', 'id')
                    ->searchable()
                    ->getOptionLabelFromRecordUsing(fn (\App\Models\Inquiry $record) => "#{$record->id} - {$record->name}"),

                Select::make('status')
                    ->options([
                        'pending' => 'Pending',
                        'confirmed' => 'Confirmed',
                        'completed' => 'Completed',
                        'cancelled' => 'Cancelled',
                    ])
                    ->required()
                    ->default('pending'),

                DatePicker::make('event_date')
                    ->required(),
                TextInput::make('event_location'),
                TimePicker::make('start_time'),
                TimePicker::make('end_time'),

                TextInput::make('amount')
                    ->required()
                    ->numeric()
                    ->prefix('₹'),
                TextInput::make('deposit_amount')
                    ->numeric()
                    ->prefix('₹'),
                TextInput::make('balance_amount')
                    ->numeric()
                    ->prefix('₹'),
                
                DateTimePicker::make('deposit_paid_at'),
                DateTimePicker::make('full_payment_received_at'),

                Textarea::make('notes')
                    ->columnSpanFull(),
                Textarea::make('client_notes')
                    ->columnSpanFull(),
                Textarea::make('vendor_notes')
                    ->columnSpanFull(),
                Textarea::make('terms_and_conditions')
                    ->columnSpanFull(),
                
            ]);
    }
}
