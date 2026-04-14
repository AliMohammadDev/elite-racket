<?php

namespace App\Filament\Resources\Sizes\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Enums\FontWeight;
use Filament\Support\Enums\TextSize;


class SizeInfolist
{
  public static function configure(Schema $schema): Schema
  {
    return $schema
      ->components([
        Section::make('تفاصيل المقاس')
          ->icon('heroicon-o-arrows-pointing-out')
          ->schema([
            TextEntry::make('size')
              ->label('المقاس')
              ->weight('bold')
              ->color('primary')
              ->size(TextSize::Large),
          ]),

      ])->columns(1);
  }
}
