<?php

namespace App\Filament\Resources\Couches\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class CouchForm
{
  public static function configure(Schema $schema): Schema
  {
    return $schema
      ->components([
        Section::make('معلومات الكوتش')
          ->schema([
            Grid::make(2)->schema([
              // حقول الاسم بلغات متعددة
              TextInput::make('name.ar')
                ->label('الاسم (بالعربية)')
                ->required(),
              TextInput::make('name.en')
                ->label('Name (English)')
                ->required(),
            ]),

            Grid::make(2)->schema([
              Select::make('user_id')
                ->label('المستخدم المرتبط')
                ->relationship('user', 'name') 
                ->searchable()
                ->preload()
                ->required(),

              TextInput::make('phone')
                ->label('رقم الهاتف')
                ->tel()
                ->required(),
            ]),

            Grid::make(2)->schema([
              TextInput::make('address.ar')
                ->label('العنوان (بالعربية)')
                ->required(),
              TextInput::make('address.en')
                ->label('Address (English)')
                ->required(),
            ]),
          ])
      ])->columns(1);
  }
}
