<?php

namespace App\Filament\Resources\TrainingPrograms;

use App\Filament\Resources\TrainingPrograms\Pages\CreateTrainingProgram;
use App\Filament\Resources\TrainingPrograms\Pages\EditTrainingProgram;
use App\Filament\Resources\TrainingPrograms\Pages\ListTrainingPrograms;
use App\Filament\Resources\TrainingPrograms\Pages\ViewTrainingProgram;
use App\Filament\Resources\TrainingPrograms\RelationManagers\SubscriptionsRelationManager;
use App\Filament\Resources\TrainingPrograms\Schemas\TrainingProgramForm;
use App\Filament\Resources\TrainingPrograms\Schemas\TrainingProgramInfolist;
use App\Filament\Resources\TrainingPrograms\Tables\TrainingProgramsTable;
use App\Models\TrainingProgram;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use UnitEnum;

class TrainingProgramResource extends Resource
{
  protected static ?string $model = TrainingProgram::class;
  protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-academic-cap';
  protected static ?string $recordTitleAttribute = 'TrainingProgram';
  protected static string|UnitEnum|null $navigationGroup = 'إدارة البرامج التدريبية';
  protected static ?string $navigationLabel = 'البرامج التدريبية';
  protected static ?string $modelLabel = 'برنامج تدريبي';
  protected static ?string $pluralModelLabel = 'البرامج التدريبية';

  public static function form(Schema $schema): Schema
  {
    return TrainingProgramForm::configure($schema);
  }

  public static function infolist(Schema $schema): Schema
  {
    return TrainingProgramInfolist::configure($schema);
  }

  public static function table(Table $table): Table
  {
    return TrainingProgramsTable::configure($table);
  }

  public static function getRelations(): array
  {
    return [
      SubscriptionsRelationManager::class,

    ];
  }


  public static function getPages(): array
  {
    return [
      'index' => ListTrainingPrograms::route('/'),
      'create' => CreateTrainingProgram::route('/create'),
      'view' => ViewTrainingProgram::route('/{record}'),
      'edit' => EditTrainingProgram::route('/{record}/edit'),
    ];
  }
}
