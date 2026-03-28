<?php

namespace App\Filament\Resources\VendorAvailabilities;

use App\Filament\Resources\VendorAvailabilities\Pages\CreateVendorAvailability;
use App\Filament\Resources\VendorAvailabilities\Pages\EditVendorAvailability;
use App\Filament\Resources\VendorAvailabilities\Pages\ListVendorAvailabilities;
use App\Filament\Resources\VendorAvailabilities\Schemas\VendorAvailabilityForm;
use App\Filament\Resources\VendorAvailabilities\Tables\VendorAvailabilitiesTable;
use App\Models\VendorAvailability;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class VendorAvailabilityResource extends Resource
{
    protected static ?string $model = VendorAvailability::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedCalendar;

    protected static ?string $navigationGroup = 'Availability Mapping';

    protected static ?int $navigationSort = 60;

    public static function form(Schema $schema): Schema
    {
        return VendorAvailabilityForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return VendorAvailabilitiesTable::configure($table);
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
            'index' => ListVendorAvailabilities::route('/'),
            'create' => CreateVendorAvailability::route('/create'),
            'edit' => EditVendorAvailability::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        $query = parent::getEloquentQuery();

        $user = Auth::user();

        if (! $user) {
            return $query->whereKey(-1);
        }

        if ($user->isAdmin()) {
            return $query;
        }

        if ($user->isAgency()) {
            $agency = $user->agency;
            if (! $agency) {
                return $query->whereKey(-1);
            }
            return $query->whereIn('vendor_id', $agency->ownedVendors()->pluck('id')->merge($agency->vendors()->pluck('vendors.id')));
        }

        if ($user->isVendor()) {
            $vendorId = optional($user->vendor)->getKey();
            if (! $vendorId) {
                return $query->whereKey(-1);
            }
            return $query->where('vendor_id', $vendorId);
        }

        return $query->whereKey(-1);
    }
}
