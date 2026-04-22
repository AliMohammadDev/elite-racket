<?php

namespace App\Filament\Resources\Products\Schemas;

use Filament\Infolists\Components\RepeatableEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Schema;
use Filament\Schemas\Components\Section;
use Filament\Support\Enums\FontWeight;
use Filament\Support\Enums\TextSize;

class ProductInfolist
{
  public static function configure(Schema $schema): Schema
  {
    return $schema
      ->components([
        Section::make('معلومات المنتج الأساسية')
          ->icon('heroicon-o-information-circle')
          ->schema([
            Grid::make(2)
              ->schema([
                TextEntry::make('name.ar')
                  ->label('الاسم (العربية)')
                  ->color('primary')
                  ->size(TextSize::Large),

                TextEntry::make('name.en')
                  ->label('Name (English)')
                  ->size(TextSize::Large),

                TextEntry::make('category_id')
                  ->label('القسم')
                  ->badge()
                  ->color('info')
                  ->size(TextSize::Large)
                  ->state(function ($record) {
                    return $record->category?->name['ar'] ?? $record->category?->name['en'] ?? 'غير مصنف';
                  }),

                TextEntry::make('created_at')
                  ->label('تاريخ الإضافة')
                  ->dateTime()
                  ->color('success')
                  ->size(TextSize::Large),
              ]),


            Section::make('وصف المنتج')
              ->icon('heroicon-o-document-text')

              ->schema([
                Grid::make(2)
                  ->schema([
                    TextEntry::make('body.ar')
                      ->label('الوصف بالعربية')
                      ->color('primary')
                      ->html()
                      ->placeholder('لا يوجد وصف متاح بالعربية')
                      ->size(TextSize::Large),

                    TextEntry::make('body.en')
                      ->label('Description (English)')
                      ->html()
                      ->placeholder('No English description available')
                      ->size(TextSize::Large),
                  ])
              ])
              ->collapsible(),
          ]),
      ])->columns(1);
  }
}