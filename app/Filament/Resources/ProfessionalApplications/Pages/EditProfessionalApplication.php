<?php

namespace App\Filament\Resources\ProfessionalApplications\Pages;

use App\Filament\Resources\ProfessionalApplications\ProfessionalApplicationResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditProfessionalApplication extends EditRecord
{
    protected static string $resource = ProfessionalApplicationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
