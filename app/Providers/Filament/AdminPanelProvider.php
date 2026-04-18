<?php

namespace App\Providers\Filament;

use App\Filament\Resources\TrainingPrograms\Widgets\TrainingLevelsChart;
use App\Filament\Resources\TrainingSubscriptions\Widgets\SubscriptionChart;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Navigation\NavigationGroup;
use Filament\Pages\Dashboard;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use Illuminate\Support\HtmlString;

class AdminPanelProvider extends PanelProvider
{
  public function panel(Panel $panel): Panel
  {
    return $panel
      ->path('/')
      ->default()
      ->id('admin')
      ->path('admin')
      ->navigationGroups([
        NavigationGroup::make()
          ->label('إدارة المنتجات'),
        NavigationGroup::make()->label('إدارة المدربين الرياضيين')->collapsed(),
        NavigationGroup::make()->label('إدارة الملاعب')->collapsed(),
        NavigationGroup::make()->label('إدارة المواعيد')->collapsed(),
        NavigationGroup::make()->label('إدارة البرامج التدريبية'),
        NavigationGroup::make()->label('إدارة الاشتراكات'),
        NavigationGroup::make()->label('إدارة المستخدمين'),
      ])
      ->login()

      ->brandName(new HtmlString('<span style="font-style: italic; font-weight: bold; font-family: serif;">Elite Racket</span>'))
      ->brandLogo(asset('logo.png'))
      ->darkModeBrandLogo(asset('logo.png'))
      ->favicon(asset('logo.png'))
      ->brandLogoHeight('3rem')
      ->colors([
        'primary' => Color::Amber,
      ])
      ->font('Cairo')
      ->renderHook(
        \Filament\View\PanelsRenderHook::HEAD_END,
        fn(): \Illuminate\Support\HtmlString => new \Illuminate\Support\HtmlString('
        <style>
            html, body {
                font-size: 16px !important;
            }
            .fi-sidebar-item-label, .fi-ta-header-heading {
                font-size: 1.1rem !important;
            }
        </style>
    '),
      )
      ->globalSearch(false)
      ->spa()
      ->discoverResources(in: app_path('Filament/Resources'), for: 'App\Filament\Resources')
      ->discoverPages(in: app_path('Filament/Pages'), for: 'App\Filament\Pages')
      ->pages([
        Dashboard::class,
      ])
      ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\Filament\Widgets')
      ->widgets([
        SubscriptionChart::class,
        TrainingLevelsChart::class
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