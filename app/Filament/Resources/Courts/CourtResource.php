<?php

namespace App\Filament\Resources\Courts;

use App\Filament\Resources\Courts\Pages\CreateCourt;
use App\Filament\Resources\Courts\Pages\EditCourt;
use App\Filament\Resources\Courts\Pages\ListCourts;
use App\Filament\Resources\Courts\Pages\ViewCourt;
use App\Filament\Resources\Courts\Schemas\CourtForm;
use App\Filament\Resources\Courts\Schemas\CourtInfolist;
use App\Filament\Resources\Courts\Tables\CourtsTable;
use App\Models\Court;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class CourtResource extends Resource
{
  protected static ?string $model = Court::class;

  protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-trophy';
  protected static ?string $recordTitleAttribute = 'Court';
  protected static string|UnitEnum|null $navigationGroup = 'إدارة الملاعب';
  protected static ?string $navigationLabel = 'الملاعب';
  protected static ?string $modelLabel = 'ملعب';
  protected static ?string $pluralModelLabel = 'الملاعب';

  public static function form(Schema $schema): Schema
  {
    return CourtForm::configure($schema);
  }

  public static function infolist(Schema $schema): Schema
  {
    return CourtInfolist::configure($schema);
  }

  public static function table(Table $table): Table
  {
    return CourtsTable::configure($table);
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
      'index' => ListCourts::route('/'),
      'create' => CreateCourt::route('/create'),
      'view' => ViewCourt::route('/{record}'),
      'edit' => EditCourt::route('/{record}/edit'),
    ];
  }
}
