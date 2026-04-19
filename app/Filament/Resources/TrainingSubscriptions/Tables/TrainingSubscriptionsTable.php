<?php

namespace App\Filament\Resources\TrainingSubscriptions\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Support\Enums\TextSize;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class TrainingSubscriptionsTable
{
  public static function configure(Table $table): Table
  {
    return $table
      ->columns([
        TextColumn::make('user.name')
          ->label('المتدرب')
          ->size(TextSize::Large)
          ->searchable()
          ->sortable(),

        TextColumn::make('trainingProgram.name.' . app()->getLocale())
          ->label('البرنامج التدريبي')
          ->badge()
          ->size(TextSize::Large)
          ->sortable()
          ->color('info')
          ->searchable(),

        TextColumn::make('trainingProgram.couch.name.' . app()->getLocale())
          ->label('الكوتش المسؤول')
          ->size(TextSize::Large)
          ->sortable()
          ->searchable()
          ->placeholder('غير محدد'),

        TextColumn::make('trainingProgram.final_price')
          ->label('قيمة الاشتراك')
          ->money('USD', locale: 'en')
          ->color('success')
          ->size(TextSize::Large)
          ->weight('bold')
          ->sortable()
          ->searchable()
          ->alignCenter(),

        TextColumn::make('created_at')
          ->label('تاريخ الاشتراك')
          ->description(fn($record) => $record->created_at->diffForHumans())
          ->dateTime('d/m/Y - h:i A')
          ->size(TextSize::Large)
          ->searchable()
          ->sortable(),

      ])
      ->filters([
        SelectFilter::make('training_program_id')
          ->label('تصفية حسب البرنامج')
          ->relationship('trainingProgram', 'id')
          ->getOptionLabelFromRecordUsing(fn($record) => $record->name[app()->getLocale()] ?? $record->name['en']),

        SelectFilter::make('couch')
          ->label('تصفية حسب الكوتش')
          ->relationship('trainingProgram.couch', 'name')
          ->getOptionLabelFromRecordUsing(fn($record) => $record->name[app()->getLocale()] ?? $record->name['en']),
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