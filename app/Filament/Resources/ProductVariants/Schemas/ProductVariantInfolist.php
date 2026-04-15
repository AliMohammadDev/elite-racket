<?php

namespace App\Filament\Resources\ProductVariants\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class ProductVariantInfolist
{
  public static function configure(Schema $schema): Schema
  {
    return $schema
      ->components([
        TextEntry::make('product_id')
          ->numeric(),
        TextEntry::make('color_id')
          ->numeric(),
        TextEntry::make('size_id')
          ->numeric(),
        TextEntry::make('price')
          ->money(),
        TextEntry::make('discount')
          ->numeric(),
        TextEntry::make('stock_quantity')
          ->numeric(),
        TextEntry::make('sku')
          ->label('SKU'),
        TextEntry::make('barcode')
          ->placeholder('-'),
        TextEntry::make('created_at')
          ->dateTime()
          ->placeholder('-'),
        TextEntry::make('updated_at')
          ->dateTime()
          ->placeholder('-'),
      ]);
  }
}