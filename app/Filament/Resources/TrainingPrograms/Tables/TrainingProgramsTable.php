<?php

namespace App\Filament\Resources\TrainingPrograms\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Support\Enums\TextSize;
use Filament\Tables\Columns\SpatieMediaLibraryImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Support\Carbon;

class TrainingProgramsTable
{
  public static function configure(Table $table): Table
  {
    return $table
      ->columns([

        SpatieMediaLibraryImageColumn::make('image')
          ->collection('training_programs')
          ->label('Image')
          ->circular(),


        TextColumn::make('name.' . app()->getLocale())
          ->label('البرنامج')
          ->size(TextSize::Large)
          ->searchable(),

        TextColumn::make('couch.name.' . app()->getLocale())
          ->label('الكوتش')
          ->size(TextSize::Large)
          ->searchable()
          ->sortable(),

        TextColumn::make('train_level')
          ->label('المستوى')
          ->formatStateUsing(fn(string $state): string => match ($state) {
            'beginner' => '🌱 مبتدئ',
            'intermediate' => '⚡ متوسط',
            'advanced' => '🔥 متقدم',
            default => $state,
          })
          ->badge()
          ->color(fn(string $state): string => match ($state) {
            'beginner' => 'success',
            'intermediate' => 'warning',
            'advanced' => 'danger',
            default => 'gray',
          }),


        TextColumn::make('dates')
          ->label('الفترة الزمنية')
          ->description(fn($record) => 'تنتهي في: ' . Carbon::parse($record->end_date)->format('d/m/Y'))
          ->getStateUsing(fn($record) => Carbon::parse($record->start_date)->format('d/m/Y'))
          ->icon('heroicon-m-calendar-days')
          ->color('gray'),

        TextColumn::make('users_count')
          ->label('السعة المتاحة')
          ->numeric()
          ->alignCenter()
          ->description('مشترك كحد أقصى')
          ->color('info')
          ->icon('heroicon-m-users'),


        TextColumn::make('price')
          ->size(TextSize::Large)
          ->sortable()
          ->searchable()
          ->label('السعر')
          ->money('USD', locale: 'en'),

        TextColumn::make('final_price')
          ->label('السعر النهائي')
          ->money('USD', locale: 'en')
          ->color('success')
          ->size(TextSize::Large)
          ->sortable()
          ->searchable()
          ->weight('bold'),
      ])
      ->filters([
        SelectFilter::make('train_level')
          ->label('المستوى')
          ->options([
            'beginner' => 'مبتدئ',
            'intermediate' => 'متوسط',
            'advanced' => 'متقدم',
          ]),
        SelectFilter::make('couch_id')
          ->label('الكوتش')
          ->relationship('couch', 'id')

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
      ]);
  }
}