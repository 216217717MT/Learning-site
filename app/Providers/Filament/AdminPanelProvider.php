<?php

namespace App\Providers\Filament;

use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Pages;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Widgets;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use Filament\View\PanelsRenderHook;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('admin')
            ->brandName('CPUT Help')
            ->brandLogo(asset('images/cput-logo.png'))
            ->brandLogoHeight('2.5rem')
            ->path('admin')
            ->sidebarWidth('14rem')
            ->darkMode(false)
            ->login()

            ->colors([
                'primary' => Color::Blue,
                'sa-green' => Color::hex('#007A4D'),
                'sa-gold' => Color::hex('#FFB612'),
                'sa-red' => Color::hex('#DE3831'),
                'sa-blue' => Color::hex('#002395'),
                //'gray' => Color::Slate,
            ])
//            ->colors([
//                'primary' => Color::Slate,
////                'gray' => Color::Red,
//            ])
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\\Filament\\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\\Filament\\Pages')
            ->pages([
                \App\Filament\Pages\Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\\Filament\\Widgets')

//            ->renderHook(
//                PanelsRenderHook::SIDEBAR_NAV_START,
//                fn () => view('filament.sidebar-logo'),
//            )
            ->renderHook(
                PanelsRenderHook::SIDEBAR_NAV_END,                             // sidedar part
                fn () => view('filament.sidebar-welcome'),
            )
            ->renderHook(
                PanelsRenderHook::HEAD_END,
                fn () => view('filament.admin-background'),
            )
            ->renderHook(
                PanelsRenderHook::TOPBAR_END,
                fn () => view('filament.topbar-date'),
            )
            ->renderHook(
                PanelsRenderHook::TOPBAR_END,
                fn () => view('filament.topbar-profile'),
            )
            ->widgets([
            ])
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
            ->authMiddleware([
                Authenticate::class,
            ]);
    }
}
