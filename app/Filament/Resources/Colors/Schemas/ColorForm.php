<?php

namespace App\Filament\Resources\Colors\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;
use Filament\Forms\Components\ColorPicker;
use Filament\Schemas\Components\Section;

class ColorForm
{
  public static function configure(Schema $schema): Schema
  {
    return $schema
      ->components([
        Section::make('معلومات اللون')
          ->description('أدخل اسم اللون واختر الدرجة بدقة')
          ->schema([
            TextInput::make('color')
              ->label('اسم اللون')
              ->placeholder('yellow')
              ->required()
              ->maxLength(255),

            ColorPicker::make('hex_code')
              ->label('كود اللون (HEX)')
              ->required(),
          ])->columns(1),
      ])
      ->columns(1);
  }
}
