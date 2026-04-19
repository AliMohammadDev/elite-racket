<?php

namespace App\Filament\Resources\Courts\RelationManagers;

use App\Filament\Resources\Courts\CourtResource;
use Filament\Actions\CreateAction;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Support\Enums\TextSize;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class BookingsRelationManager extends RelationManager
{
  protected static string $relationship = 'bookings';
  protected static ?string $title = 'حجوزات هذا الملعب';
  protected static ?string $relatedResource = CourtResource::class;

  public function table(Table $table): Table
  {
    return $table
      ->recordTitleAttribute('id')
      ->columns([

        TextColumn::make('user.name')
          ->label('العميل')
          ->size(TextSize::Large)
          ->searchable()
          ->sortable(),

        TextColumn::make('booking_date')
          ->label('تاريخ الحجز')
          ->date()
          ->size(TextSize::Large)
          ->searchable()
          ->sortable(),

        TextColumn::make('total_price')
          ->label('الإجمالي')
          ->color('success')
          ->size(TextSize::Large)
          ->money('USD', locale: 'en')
          ->searchable()
          ->sortable(),

        TextColumn::make('status')
          ->label('الحالة')
          ->badge()
          ->size(TextSize::Large)
          ->color(fn(string $state): string => match ($state) {
            'pending' => 'warning',
            'confirmed' => 'success',
            'cancelled' => 'danger',
            default => 'gray',
          }),
      ]);


  }
}
