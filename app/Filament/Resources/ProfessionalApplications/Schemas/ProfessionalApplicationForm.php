<?php

namespace App\Filament\Resources\ProfessionalApplications\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class ProfessionalApplicationForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('first_name')->required(),
                TextInput::make('last_name')->required(),
                TextInput::make('email')->email()->required(),
                TextInput::make('phone')->tel()->required(),
                TextInput::make('business_name')->required(),
                Select::make('business_type')
                    ->options([
                        'vendor' => 'Vendor',
                        'agency' => 'Agency',
                    ])->required(),
                TextInput::make('location')->required(),
                TextInput::make('website_url')->url(),
                TextInput::make('instagram_handle'),
                Textarea::make('additional_notes')->columnSpanFull(),
                Select::make('status')
                    ->options([
                        'pending' => 'Pending',
                        'approved' => 'Approved',
                        'rejected' => 'Rejected',
                    ])->required(),
            ]);
    }
}
