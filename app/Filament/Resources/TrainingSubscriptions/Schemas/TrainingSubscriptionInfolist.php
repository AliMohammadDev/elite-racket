<?php

namespace App\Filament\Resources\TrainingSubscriptions\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Enums\FontWeight;
use Filament\Support\Enums\TextSize;

class TrainingSubscriptionInfolist
{
  public static function configure(Schema $schema): Schema
  {
    return $schema
      ->components([
        Section::make('بيانات الاشتراك')
          ->icon('heroicon-o-identification')
          ->schema([
            Grid::make(3)
              ->schema([
                TextEntry::make('user.name')
                  ->label('اسم المتدرب')
                  ->weight(FontWeight::Bold)
                  ->color('primary')
                  ->icon('heroicon-m-user'),

                TextEntry::make('trainingProgram.name.' . app()->getLocale())
                  ->label('البرنامج التدريبي')
                  ->size(TextSize::Large)
                  ->badge()
                  ->color('info'),

                TextEntry::make('trainingProgram.train_level')
                  ->label('مستوى البرنامج')
                  ->badge()
                  ->size(TextSize::Large)

                  ->weight(FontWeight::Bold)
                  ->color(fn(string $state): string => match ($state) {
                    'beginner' => 'success',
                    'intermediate' => 'warning',
                    'advanced' => 'danger',
                    default => 'gray',
                  })
                  ->formatStateUsing(fn(string $state): string => match ($state) {
                    'beginner' => '🌱 مبتدئ',
                    'intermediate' => '⚡ متوسط',
                    'advanced' => '🔥 متقدم',
                    default => $state,
                  }),

              ]),
          ]),

        Grid::make(1)
          ->schema([
            Section::make('المسؤول عن التدريب')
              ->icon('heroicon-o-academic-cap')
              ->schema([
                Grid::make(2)
                  ->schema([
                    TextEntry::make('trainingProgram.couch.name.' . app()->getLocale())
                      ->label('الكابتن')
                      ->size(TextSize::Large)
                      ->placeholder('لم يتم تحديد كابتن'),

                    TextEntry::make('trainingProgram.couch.phone')
                      ->label('هاتف التواصل')
                      ->icon('heroicon-m-phone')
                      ->size(TextSize::Large)

                      ->copyable(),
                  ]),
              ])->columnSpan(1),
          ]),


        Section::make('تفاصيل التوقيت والمالية')
          ->icon('heroicon-o-clock')
          ->schema([
            Grid::make(2)
              ->schema([
                TextEntry::make('created_at')
                  ->label('تاريخ بدء الاشتراك')
                  ->dateTime()
                  ->size(TextSize::Large)

                  ->icon('heroicon-m-calendar-days'),

                TextEntry::make('trainingProgram.final_price')
                  ->label('قيمة الاشتراك')
                  ->money('USD', locale: 'en')
                  ->size(TextSize::Large)

                  ->weight(FontWeight::Bold)
                  ->color('success'),
              ]),
          ])->columnSpan(1),
      ]);
  }
}