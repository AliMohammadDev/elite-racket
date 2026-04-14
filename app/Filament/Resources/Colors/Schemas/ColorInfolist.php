<?php

namespace App\Filament\Resources\Colors\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;
use Filament\Schemas\Components\Section;
use Filament\Infolists\Components\ColorEntry;
use Filament\Support\Enums\FontWeight;

use Filament\Support\Enums\TextSize;


class ColorInfolist
{
  public static function configure(Schema $schema): Schema
  {
    return $schema
      ->components([
        Section::make('تفاصيل اللون')
          ->schema([
            TextEntry::make('color')
              ->label('اسم اللون')
              ->weight(FontWeight::Bold)
              ->size(TextSize::Large),

            ColorEntry::make('hex_code')
              ->label('الدرجة اللونية'),

            TextEntry::make('hex_code')
              ->label('كود الـ HEX')
              ->size(TextSize::Large)
              ->copyable(),
          ])->columns(3),
      ])->columns(1);
  }
}
