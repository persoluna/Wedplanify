<?php

namespace App\Filament\Resources\Bookings;

use App\Filament\Resources\Bookings\Pages\CreateBooking;
use App\Filament\Resources\Bookings\Pages\EditBooking;
use App\Filament\Resources\Bookings\Pages\ListBookings;
use App\Filament\Resources\Bookings\Schemas\BookingForm;
use App\Filament\Resources\Bookings\Tables\BookingsTable;
use App\Models\Booking;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;

class BookingResource extends Resource
{
    protected static ?string $model = Booking::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $navigationGroup = 'Customer Pipeline';

    protected static ?int $navigationSort = 50;

    public static function form(Schema $schema): Schema
    {
        return BookingForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return BookingsTable::configure($table);
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
            'index' => ListBookings::route('/'),
            'create' => CreateBooking::route('/create'),
            'edit' => EditBooking::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        $query = parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);

        $user = Auth::user();

        if (! $user) {
            return $query->whereKey(-1);
        }

        if ($user->isAdmin()) {
            return $query;
        }

        if ($user->isAgency()) {
            $agencyId = optional($user->agency)->getKey();

            if (! $agencyId) {
                return $query->whereKey(-1);
            }

            return $query->where('bookable_type', \App\Models\Agency::class)
                ->where('bookable_id', $agencyId);
        }

        if ($user->isVendor()) {
            $vendorId = optional($user->vendor)->getKey();

            if (! $vendorId) {
                return $query->whereKey(-1);
            }

            return $query->where('bookable_type', \App\Models\Vendor::class)
                ->where('bookable_id', $vendorId);
        }

        return $query->whereKey(-1);
    }

    public static function getRecordRouteBindingEloquentQuery(): Builder
    {
        return static::getEloquentQuery();
    }
}
