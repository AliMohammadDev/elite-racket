<?php

namespace App\Filament\Resources\TrainingPrograms\Schemas;

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
          ->schema([
            Grid::make(2)->schema([
              TextEntry::make('translated_name')
                ->label('اسم البرنامج')
                ->weight('bold'),
              TextEntry::make('train_level')
                ->label('المستوى')
                ->size(TextSize::Large)
                ->badge(),
              TextEntry::make('couch.translated_name')
                ->size(TextSize::Large)
                ->label('الكوتش'),
            ]),

            Grid::make(2)->schema([
              TextEntry::make('price')
                ->label('السعر الأصلي')
                ->size(TextSize::Large)
                ->money('USD', locale: 'en'),
              TextEntry::make('discounts')
                ->label('الخصم')
                ->size(TextSize::Large)
                ->suffix('%'),
              TextEntry::make('final_price')
                ->label('السعر النهائي')
                ->size(TextSize::Large)
                ->money('USD', locale: 'en')
                ->color('success')->badge(),
            ]),
          ]),
      ]);
  }
}
