<?php

namespace App\Filament\Resources\SportTypes\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class SportTypeInfolist
{
  public static function configure(Schema $schema): Schema
  {
    return $schema
      ->components([
        Section::make('تفاصيل النوع الرياضي')
          ->schema([
            TextEntry::make('name.' . app()->getLocale())
              ->label('الاسم'),
            TextEntry::make('body.' . app()->getLocale())
              ->label('الوصف'),
          ])->columns(2)
      ])->columns(1);
  }
}