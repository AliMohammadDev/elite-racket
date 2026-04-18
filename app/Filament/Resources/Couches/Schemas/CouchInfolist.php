<?php

namespace App\Filament\Resources\Couches\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Enums\FontWeight;
use Filament\Support\Enums\TextSize;

class CouchInfolist
{
  public static function configure(Schema $schema): Schema
  {
    return $schema
      ->components([

        Section::make('معلومات الكابتن الأساسية')
          ->icon('heroicon-o-user-circle')
          ->schema([
            Grid::make(2)
              ->schema([
                TextEntry::make('translated_name')
                  ->label('الاسم الكامل')
                  ->weight(FontWeight::Bold)
                  ->color('primary'),

                TextEntry::make('user.email')
                  ->label('البريد الإلكتروني')
                  ->icon('heroicon-m-envelope')
                  ->size(TextSize::Large)
                  ->copyable(),

                TextEntry::make('phone')
                  ->label('رقم الهاتف')
                  ->icon('heroicon-m-phone')
                  ->copyable()
                  ->size(TextSize::Large),
              ]),
          ]),

        Grid::make(1)
          ->schema([
            Section::make('العنوان والموقع')
              ->icon('heroicon-o-map-pin')
              ->schema([
                TextEntry::make('translated_address')
                  ->label('العنوان الحالي')
                  ->placeholder('غير محدد')
                  ->size(TextSize::Large),
              ])->columnSpan(1),
          ]),


        Section::make('معلومات إضافية')
          ->schema([
            Grid::make(2)
              ->schema([
                TextEntry::make('created_at')
                  ->label('تاريخ الإنشاء')
                  ->dateTime()
                  ->badge()
                  ->size(TextSize::Large)
                  ->color('success')
                  ->extraAttributes([
                    'class' => 'rounded-full px-4 py-2 text-center'
                  ]),

                TextEntry::make('updated_at')
                  ->label('آخر تحديث')
                  ->dateTime()
                  ->badge()
                  ->size(TextSize::Large)
                  ->color('info')
                  ->extraAttributes([
                    'class' => 'rounded-full px-4 py-2 text-center'
                  ]),
              ])
              ->gap(4),
          ])

      ]);
  }
}