<?php

namespace App\Filament\Resources\Colors\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;
use Filament\Schemas\Components\Section;
use Filament\Infolists\Components\ColorEntry;
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
              ->weight('bold'),

            ColorEntry::make('hex_code')
              ->label('الدرجة اللونية'),

            TextEntry::make('hex_code')
              ->label('كود الـ HEX')
              ->copyable(),
          ])->columns(3),
      ]);
  }
}