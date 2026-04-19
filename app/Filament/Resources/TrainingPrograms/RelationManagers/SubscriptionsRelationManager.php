<?php

namespace App\Filament\Resources\TrainingPrograms\RelationManagers;

use App\Filament\Resources\TrainingPrograms\TrainingProgramResource;
use Filament\Actions\CreateAction;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Support\Enums\TextSize;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class SubscriptionsRelationManager extends RelationManager
{
  protected static string $relationship = 'subscriptions';

  protected static ?string $title = 'قائمة المتدربين المسجلين';

  protected static ?string $modelLabel = 'اشتراك';

  public function table(Table $table): Table
  {
    return $table
      ->recordTitleAttribute('id')
      ->columns([
        TextColumn::make('user.name')
          ->label('اسم المتدرب')
          ->size(TextSize::Large)
          ->weight('bold')
          ->searchable()
          ->searchable(),

        TextColumn::make('user.phone')
          ->label('رقم الهاتف')
          ->icon('heroicon-m-phone')
          ->size(TextSize::Large)
          ->color('primary')
          ->copyable()
          ->placeholder('لا يوجد رقم')
          ->searchable()
          ->url(fn($record) => $record->user->phone ? "tel:{$record->user->phone}" : null),

        TextColumn::make('user.email')
          ->label('البريد الإلكتروني')
          ->icon('heroicon-m-envelope')
          ->size(TextSize::Large)
          ->searchable()
          ->copyable(),

        TextColumn::make('created_at')
          ->label('تاريخ التسجيل')
          ->size(TextSize::Large)
          ->dateTime('d/m/Y h:i A')
          ->description(fn($record) => $record->created_at->diffForHumans())
          ->searchable()
          ->sortable(),
      ]);

  }
}