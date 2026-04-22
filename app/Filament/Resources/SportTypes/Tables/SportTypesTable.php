<?php

namespace App\Filament\Resources\SportTypes\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class SportTypesTable
{
  public static function configure(Table $table): Table
  {
    return $table
      ->columns([
        TextColumn::make('name.' . app()->getLocale())
          ->label('الاسم')
          ->searchable()
          ->sortable(),

        TextColumn::make('body.' . app()->getLocale())
          ->label('الوصف')
          ->limit(50)
          ->searchable()
          ->sortable(),

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