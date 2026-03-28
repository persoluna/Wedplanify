<?php

namespace App\Providers\Filament;

use App\Filament\Agency\Pages\AgencyDashboard;
use App\Filament\Agency\Pages\EditAgencyProfile;
use App\Filament\Resources\Bookings\BookingResource;
use App\Filament\Resources\Inquiries\InquiryResource;
use App\Filament\Resources\VendorAvailabilities\VendorAvailabilityResource;
use App\Filament\Resources\Vendors\VendorResource;
use BezhanSalleh\FilamentShield\FilamentShieldPlugin;
use Filament\FontProviders\GoogleFontProvider;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;

class AgencyPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->id('agency')
            ->path('agency')
            ->login()
            ->font('Plus Jakarta Sans', provider: GoogleFontProvider::class)
            ->colors([
                'primary' => Color::Rose,
                'gray' => Color::Stone,
                'secondary' => Color::Sky,
            ])
            ->viteTheme('resources/css/filament/agency/theme.css')
            ->resources([
                InquiryResource::class,
                BookingResource::class,
                VendorAvailabilityResource::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Agency/Widgets'), for: 'App\\Filament\\Agency\\Widgets')
            ->pages([
                AgencyDashboard::class,
                EditAgencyProfile::class,
            ])
            ->homeUrl(fn () => AgencyDashboard::getUrl())
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])
            ->plugins([
                FilamentShieldPlugin::make(),
            ])
            ->authMiddleware([
                Authenticate::class,
            ]);
    }
}
