<?php

namespace App\Filament\Resources\Times\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Enums\FontWeight;
use Filament\Support\Enums\TextSize;

class TimeInfolist
{
  public static function configure(Schema $schema): Schema
  {
    return $schema
      ->components([
        Section::make('تفاصيل التوقيت')
          ->icon('heroicon-o-clock')
          ->description('عرض بيانات الفترة الزمنية المحددة')
          ->schema([
            Grid::make(2)->schema([
              TextEntry::make('from')
                ->label('وقت البداية')
                ->time('h:i A')
                ->size(TextSize::Large)
                ->weight(FontWeight::Bold)
                ->color('success')
                ->icon('heroicon-m-play-circle'),

              TextEntry::make('to')
                ->label('وقت النهاية')
                ->time('h:i A')
                ->size(TextSize::Large)
                ->weight(FontWeight::Bold)
                ->color('info')
                ->icon('heroicon-m-stop-circle'),
            ]),

            Grid::make(1)->schema([
              TextEntry::make('duration_summary')
                ->label('ملاحظة زمنية')
                ->getStateUsing(fn($record) => "تم تسجيل هذا التوقيت في تاريخ " . $record->created_at->format('d/m/Y'))
                ->color('gray')
                ->size(TextSize::Small),
            ]),
          ]),
      ])->columns(1);
  }
}