<?php

namespace App\Filament\Resources\TrainingPrograms\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class TrainingProgramForm
{
  public static function configure(Schema $schema): Schema
  {
    return $schema
      ->components([
        Section::make('معلومات البرنامج')
          ->schema([
            Grid::make(2)->schema([
              TextInput::make('name.ar')->label('الاسم (بالعربية)')->required(),
              TextInput::make('name.en')->label('Name (English)')->required(),
            ]),

            Grid::make(2)->schema([
              Select::make('couch_id')
                ->label('الكوتش المسؤل')
                ->relationship('couch', 'name')
                ->getOptionLabelFromRecordUsing(fn($record) => $record->name[app()->getLocale()] ?? $record->name['en'])
                ->searchable()
                ->preload()
                ->required(),

              Select::make('train_level')
                ->label('مستوى التدريب')
                ->options([
                  'beginner' => 'مبتدئ',
                  'intermediate' => 'متوسط',
                  'advanced' => 'متقدم',
                ])->required(),
            ]),

            Grid::make(2)->schema([
              TextInput::make('price')->label('السعر')->numeric()->prefix('$')->required(),
              TextInput::make('discounts')->label('الخصم (%)')->numeric()->default(0),
            ]),
          ]),
      ])->columns(1);
  }
}
