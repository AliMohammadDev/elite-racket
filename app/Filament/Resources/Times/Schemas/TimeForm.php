<?php

namespace App\Filament\Resources\Times\Schemas;

use Filament\Forms\Components\TimePicker;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class TimeForm
{
  public static function configure(Schema $schema): Schema
  {
    return $schema
      ->components([
        Section::make('تحديد الفترة الزمنية')
          ->description('قم بتحديد وقت بداية ونهاية الدوام أو الجلسة')
          ->schema([
            TimePicker::make('from')
              ->label('وقت البداية')
              ->seconds(false)
              ->displayFormat('h:i A')
              ->required(),

            TimePicker::make('to')
              ->label('وقت النهاية')
              ->seconds(false)
              ->displayFormat('h:i A')
              ->after('from')
              ->required(),
          ])->columns(2)
      ])->columns(1);
  }
}