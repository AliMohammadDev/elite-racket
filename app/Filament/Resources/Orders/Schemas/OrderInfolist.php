<?php

namespace App\Filament\Resources\Orders\Schemas;

use Filament\Infolists\Components\RepeatableEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Enums\TextSize;

class OrderInfolist
{
  public static function configure(Schema $schema): Schema
  {
    return $schema->components([
      Section::make('معلومات الطلب')
        ->columns(3)
        ->schema([
          TextEntry::make('user.name')
            ->label('اسم العميل')
            ->size(TextSize::Large)
            ->weight('bold'),

          TextEntry::make('user.email')
            ->label('البريد الإلكتروني')
            ->size(TextSize::Large)
            ->icon('heroicon-o-envelope'),

          TextEntry::make('user.phone')
            ->label('رقم الهاتف')
            ->size(TextSize::Large)
            ->icon('heroicon-o-phone'),

          TextEntry::make('status')
            ->label('الحالة')
            ->badge()
            ->size(TextSize::Large),

          TextEntry::make('total_price')
            ->label('الإجمالي')
            ->formatStateUsing(fn($state) => '$' . number_format((float)$state, 2, '.', ','))
            ->size(TextSize::Large)
            ->weight('bold'),
        ])->columnSpanFull(),

      Section::make('المنتجات المطلوبة')
        ->schema([
          RepeatableEntry::make('items')
            ->label('')
            ->schema([
              Grid::make(3)
                ->schema([
                  TextEntry::make('product.name')->label('المنتج')->size(TextSize::Large),
                  TextEntry::make('quantity')->label('الكمية')->size(TextSize::Large),
                  TextEntry::make('price')
                    ->label('السعر')
                    ->formatStateUsing(fn($state) => '$' . number_format((float)$state, 2, '.', ','))
                    ->size(TextSize::Large),
                ]),
            ]),
        ])->columnSpanFull(),
    ]);
  }
}
