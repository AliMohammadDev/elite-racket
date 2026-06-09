<?php

namespace App\Filament\Resources\Orders\Schemas;

use Filament\Infolists\Components\RepeatableEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Enums\TextSize; // استيراد مهم للتحكم بالحجم

class OrderInfolist
{
  public static function configure(Schema $schema): Schema
  {
    return $schema->components([
      Section::make('معلومات الطلب')
        ->schema([
          TextEntry::make('user.name')
            ->label('اسم العميل')
            ->size(TextSize::Large)
            ->weight('bold'),

          TextEntry::make('status')
            ->label('الحالة')
            ->badge()
            ->size(TextSize::Large),

          TextEntry::make('total_price')
            ->label('الإجمالي')
            ->money('USD')
            ->size(TextSize::Large)
            ->weight('bold'),
        ])->columns(3),

      Section::make('المنتجات المطلوبة')
        ->schema([
          RepeatableEntry::make('items')
            ->label('')
            ->schema([
              TextEntry::make('product.name')
                ->label('المنتج')
                ->size(TextSize::Large),

              TextEntry::make('quantity')
                ->label('الكمية')
                ->size(TextSize::Large),

              TextEntry::make('price')
                ->label('السعر')
                ->money('USD')
                ->size(TextSize::Large),
            ])->grid(3)
        ]),
    ]);
  }
}
