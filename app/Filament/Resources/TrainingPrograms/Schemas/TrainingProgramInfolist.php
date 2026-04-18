<?php

namespace App\Filament\Resources\TrainingPrograms\Schemas;

use Filament\Infolists\Components\SpatieMediaLibraryImageEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Enums\TextSize;

class TrainingProgramInfolist
{
  public static function configure(Schema $schema): Schema
  {
    return $schema
      ->components([
        Section::make('تفاصيل البرنامج التدريبي')
          ->icon('heroicon-o-information-circle')
          ->schema([
            Grid::make(3)->schema([
              TextEntry::make('translated_name')
                ->label('اسم البرنامج')
                ->size(TextSize::Large)
                ->weight('bold')
                ->color('primary'),

              TextEntry::make('train_level')
                ->label('مستوى التدريب')
                ->badge()
                ->color(fn(string $state): string => match ($state) {
                  'beginner' => 'success',
                  'intermediate' => 'warning',
                  'advanced' => 'danger',
                  default => 'gray',
                }),

              TextEntry::make('couch.name.' . app()->getLocale())
                ->label('الكوتش المسؤول')
                ->icon('heroicon-m-user-circle'),
            ]),

            Section::make('الجدول الزمني والسعة')
              ->compact()
              ->schema([
                Grid::make(3)->schema([
                  TextEntry::make('start_date')
                    ->label('تاريخ البدء')
                    ->date('d/m/Y')
                    ->icon('heroicon-m-calendar'),

                  TextEntry::make('end_date')
                    ->label('تاريخ الانتهاء')
                    ->date('d/m/Y')
                    ->icon('heroicon-m-flag'),

                  TextEntry::make('users_count')
                    ->label('السعة القصوى')
                    ->suffix(' مشترك')
                    ->weight('bold')
                    ->color('info')
                    ->icon('heroicon-m-users'),
                ]),
              ]),

            Section::make('المعلومات المالية')
              ->compact()
              ->schema([
                Grid::make(3)->schema([
                  TextEntry::make('price')
                    ->label('السعر الأصلي')
                    ->money('USD', locale: 'en'),

                  TextEntry::make('discounts')
                    ->label('قيمة الخصم')
                    ->money('USD', locale: 'en')
                    ->color('danger'),

                  TextEntry::make('final_price')
                    ->label('السعر النهائي')
                    ->money('USD', locale: 'en')
                    ->weight('black')
                    ->size(TextSize::Large)
                    ->badge()
                    ->color('success'),
                ]),
              ]),


            Section::make('صور القسم')
              ->icon('heroicon-o-photo')
              ->schema([
                SpatieMediaLibraryImageEntry::make('image')
                  ->collection('training_programs')
                  ->hiddenLabel()
                  ->circular()
                  ->stacked()
                  ->limit(5)
                  ->columnSpanFull()
                  ->extraImgAttributes([
                    'alt' => 'صورة القسم',
                    'class' => 'shadow-lg object-cover mx-auto',
                    'style' => 'width: 100px; height: 100px;',
                  ]),
              ]),

          ]),
      ])->columns(1);
  }
}
