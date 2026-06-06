<?php

namespace App\Filament\Resources\Products\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Tables\Filters\SelectFilter;
use Filament\Support\Enums\TextSize;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Filters\TernaryFilter;


class ProductsTable
{
  public static function configure(Table $table): Table
  {
    return $table
      ->columns([
        TextColumn::make('name.ar')
          ->label('الاسم (AR)')
          ->size(TextSize::Large)
          ->searchable()
          ->sortable(),

        TextColumn::make('category.name.ar')
          ->label('القسم')
          ->size(TextSize::Large)
          ->badge()
          ->color('info')
          ->sortable(),

        ToggleColumn::make('is_featured')
          ->label('مميز')
          ->sortable(),


        TextColumn::make('created_at')
          ->size(TextSize::Large)

          ->dateTime()
          ->sortable()

      ])
      ->filters([
        SelectFilter::make('category_id')
          ->label('تصفية حسب القسم')
          ->relationship('category', 'name->ar'),

        TernaryFilter::make('is_featured')
          ->label('المنتجات المميزة')
          ->placeholder('الكل')
          ->trueLabel('المميزة فقط')
          ->falseLabel('العادية فقط'),
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
