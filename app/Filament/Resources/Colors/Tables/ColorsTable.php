<?php

namespace App\Filament\Resources\Colors\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\ColorColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ColorsTable
{
  public static function configure(Table $table): Table
  {
    return $table
      ->columns([
        TextColumn::make('color')
          ->label('اسم اللون')
          ->searchable()
          ->sortable()
          ->searchable(),

        ColorColumn::make('hex_code')
          ->label('كود اللون')
          ->copyable()
          ->copyMessage('Copied!')
          ->copyMessageDuration(1500)->searchable(),

        TextColumn::make('created_at')
          ->label('تاريخ الإضافة')
          ->dateTime()
          ->sortable()
          ->searchable(),
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
      ]);
  }
}