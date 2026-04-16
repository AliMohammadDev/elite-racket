<?php

namespace App\Filament\Resources\Categories\Schemas;

use Filament\Infolists\Components\SpatieMediaLibraryImageEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Group;
use Filament\Support\Enums\FontWeight;
use Filament\Support\Enums\TextSize;


class CategoryInfolist
{
  public static function configure(Schema $schema): Schema
  {
    return $schema
      ->components([


        Grid::make(2)
          ->schema([
            Group::make()
              ->schema([
                Section::make('معلومات الصنف الأساسية')
                  ->icon('heroicon-o-information-circle')
                  ->schema([
                    Grid::make(2)
                      // name
                      ->schema([
                        TextEntry::make('name.ar')
                          ->label('الاسم (العربية)')
                          ->weight('bold')
                          ->color('primary')
                          ->size(TextSize::Large),

                        TextEntry::make('name.en')
                          ->label('Name (English)')
                          ->weight('bold')
                          ->size(TextSize::Large),
                      ]),

                    Grid::make(1)
                      // description
                      ->schema([
                        TextEntry::make('description.ar')
                          ->label('الوصف بالعربية')
                          ->color('primary')
                          ->placeholder('لا يوجد وصف متاح باللغة العربية.')
                          ->size(TextSize::Large),

                        TextEntry::make('description.en')
                          ->label('Description (EN)')
                          ->placeholder('No English description available.')
                          ->size(TextSize::Large),
                      ]),
                  ]),
              ])->columnSpan(2),
          ]),


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


      ]);
  }
}