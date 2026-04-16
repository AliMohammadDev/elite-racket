<?php

namespace App\Filament\Resources\Couches\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Support\Enums\TextSize;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class CouchesTable
{
  public static function configure(Table $table): Table
  {
    return $table
      ->columns([
        TextColumn::make('name.' . app()->getLocale())
          ->label('الاسم')
          ->searchable()
          ->sortable(),

        TextColumn::make('user.name')
          ->label('المستخدم')
          ->size(TextSize::Large)
          ->searchable()
          ->sortable(),

        TextColumn::make('phone')
          ->label('الهاتف')
          ->size(TextSize::Large)

          ->searchable(),

        TextColumn::make('address.' . app()->getLocale())
          ->label('العنوان')
          ->size(TextSize::Large)

          ->limit(30),

        TextColumn::make('created_at')
          ->label('تاريخ الانضمام')
          ->size(TextSize::Large)

          ->dateTime()
          ->sortable()
      ])
      ->filters([
        SelectFilter::make('user_id')
          ->label('تصفية حسب المستخدم')
          ->relationship('user', 'name')
          ->searchable()
          ->preload(),
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
