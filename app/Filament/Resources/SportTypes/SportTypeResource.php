<?php

namespace App\Filament\Resources\SportTypes;

use App\Filament\Resources\SportTypes\Pages\CreateSportType;
use App\Filament\Resources\SportTypes\Pages\EditSportType;
use App\Filament\Resources\SportTypes\Pages\ListSportTypes;
use App\Filament\Resources\SportTypes\Pages\ViewSportType;
use App\Filament\Resources\SportTypes\Schemas\SportTypeForm;
use App\Filament\Resources\SportTypes\Schemas\SportTypeInfolist;
use App\Filament\Resources\SportTypes\Tables\SportTypesTable;
use App\Models\SportType;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use UnitEnum;

class SportTypeResource extends Resource
{
  protected static ?string $model = SportType::class;
  protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-rectangle-stack';
  protected static ?string $recordTitleAttribute = 'SportTYpe';
  protected static ?string $navigationLabel = 'أنواع الرياضات';
  protected static ?string $pluralModelLabel = 'أنواع الرياضات';
  protected static string|UnitEnum|null $navigationGroup = 'إدارة المدربين الرياضيين';

  protected static ?string $modelLabel = 'نوع رياضي';



  public static function form(Schema $schema): Schema
  {
    return SportTypeForm::configure($schema);
  }

  public static function infolist(Schema $schema): Schema
  {
    return SportTypeInfolist::configure($schema);
  }

  public static function table(Table $table): Table
  {
    return SportTypesTable::configure($table);
  }

  public static function getRelations(): array
  {
    return [
      //
    ];
  }

  public static function getPages(): array
  {
    return [
      'index' => ListSportTypes::route('/'),
      'create' => CreateSportType::route('/create'),
      'view' => ViewSportType::route('/{record}'),
      'edit' => EditSportType::route('/{record}/edit'),
    ];
  }
}
