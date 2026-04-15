<?php

namespace App\Filament\Resources\ProductVariants\Schemas;

use Filament\Actions\Action;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;
use Filament\Forms\Components\Repeater;
use Filament\Schemas\Components\Grid;
use Filament\Forms\Components\Select;
use Filament\Schemas\Components\Actions;
use Filament\Schemas\Components\Section;


class ProductVariantForm
{
  public static function configure(Schema $schema): Schema
  {
    return $schema
      ->schema([
        Section::make('أدوات التوليد السريع')
          ->visible(fn($context) => $context === 'create')
          ->schema([
            Grid::make(2)
              ->schema([
                Select::make('temp_colors')
                  ->label('الألوان المتاحة')
                  ->multiple()
                  ->options(\App\Models\Color::pluck('color', 'id'))
                  ->preload()
                  ->live()
                  ->dehydrated(false),

                Select::make('temp_sizes')
                  ->label('المقاسات المتاحة')
                  ->multiple()
                  ->options(\App\Models\Size::pluck('size', 'id'))
                  ->preload()
                  ->live()
                  ->dehydrated(false),
              ]),

            Actions::make([
              Action::make('generate_variants')
                ->label('توليد الخيارات تلقائياً')
                ->icon('heroicon-o-sparkles')
                ->color('success')
                ->action(function ($get, $set) {
                  $colors = $get('temp_colors') ?? [];
                  $sizes = $get('temp_sizes') ?? [];

                  if (empty($colors) || empty($sizes))
                    return;

                  $variants = [];
                  foreach ($colors as $colorId) {
                    foreach ($sizes as $sizeId) {
                      $variants[] = [
                        'color_id' => $colorId,
                        'size_id' => $sizeId,
                        'stock_quantity' => 0,
                        'price' => 0,
                        'discount' => 0,
                      ];
                    }
                  }
                  $set('variants', $variants);
                }),
            ]),
          ]),

        Select::make('product_id')
          ->label('المنتج')
          ->relationship('product', 'name')
          ->getOptionLabelFromRecordUsing(fn($record) => $record->name['ar'] ?? $record->name['en'])
          ->required()
          ->searchable()
          ->preload()
          ->visible(fn($context) => $context === 'create')
          ->columnSpanFull(),

        Repeater::make('variants')
          ->label('قائمة الخيارات الناتجة')
          ->visible(fn($context) => $context === 'create')
          ->schema([
            Grid::make(3)
              ->schema([
                Select::make('color_id')
                  ->label('اللون')
                  ->options(\App\Models\Color::pluck('color', 'id'))
                  ->required(),
                Select::make('size_id')
                  ->label('المقاس')
                  ->options(\App\Models\Size::pluck('size', 'id'))
                  ->required(),
                TextInput::make('price')
                  ->label('السعر')
                  ->numeric()
                  ->required(),
                TextInput::make('discount')
                  ->label('الخصم %')
                  ->numeric()
                  ->default(0),
                TextInput::make('stock_quantity')
                  ->label('الكمية')
                  ->numeric()
                  ->required(),
                TextInput::make('sku')
                  ->label('SKU (اختياري)')
                  ->placeholder('سيولد تلقائياً إن تركته فارغاً'),
              ]),
          ])
          ->columnSpanFull()
          ->collapsible(),

        Section::make('تعديل بيانات الخيار')
          ->visible(fn($context) => $context === 'edit' || $context === 'view')
          ->schema([
            Grid::make(2)
              ->schema([
                Select::make('color_id')
                  ->label('اللون')
                  ->relationship('color', 'color')
                  ->required(),
                Select::make('size_id')
                  ->label('المقاس')
                  ->relationship('size', 'size')
                  ->required(),
                TextInput::make('price')->numeric()->required(),
                TextInput::make('stock_quantity')->numeric()->required(),
                TextInput::make('sku')->disabled(),
              ]),
          ]),
      ]);
  }
}
