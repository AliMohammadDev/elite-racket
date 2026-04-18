<?php

namespace App\Filament\Resources\Times\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Support\Enums\TextSize;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class TimesTable
{
  public static function configure(Table $table): Table
  {
    return $table
      ->columns([
        TextColumn::make('from')
          ->label('من الساعة')
          ->time('h:i A')
          ->badge()
          ->color('success')
          ->size(TextSize::Large)
          ->sortable()
          ->searchable()
          ->extraAttributes([
            'style' => 'font-variant-numeric: lining-nums; font-family: sans-serif;',
          ]),

        TextColumn::make('to')
          ->label('إلى الساعة')
          ->time('h:i A')
          ->badge()
          ->size(TextSize::Large)
          ->searchable()
          ->color('info')
          ->sortable()
          ->extraAttributes([
            'style' => 'font-variant-numeric: lining-nums; font-family: sans-serif;',
          ]),

        TextColumn::make('created_at')
          ->label('تاريخ الإضافة')
          ->size(TextSize::Large)
          ->sortable()
          ->searchable()
          ->dateTime('d/m/Y'),
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
