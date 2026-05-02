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
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use Filament\Navigation\NavigationItem;
use App\Filament\Pages\Auth\Login;
use App\Filament\Pages\Profile;
use Filament\Navigation\MenuItem;


class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->navigationItems([
                NavigationItem::make('Legislative Records')
                    ->url(fn () => route('legislative_index'))
                    ->icon('heroicon-o-folder')
                    ->group('Public View')
                    ->sort(5),
            ])
            ->default()
            ->id('admin')
            ->path('admin')
            ->viteTheme('resources/css/filament/admin/theme.css')
            ->login(Login::class)
            ->colors([
                'primary' => Color::Indigo,
                'gray' => Color::Slate,
            ])
            ->brandName('Legislative Tracking')
            ->brandLogo(fn () => view('filament.brand'))
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\\Filament\\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\\Filament\\Pages')
            ->pages([
                    \App\Filament\Pages\Dashboard::class,
                ])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\\Filament\\Widgets')
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
                \App\Http\Middleware\EnsureUserIsActive::class,
            ])
            ->userMenuItems([
                MenuItem::make()
                ->label('Profile')
                ->icon('heroicon-o-user')
                ->url(fn () => Profile::getUrl())
                ->color('success'),
            ])
            ->authMiddleware([
                Authenticate::class,
            ]);
    }
}
