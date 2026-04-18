<?php

namespace App\Filament\Widgets;

use App\Filament\Resources\Courts\CourtResource;
use App\Filament\Resources\Products\ProductResource;
use App\Filament\Resources\TrainingSubscriptions\TrainingSubscriptionResource;
use App\Filament\Resources\Users\UserResource;
use App\Models\Court;
use App\Models\Product;
use App\Models\TrainingSubscription;
use App\Models\User;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends StatsOverviewWidget
{
  protected function getStats(): array
  {
    return [
      Stat::make('إجمالي المستخدمين', User::count())
        ->description('المستخدمين المسجلين في النظام')
        ->descriptionIcon('heroicon-m-users')
        ->chart([7, 2, 10, 3, 15, 4, 17])
        ->color('info')
        ->url(UserResource::getUrl('index')),

      Stat::make('الاشتراكات النشطة', TrainingSubscription::count())
        ->description('نمو الاشتراكات التدريبية')
        ->descriptionIcon('heroicon-m-arrow-trending-up')
        ->chart([1, 5, 2, 10, 13, 15, 20])
        ->color('success')
        ->url(TrainingSubscriptionResource::getUrl('index')),

      Stat::make('إجمالي المنتجات', Product::count())
        ->description('المنتجات المتوفرة في المتجر')
        ->descriptionIcon('heroicon-m-shopping-bag')
        ->color('warning')
        ->url(ProductResource::getUrl('index')),

      Stat::make('عدد الملاعب', Court::count())
        ->description('الملاعب المتاحة للحجز')
        ->descriptionIcon('heroicon-m-trophy')
        ->color('primary')
        ->url(CourtResource::getUrl('index')),
    ];
  }
}