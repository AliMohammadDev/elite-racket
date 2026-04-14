<?php

namespace App\Filament\Resources\Categories\Schemas;

use Filament\Infolists\Components\SpatieMediaLibraryImageEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Group;

class CategoryInfolist
{
  public static function configure(Schema $schema): Schema
  {
    return $schema
      ->components([
        Section::make('صور القسم')
          ->icon('heroicon-o-photo')
          ->schema([
            SpatieMediaLibraryImageEntry::make('image')
              ->collection('categories')
              ->hiddenLabel()
              ->circular()
              ->stacked()
              ->limit(5)
              ->columnSpanFull()
              ->extraImgAttributes([
                'alt' => 'صورة القسم',
                'class' => 'shadow-lg object-cover mx-auto',
                'style' => 'width: 100px; height: 100px;',
              ]),
          ]),

        Grid::make(3)
          ->schema([
            Group::make()
              ->schema([
                Section::make('معلومات الصنف الأساسية')
                  ->icon('heroicon-o-information-circle')
                  ->schema([
                    Grid::make(2)
                      ->schema([
                        TextEntry::make('name.ar')
                          ->label('الاسم (العربية)')
                          ->weight('bold')
                          ->color('primary'),

                        TextEntry::make('name.en')
                          ->label('Name (English)')
                          ->weight('bold')
                          ->color('primary')
                      ]),

                    Grid::make(1)
                      ->schema([
                        TextEntry::make('description.ar')
                          ->label('الوصف بالعربية')
                          ->prose()
                          ->placeholder('لا يوجد وصف متاح باللغة العربية.'),

                        TextEntry::make('description.en')
                          ->label('Description (EN)')
                          ->prose()
                          ->placeholder('No English description available.'),
                      ]),
                  ]),
              ])->columnSpan(2),


          ]),
      ]);
  }
}
