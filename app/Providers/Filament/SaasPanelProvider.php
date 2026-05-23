<?php

namespace App\Providers\Filament;

use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Pages\Dashboard;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\View\PanelsRenderHook;
use App\Filament\Saas\Pages\SaasProfilePage;
use App\Filament\Saas\Widgets\SaasRevenueChart;
use App\Filament\Saas\Widgets\SaasStatsOverview;
use App\Filament\Saas\Widgets\SaasRecentTenants;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\PreventRequestForgery;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;

class SaasPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->id('saas')
            ->path('saas-admin')
            ->login()
            ->profile(SaasProfilePage::class, isSimple: false)
            ->colors([
                'primary' => Color::Indigo,
            ])
            ->discoverResources(in: app_path('Filament/Saas/Resources'), for: 'App\Filament\Saas\Resources')
            ->discoverPages(in: app_path('Filament/Saas/Pages'), for: 'App\Filament\Saas\Pages')
            ->discoverWidgets(in: app_path('Filament/Saas/Widgets'), for: 'App\Filament\Saas\Widgets')
            ->pages([
                Dashboard::class,
            ])
            ->widgets([
                SaasStatsOverview::class,
                SaasRevenueChart::class,
                SaasRecentTenants::class,
            ])
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                PreventRequestForgery::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])
            ->authMiddleware([
                Authenticate::class,
            ])
            ->renderHook(
                PanelsRenderHook::GLOBAL_SEARCH_AFTER,
                fn (): string => view('components.saas-notification-bell')->render(),
            );
    }
}
