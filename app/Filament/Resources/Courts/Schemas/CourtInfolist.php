<?php

namespace App\Filament\Resources\Courts\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Enums\FontWeight;
use Filament\Support\Enums\TextSize;

class CourtInfolist
{
  public static function configure(Schema $schema): Schema
  {
    return $schema
      ->components([
        Section::make('تفاصيل الملعب')
          ->schema([
            Grid::make(3)->schema([
              TextEntry::make('translated_name')
                ->label('الاسم')
                ->weight(FontWeight::Bold)
                ->color('primary'),

              TextEntry::make('price')
                ->label('السعر')
                ->size(TextSize::Large)
                ->money('USD', locale: 'en'),

              TextEntry::make('discounts')
                ->label('الخصم')
                ->suffix('%')
                ->size(TextSize::Large)
                ->color('danger'),

              TextEntry::make('final_price')
                ->label('السعر النهائي')
                ->money('USD', locale: 'en')
                ->size(TextSize::Large)
                ->badge()
                ->color('success'),
            ]),
          ]),
      ]);
  }
}
