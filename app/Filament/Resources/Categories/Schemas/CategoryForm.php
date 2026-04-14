<?php

namespace App\Filament\Resources\Categories\Schemas;

use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class CategoryForm
{
  public static function configure(Schema $schema): Schema
  {
    return $schema
      ->components([
        Section::make('Basic Information')
          ->schema([
            TextInput::make('name.ar')
              ->label('الاسم بالعربية')
              ->required(),
            TextInput::make('name.en')
              ->label('Name in English')
              ->required(),

            Textarea::make('description.ar')
              ->label('الوصف بالعربية'),
            Textarea::make('description.en')
              ->label('Description in English'),
          ])->columns(2),

        Section::make('Media')
          ->schema([
            SpatieMediaLibraryFileUpload::make('image')
              ->collection('categories')
              ->disk('public')
              ->image()
              ->multiple()
              ->reorderable()
              ->columnSpanFull(),
          ]),
      ]);
  }
}
