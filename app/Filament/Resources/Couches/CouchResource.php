<?php

namespace App\Filament\Resources\Couches;

use App\Filament\Resources\Couches\Pages\CreateCouch;
use App\Filament\Resources\Couches\Pages\EditCouch;
use App\Filament\Resources\Couches\Pages\ListCouches;
use App\Filament\Resources\Couches\Pages\ViewCouch;
use App\Filament\Resources\Couches\RelationManagers\TrainingProgramsRelationManager;
use App\Filament\Resources\Couches\Schemas\CouchForm;
use App\Filament\Resources\Couches\Schemas\CouchInfolist;
use App\Filament\Resources\Couches\Tables\CouchesTable;
use App\Models\Couch;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use UnitEnum;

class CouchResource extends Resource
{
  protected static ?string $model = Couch::class;
  protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-identification';
  protected static ?string $recordTitleAttribute = 'Couch';
  protected static string|UnitEnum|null $navigationGroup = 'إدارة المدربين الرياضيين';
  protected static ?string $navigationLabel = 'قائمة المدربين الرياضيين';
  protected static ?int $navigationSort = 1;
  protected static ?string $pluralModelLabel = 'المدربين الرياضيين';
  protected static ?string $modelLabel = 'مدرب رياضي';

  public static function form(Schema $schema): Schema
  {
    return CouchForm::configure($schema);
  }

  public static function infolist(Schema $schema): Schema
  {
    return CouchInfolist::configure($schema);
  }

  public static function table(Table $table): Table
  {
    return CouchesTable::configure($table);
  }

  public static function getRelations(): array
  {
    return [
      TrainingProgramsRelationManager::class,
    ];
  }

  public static function getPages(): array
  {
    return [
      'index' => ListCouches::route('/'),
      'create' => CreateCouch::route('/create'),
      'view' => ViewCouch::route('/{record}'),
      'edit' => EditCouch::route('/{record}/edit'),
    ];
  }
}