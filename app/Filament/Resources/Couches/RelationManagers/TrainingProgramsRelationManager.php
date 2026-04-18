<?php

namespace App\Filament\Resources\Couches\RelationManagers;

use App\Filament\Resources\Couches\CouchResource;
use Filament\Actions\CreateAction;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Support\Enums\TextSize;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class TrainingProgramsRelationManager extends RelationManager
{
  protected static string $relationship = 'trainingPrograms';
  protected static ?string $title = 'البرامج التدريبية التي يشرف عليها';
  protected static ?string $modelLabel = 'برنامج تدريبي';

  public function table(Table $table): Table
  {
    return $table
      ->recordTitleAttribute('name')
      ->columns([
        TextColumn::make('name.' . app()->getLocale())
          ->label('اسم البرنامج')
          ->size(TextSize::Large)
          ->weight('bold')
          ->searchable()
          ->sortable(),

        TextColumn::make('train_level')
          ->label('المستوى')
          ->badge()
          ->size(TextSize::Large)
          ->color(fn(string $state): string => match ($state) {
            'beginner' => 'success',
            'intermediate' => 'warning',
            'advanced' => 'danger',
            default => 'gray',
          }),

        TextColumn::make('final_price')
          ->label('السعر النهائي')
          ->money('USD', locale: 'en')
          ->size(TextSize::Large)
          ->color('success')
          ->searchable()
          ->sortable(),

        TextColumn::make('subscriptions_count')
          ->label('عدد المشتركين')
          ->counts('subscriptions')
          ->badge()
          ->size(TextSize::Large)
          ->extraAttributes([
            'style' => 'font-variant-numeric: lining-nums; font-family: sans-serif;',
          ])
          ->searchable()
          ->sortable(),

        TextColumn::make('start_date')
          ->label('تاريخ البدء')
          ->date('d/m/Y')
          ->size(TextSize::Large)
          ->searchable()
          ->sortable(),
      ]);
  }
}
