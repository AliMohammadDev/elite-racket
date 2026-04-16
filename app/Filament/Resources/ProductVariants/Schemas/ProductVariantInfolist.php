<?php

namespace App\Filament\Resources\ProductVariants\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\ImageEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Grid;
use Filament\Infolists\Components\RepeatableEntry;
use Filament\Schemas\Schema;
use Filament\Support\Enums\TextSize;

class ProductVariantInfolist
{
  public static function configure(Schema $schema): Schema
  {
    return $schema
      ->components([

        Section::make('معلومات الخيار')
          ->schema([
            Grid::make(3)
              ->schema([
                TextEntry::make('product.name')
                  ->label('المنتج')
                  ->size(TextSize::Large),

                TextEntry::make('color.color')
                  ->label('اللون')
                  ->size(TextSize::Large),

                TextEntry::make('size.size')
                  ->label('الحجم')
                  ->size(TextSize::Large),

                TextEntry::make('price')
                  ->money('USD', locale: 'en')
                  ->label('السعر')
                  ->color('primary')
                  ->size(TextSize::Large),

                TextEntry::make('discount')
                  ->suffix('%')
                  ->label('الخصم')
                  ->color('primary')

                  ->size(TextSize::Large),

                TextEntry::make('final_price')
                  ->label('السعر النهائي')
                  ->money('USD', locale: 'en')
                  ->color('success')


                  ->size(TextSize::Large),

                TextEntry::make('stock_quantity')
                  ->label('المخزون')
                  ->size(TextSize::Large),

                TextEntry::make('sku')
                  ->label('SKU')
                  ->size(TextSize::Large),

                TextEntry::make('barcode')
                  ->label('Barcode')
                  ->size(TextSize::Large)
                  ->placeholder('-'),
              ]),
          ]),

        Section::make('معرض الصور')
          ->schema([
            RepeatableEntry::make('images')
              ->hiddenLabel()
              ->schema([
                ImageEntry::make('image')
                  ->disk('public')

                  ->circular()
                  ->size(100)
                  ->extraImgAttributes([
                    'class' => 'shadow-md border border-gray-200',
                  ])
                  ->getStateUsing(fn($record) => $record->image_url)
              ])
              ->grid(4)
              ->contained(false),
          ])
          ->collapsed(false),

        Section::make('معلومات إضافية')
          ->schema([
            Grid::make(2)
              ->schema([
                TextEntry::make('created_at')
                  ->label('تاريخ الإنشاء')
                  ->dateTime()
                  ->badge()
                  ->size(TextSize::Large)
                  ->color('success')
                  ->extraAttributes([
                    'class' => 'rounded-full px-4 py-2 text-center'
                  ]),

                TextEntry::make('updated_at')
                  ->label('آخر تحديث')
                  ->dateTime()
                  ->badge()
                  ->size(TextSize::Large)
                  ->color('info')
                  ->extraAttributes([
                    'class' => 'rounded-full px-4 py-2 text-center'
                  ]),
              ])
              ->gap(4),
          ])
      ]);
  }
}