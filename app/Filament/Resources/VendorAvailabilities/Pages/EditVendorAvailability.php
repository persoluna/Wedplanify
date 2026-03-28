<?php

namespace App\Filament\Resources\VendorAvailabilities\Pages;

use App\Filament\Resources\VendorAvailabilities\VendorAvailabilityResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditVendorAvailability extends EditRecord
{
    protected static string $resource = VendorAvailabilityResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
