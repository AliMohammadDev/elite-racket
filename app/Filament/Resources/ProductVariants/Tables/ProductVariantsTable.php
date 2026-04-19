<?php

namespace App\Filament\Resources\ProductVariants\Tables;

use App\Models\Product;
use App\Models\ProductVariant;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Filament\Support\Enums\TextSize;
use Filament\Tables\Columns\ColorColumn;

class ProductVariantsTable
{
  public static function configure(Table $table): Table
  {
    return $table
      ->columns([
        ImageColumn::make('images.image')
          ->label('الصورة')
          ->circular()
          ->stacked()
          ->getStateUsing(function ($record) {
            if (!$record->images) {
              return [];
            }
            return $record->images->map(function ($img) use ($record) {
              $imageName = $img->image;
              $newPath = "product_variants/{$record->id}/{$imageName}";
              if (str_contains($imageName, 'product_variants/')) {
                return $imageName;
              }
              return $newPath;
            })->toArray();
          })
          ->disk('public'),


        TextColumn::make('product.name')
          ->label('المنتج')
          ->getStateUsing(function (ProductVariant $record) {
            $name = $record->product?->name;
            if (is_array($name)) {
              return $name[app()->getLocale()] ?? $name['en'] ?? '';
            }
            return $name ?? '';
          })
          ->size(TextSize::Large)
          ->sortable()
          ->searchable(),


        ColorColumn::make('color.hex_code')
          ->label('اللون')
          ->sortable(),


        TextColumn::make('size.size')
          ->label('المقاس')
          ->searchable()
          ->sortable()
          ->size(TextSize::Large),

        TextColumn::make('price')
          ->label('السعر')
          ->money('USD', locale: 'en_US')
          ->size(TextSize::Large)
          ->sortable(),

        TextColumn::make('discount')
          ->label('الخصم')
          ->numeric()
          ->sortable(),


        TextColumn::make('stock_quantity')
          ->label('الكمية')
          ->size(TextSize::Large)
          ->sortable()
          ->searchable(),

        TextColumn::make('price')
          ->label('السعر')
          ->money('USD', locale: 'en_US')
          ->size(TextSize::Large)
          ->sortable()
          ->searchable(),

        TextColumn::make('discount')
          ->label('الخصم')
          ->formatStateUsing(function ($state) {
            if (is_null($state) || $state === '') {
              return '0%';
            }
            $number = floatval($state);
            $formatted = rtrim(rtrim(number_format($number, 2), '0'), '.');
            if (intval($number) == $number) {
              $formatted = intval($number);
            }
            return $formatted . '%';
          })
          ->sortable()
          ->size(TextSize::Large)
          ->searchable(),

        TextColumn::make('final_price')
          ->label('السعر النهائي')
          ->getStateUsing(fn($record) => $record->final_price)
          ->money('USD', locale: 'en_US')
          ->weight('bold')
          ->color('success')
          ->size(TextSize::Large)
          ->description('السعر بعد تطبيق الخصم'),

        TextColumn::make('sku')
          ->copyable()
          ->label('SKU')
          ->size(TextSize::Large)
          ->searchable(),

        TextColumn::make('barcode')
          ->copyable()
          ->label('باركود')
          ->size(TextSize::Large)
          ->searchable(),

      ])
      ->filters([
        SelectFilter::make('product_id')
          ->label('المنتج')
          ->relationship('product', 'id')
          ->getOptionLabelFromRecordUsing(fn(Product $record) => $record->name[app()->getLocale()] ?? $record->name['en'] ?? '')
          ->searchable()
          ->preload(),

        SelectFilter::make('color')
          ->label('اللون')
          ->relationship('color', 'color')
          ->searchable()
          ->preload(),

        SelectFilter::make('size')
          ->label('الحجم')
          ->relationship('size', 'size')
          ->searchable()
          ->preload(),

      ])
      ->recordActions([
        ViewAction::make(),
        EditAction::make(),
      ])
      ->toolbarActions([
        BulkActionGroup::make([
          DeleteBulkAction::make(),
        ]),
      ])->defaultSort('created_at', 'desc');
  }
}