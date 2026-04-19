<?php

namespace App\Filament\Resources\Sizes\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Support\Enums\TextSize;


class SizesTable
{
  public static function configure(Table $table): Table
  {
    return $table
      ->columns([
        TextColumn::make('size')
          ->label('المقاس')
          ->searchable()
          ->sortable()
          ->size(TextSize::Large),

        TextColumn::make('created_at')
          ->label('تاريخ الإضافة')
          ->size(TextSize::Large)

          ->dateTime()
          ->sortable(),
        TextColumn::make('updated_at')
          ->label('تاريخ التحديث')
          ->size(TextSize::Large)

          ->dateTime()
          ->sortable()
      ])
      ->filters([
        //
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
