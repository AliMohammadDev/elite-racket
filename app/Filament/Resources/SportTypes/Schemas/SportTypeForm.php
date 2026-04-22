<?php

namespace App\Filament\Resources\SportTypes\Schemas;

use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

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

            RichEditor::make('body.ar')
              ->label('وصف المنتج (بالعربية)')
              ->columnSpanFull(),

            RichEditor::make('body.en')
              ->label('Product Description (EN)')
              ->columnSpanFull(),
          ])

      ])->columns(1);
  }
}
