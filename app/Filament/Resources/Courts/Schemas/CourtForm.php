<?php

namespace App\Filament\Resources\Courts\Schemas;

use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class CourtForm
{
  public static function configure(Schema $schema): Schema
  {
    return $schema
      ->components([
        Section::make('معلومات الملعب')
          ->schema([
            Grid::make(2)->schema([
              TextInput::make('name.ar')
                ->label('الاسم (بالعربية)')
                ->required(),
              TextInput::make('name.en')
                ->label('Name (English)')
                ->required(),
            ]),
            Grid::make(2)
              ->schema([
                TextInput::make('price')
                  ->label('السعر الأساسي')
                  ->numeric()
                  ->prefix('$')
                  ->required(),
                TextInput::make('discounts')
                  ->label('الخصم (%)')
                  ->numeric()
                  ->default(0)
                  ->maxValue(100),
              ]),
          ]),
        Section::make('الصور')
          ->schema([
            SpatieMediaLibraryFileUpload::make('image')
              ->collection('courts')
              ->disk('public')
              ->image()
              ->multiple()
              ->reorderable()
              ->columnSpanFull(),
          ]),
      ])->columns(1);
  }
}
