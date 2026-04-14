<?php

namespace App\Filament\Resources\Products\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\RichEditor;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;

class ProductForm
{
  public static function configure(Schema $schema): Schema
  {
    return $schema
      ->components([
        Section::make('معلومات المنتج الأساسية')
          ->schema([
            Select::make('category_id')
              ->label('القسم')
              ->relationship('category', 'name->ar')
              ->required()
              ->searchable()
              ->preload()
              ->columnSpanFull(),

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
          ->columns(1),
      ]);
  }
}