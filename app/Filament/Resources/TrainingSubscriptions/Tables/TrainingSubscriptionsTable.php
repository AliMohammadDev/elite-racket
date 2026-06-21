<?php

namespace App\Filament\Resources\TrainingSubscriptions\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use pxlrbt\FilamentExcel\Actions\Tables\ExportBulkAction;
use pxlrbt\FilamentExcel\Actions\Tables\ExportAction;
use Filament\Actions\ViewAction;
use Filament\Support\Enums\TextSize;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;



use pxlrbt\FilamentExcel\Exports\ExcelExport;
use pxlrbt\FilamentExcel\Columns\Column;

class TrainingSubscriptionsTable
{
  public static function configure(Table $table): Table
  {
    $getExcelExport = fn() => ExcelExport::make()
      ->askForFilename()
      ->withColumns([
        Column::make('user.name')
          ->heading('المتدرب')
          ->formatStateUsing(fn($record) => $record->user?->name),

        Column::make('user.phone')
          ->heading('رقم الهاتف')
          ->formatStateUsing(fn($record) => $record->user?->phone ?? 'غير محدد'),

        Column::make('trainingProgram.name')
          ->heading('البرنامج التدريبي')
          ->formatStateUsing(function ($record) {
            $locale = app()->getLocale();
            return $record->trainingProgram?->name[$locale]
              ?? $record->trainingProgram?->name['en']
              ?? '';
          }),

        Column::make('trainingProgram.couch.name')
          ->heading('الكوتش المسؤول')
          ->formatStateUsing(function ($record) {
            $locale = app()->getLocale();
            return $record->trainingProgram?->couch?->name[$locale]
              ?? $record->trainingProgram?->couch?->name['en']
              ?? 'غير محدد';
          }),

        Column::make('trainingProgram.final_price')
          ->heading('قيمة الاشتراك')
          ->formatStateUsing(fn($record) => '$' . number_format($record->trainingProgram?->final_price, 2)),

        Column::make('created_at')
          ->heading('تاريخ الاشتراك')
          ->formatStateUsing(fn($record) => $record->created_at?->format('d/m/Y - h:i A')),
      ]);

    return $table
      ->columns([
        TextColumn::make('user.name')
          ->label('المتدرب')
          ->size(TextSize::Large)
          ->searchable()
          ->sortable(),

        TextColumn::make('user.phone')
          ->label('رقم الهاتف')
          ->size(TextSize::Large)
          ->searchable()
          ->placeholder('غير محدد'),

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
      ->headerActions([
        ExportAction::make()
          ->label('تصدير إلى إكسل')
          ->color('success')
          ->exports([$getExcelExport()]),
      ])
      ->bulkActions([
        BulkActionGroup::make([
          DeleteBulkAction::make(),
          ExportBulkAction::make()
            ->label('تصدير المحدد إلى إكسل')
            ->exports([$getExcelExport()]),
        ]),
      ])
      ->defaultSort('created_at', 'desc');
  }
}
