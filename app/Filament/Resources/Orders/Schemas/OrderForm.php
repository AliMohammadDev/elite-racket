<?php

namespace App\Filament\Resources\Orders\Schemas;

use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class OrderForm
{
  public static function configure(Schema $schema): Schema
  {
    return $schema->components([
      Section::make('تفاصيل الطلب')->schema([
        Placeholder::make('customer_name')
          ->label('العميل')
          ->content(fn($record): string => $record->user?->name ?? 'غير معروف'), 
        TextInput::make('total_price')
          ->label('الإجمالي')
          ->prefix('$')
          ->disabled(),
        Select::make('status')
          ->label('حالة الطلب')
          ->options([
            'pending' => 'قيد الانتظار',
            'completed' => 'مكتمل',
            'cancelled' => 'ملغي',
          ])
          ->required(),
      ])->columns(2),
    ])->columns(1);
  }
}