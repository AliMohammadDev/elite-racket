<?php

namespace App\Filament\Resources\Users\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;

class UsersTable
{
  public static function configure(Table $table): Table
  {
    return $table
      ->columns([
        TextColumn::make('id')->sortable(),

        TextColumn::make('name')
          ->label('الاسم')
          ->searchable()
          ->sortable(),

        TextColumn::make('email')
          ->label('البريد الإلكتروني')
          ->searchable(),

        TextColumn::make('phone')
          ->label('الهاتف')
          ->placeholder('-'),

        ToggleColumn::make('is_active')
          ->label('الحالة')
          ->onIcon('heroicon-m-check-circle')
          ->offIcon('heroicon-m-x-circle')
          ->onColor('success')
          ->offColor('danger'),

        TextColumn::make('created_at')
          ->label('تاريخ التسجيل')
          ->dateTime()
          ->sortable(),
      ])
      ->filters([
        TernaryFilter::make('is_active')
          ->label('حالة الحساب')
          ->placeholder('الكل')
          ->trueLabel('المستخدمون النشطون')
          ->falseLabel('المستخدمون المعطلون'),
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
