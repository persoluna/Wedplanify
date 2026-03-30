<?php

namespace App\Filament\Admin\Resources\ProfessionalApplication;

use App\Filament\Admin\Resources\ProfessionalApplication\Pages\CreateProfessionalApplication;
use App\Filament\Admin\Resources\ProfessionalApplication\Pages\EditProfessionalApplication;
use App\Filament\Admin\Resources\ProfessionalApplication\Pages\ListProfessionalApplications;
use App\Filament\Admin\Resources\ProfessionalApplication\Schemas\ProfessionalApplicationForm;
use App\Filament\Admin\Resources\ProfessionalApplication\Tables\ProfessionalApplicationsTable;
use App\Models\ProfessionalApplication;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class ProfessionalApplicationResource extends Resource
{
    protected static ?string $model = ProfessionalApplication::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    public static function form(Schema $schema): Schema
    {
        return ProfessionalApplicationForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ProfessionalApplicationsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListProfessionalApplications::route('/'),
            'create' => CreateProfessionalApplication::route('/create'),
            'edit' => EditProfessionalApplication::route('/{record}/edit'),
        ];
    }
}
