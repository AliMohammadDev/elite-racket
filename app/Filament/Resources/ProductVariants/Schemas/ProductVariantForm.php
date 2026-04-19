<?php

namespace App\Filament\Resources\ProductVariants\Schemas;

use App\Models\Color;
use App\Models\Size;
use Filament\Actions\Action;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Repeater;
use Filament\Schemas\Components\Actions;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Grid;
use Filament\Forms\Components\Select;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductVariantForm
{
  public static function configure(Schema $schema): Schema
  {
    return $schema
      ->schema([
        Section::make('تعديل بيانات الخيار')
          ->visible(fn($context) => in_array($context, ['edit', 'view']))
          ->schema([
            Grid::make(3)
              ->schema([
                Select::make('color_id')
                  ->label('اللون')
                  ->options(Color::pluck('color', 'id'))
                  ->searchable()
                  ->required(),
                Select::make('size_id')
                  ->label('الحجم')
                  ->options(Size::pluck('size', 'id'))
                  ->searchable()
                  ->required(),


                TextInput::make('sku')
                  ->label('رمز الـ SKU')
                  ->placeholder('مثال: SHIRT-RED-L')
                  ->unique(ignoreRecord: true)
                  ->required()
                  ->live()
                  ->helperText('هذا الرمز الإداري الخاص بالخيار')
                  ->extraInputAttributes(['style' => 'text-transform: uppercase'])
                  ->dehydrateStateUsing(fn($state) => strtoupper($state)),


                // TextInput::make('sku')
                //   ->label('رمز الـ SKU')
                //   ->unique(ignoreRecord: true)
                //   ->required()
                //   ->live()
                //   ->dehydrateStateUsing(fn($state) => strtoupper($state)),

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
              ]),


            // edit image
            Repeater::make('images')
              ->relationship('images')
              ->key('variant_images_list')
              ->label('صور الخيار')
              ->schema([
                FileUpload::make('image')
                  ->label('الصورة')
                  ->image()
                  ->disk('public')
                  ->directory(function ($get) {
                    $variantId = $get('../../product_variant_id')
                      ?? $get('../../id');
                    return "product_variants/{$variantId}";
                  })
                  ->visibility('public')
                  ->required()
                  ->getUploadedFileNameForStorageUsing(
                    fn($file) => (string) Str::uuid() . '.webp'
                  )
                  ->imageEditor()



                  ->formatStateUsing(function ($state, $record) {
                    if (blank($state)) {
                      return null;
                    }
                    return "product_variants/{$record->product_variant_id}/{$state}";
                  })
                  ->dehydrateStateUsing(function ($state) {
                    if (blank($state)) {
                      return null;
                    }
                    return is_array($state)
                      ? basename(array_values($state)[0])
                      : basename($state);
                  })

              ])
              ->saveRelationshipsUsing(function ($record, $state) {
                $existingImages = $record->images;
                $newItems = collect($state);

                foreach ($existingImages as $existingImage) {
                  $stillExists = $newItems->contains(fn($item) => ($item['id'] ?? null) == $existingImage->id);

                  if (!$stillExists) {
                    $filePath = "product_variants/{$record->id}/{$existingImage->image}";
                    if (Storage::disk('public')->exists($filePath)) {
                      Storage::disk('public')->delete($filePath);
                    }
                    $existingImage->delete();
                  }
                }

                foreach ($state as $item) {
                  $imageValue = $item['image'] ?? null;
                  if (!$imageValue)
                    continue;

                  $cleanName = is_array($imageValue) ? basename(array_values($imageValue)[0]) : basename($imageValue);

                  if (isset($item['id'])) {
                    $record->images()->where('id', $item['id'])->update(['image' => $cleanName]);
                  } else {
                    $record->images()->create(['image' => $cleanName]);
                  }
                }
              })

              ->grid(3)
              ->columnSpanFull(),
          ])

          ->columnSpanFull(),

        Section::make('أدوات التوليد السريع')
          ->visible(fn($context) => $context === 'create')
          ->schema([
            Grid::make(3)
              ->schema([
                Select::make('temp_colors')
                  ->label('الألوان')
                  ->multiple()
                  ->options(Color::pluck('color', 'id'))
                  ->live()
                  ->dehydrated(false),
                Select::make('temp_sizes')
                  ->label('الأحجام')
                  ->multiple()
                  ->options(Size::pluck('size', 'id'))
                  ->live()
                  ->dehydrated(false),
              ]),
          ])->columnSpanFull(),
        Actions::make([
          Action::make('generate_variants')
            ->label('توليد الخيارات')
            ->icon('heroicon-o-sparkles')
            ->color('success')
            ->visible(fn($context) => $context === 'create')
            ->action(function ($get, $set) {
              $colors = $get('temp_colors') ?? [];
              $sizes = $get('temp_sizes') ?? [];
              $variants = [];
              foreach ($colors as $colorId) {
                foreach ($sizes as $sizeId) {
                  $variants[] = [
                    'color_id' => $colorId,
                    'size_id' => $sizeId,
                    'stock_quantity' => 0,
                    'price' => 0,
                  ];
                }
              }
              $set('variants', $variants);
            }),
        ]),

        Select::make('product_id')
          ->label('المنتج')
          ->relationship('product', 'id')
          ->searchable()
          ->preload()
          ->getOptionLabelFromRecordUsing(fn($record) => $record->name[app()->getLocale()] ?? $record->name['en'] ?? '')
          ->required()
          ->visible(fn($context) => $context === 'create')
          ->columnSpanFull(),



        Repeater::make('variants')
          ->label('قائمة الخيارات')
          ->visible(fn($context) => $context === 'create')
          ->schema([
            Grid::make(2)
              ->schema([
                Select::make('color_id')
                  ->label('اللون')
                  ->options(Color::pluck('color', 'id'))
                  ->required(),

                Select::make('size_id')
                  ->label('الحجم')
                  ->options(Size::pluck('size', 'id'))
                  ->required(),

                TextInput::make('sku')
                  ->label('SKU')
                  ->required()
                  ->unique(table: 'product_variants', column: 'sku')
                  ->extraInputAttributes(['style' => 'text-transform: uppercase'])
                  ->dehydrateStateUsing(fn($state) => strtoupper($state)),

                TextInput::make('barcode')
                  ->label('الباركود')
                  ->unique(table: 'product_variants', column: 'barcode')
                  ->prefixIcon('heroicon-m-qr-code')
                  ->placeholder('barcode'),


                TextInput::make('price')
                  ->label('السعر')
                  ->numeric()->required(),

                TextInput::make('stock_quantity')
                  ->label('الكمية')
                  ->numeric()->required(),

                FileUpload::make('images')
                  ->label('الصور')
                  ->multiple()
                  ->reorderable()
                  ->image()
                  ->directory('temp_variants')
                  ->columnSpan(2)
                  ->disk('public')
              ]),
          ])
          ->columnSpanFull()
          ->collapsible(),
      ]);
  }
}
