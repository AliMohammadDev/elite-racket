<?php

namespace App\Filament\Resources\CourtBookings\Schemas;

use Filament\Infolists\Components\RepeatableEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Enums\FontWeight;
use Filament\Support\Enums\TextSize;

class CourtBookingInfolist
{
  public static function configure(Schema $schema): Schema
  {
    return $schema
      ->components([

        Section::make('الساعات المحجوزة')
          ->icon('heroicon-o-clock')
          ->description('جميع الفترات الزمنية لهذا الحجز')
          ->schema([
            RepeatableEntry::make('times')
              ->label('المواعيد المحجوزة')
              ->schema([
                TextEntry::make('from')
                  ->label('من')
                  ->time('h:i A')
                  ->badge()
                  ->color('success')
                  ->size(TextSize::Large),
                TextEntry::make('to')
                  ->label('إلى')
                  ->time('h:i A')
                  ->badge()
                  ->color('info')
                  ->size(TextSize::Large),

              ])->columns(2),

          ])->columns(1),


        Section::make('معلومات الحجز')
          ->icon('heroicon-o-information-circle')
          ->schema([
            Grid::make(3)->schema([
              TextEntry::make('user.name')
                ->label('👤 العميل')
                ->weight(FontWeight::Bold)
                ->size(TextSize::Large),
              TextEntry::make('court.translated_name')
                ->label('🏟️ الملعب')
                ->color('primary')
                ->size(TextSize::Large),
              TextEntry::make('booking_date')
                ->label('📅 التاريخ')
                ->date('d M Y')
                ->color('gray')
                ->size(TextSize::Large),
            ]),



            Grid::make(2)->schema([
              TextEntry::make('total_price')
                ->label('💰 الإجمالي')
                ->money('USD', locale: 'en')
                ->size(TextSize::Large)
                ->weight(FontWeight::Bold)
                ->color('success'),

              TextEntry::make('status')
                ->label('📌 الحالة')
                ->size(TextSize::Large)
                ->color(fn(string $state): string => match ($state) {
                  'approved' => 'success',
                  'pending' => 'warning',
                  'rejected' => 'danger',
                  'completed' => 'info',
                  default => 'gray',
                }),
            ]),

          ])->columns(1),

      ]);
  }
}