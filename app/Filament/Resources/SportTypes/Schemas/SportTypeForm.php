<?php

namespace App\Filament\Resources\SportTypes\Schemas;

use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Forms\Components\Textarea;

class SportTypeForm
{
  public static function configure(Schema $schema): Schema
  {
    return $schema
      ->components([
        Section::make('معلومات أنواع الرياضية الأساسية')
          ->schema([
            Grid::make(2)
              ->schema([
                TextInput::make('name.ar')
                  ->label('اسم المنتج (بالعربية)')
                  ->required(),

                TextInput::make('name.en')
                  ->label('Product Name (EN)')
                  ->required(),
              ]),

            Textarea::make('body.ar')
              ->label('وصف المنتج (بالعربية)')
              ->columnSpanFull()
              ->rows(5),

            Textarea::make('body.en')
              ->label('Product Description (EN)')
              ->columnSpanFull()
              ->rows(5),
          ])

      ])->columns(1);
  }
}
