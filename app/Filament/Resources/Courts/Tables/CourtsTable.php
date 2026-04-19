<?php

namespace App\Filament\Resources\Courts\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Support\Enums\TextSize;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class CourtsTable
{
  public static function configure(Table $table): Table
  {
    return $table
      ->columns([

        TextColumn::make('name.' . app()->getLocale())
          ->label('الاسم')
          ->size(TextSize::Large)
          ->searchable()
          ->sortable(),

        TextColumn::make('price')
          ->label('السعر')
          ->size(TextSize::Large)
          ->money('USD', locale: 'en')
          ->sortable(),

        TextColumn::make('discounts')
          ->label('الخصم')
          ->suffix('%')
          ->size(TextSize::Large)
          ->color('danger'),

        TextColumn::make('final_price')
          ->label('السعر بعد الخصم')
          ->size(TextSize::Large)
          ->money('USD', locale: 'en')
          ->color('success')
          ->weight('bold'),

        TextColumn::make('created_at')
          ->label('تاريخ الإضافة')
          ->size(TextSize::Large)
          ->dateTime()
      ])
      ->filters([

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