<?php

namespace App\Filament\Resources\TrainingSubscriptions\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class TrainingSubscriptionForm
{
  public static function configure(Schema $schema): Schema
  {
    return $schema
      ->components([
        Section::make('تفاصيل الاشتراك الجديد')
          ->description('اختر المتدرب والبرنامج التدريبي المناسب')
          ->schema([
            Select::make('user_id')
              ->label('المتدرب (المستخدم)')
              ->relationship('user', 'name')
              ->searchable()
              ->preload()
              ->required(),

            Select::make('training_program_id')
              ->label('البرنامج التدريبي')
              ->relationship('trainingProgram', 'name')
              ->getOptionLabelFromRecordUsing(fn($record) => $record->name[app()->getLocale()] ?? $record->name['en'])
              ->searchable()
              ->preload()
              ->required(),
          ]),
      ])->columns(1);
  }
}