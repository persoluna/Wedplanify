<?php

namespace App\Filament\Resources\ProfessionalApplications\Pages;

use App\Filament\Resources\ProfessionalApplications\ProfessionalApplicationResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListProfessionalApplications extends ListRecords
{
    protected static string $resource = ProfessionalApplicationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
