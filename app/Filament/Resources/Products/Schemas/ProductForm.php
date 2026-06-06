<?php

namespace App\Filament\Resources\Products\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\RichEditor;
use Filament\Schemas\Components\Grid;
use Filament\Forms\Components\Toggle;
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
              ->label('الصنف')
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

            Toggle::make('is_featured')
              ->label('منتج مميز (Featured)')
              ->default(false)
              ->columnSpanFull(),
          ])

      ])->columns(1);
  }
}
