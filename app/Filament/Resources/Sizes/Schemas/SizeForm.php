<?php

namespace App\Filament\Resources\Sizes\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class SizeForm
{
  public static function configure(Schema $schema): Schema
  {
    return $schema
      ->components([
        TextInput::make('size')
          ->required()
          ->unique(ignoreRecord: true)
          ->maxLength(255),
      ])  ->columns(1);
  }
}
