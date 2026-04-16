<?php

namespace App\Filament\Resources\Colors;

use App\Filament\Resources\Colors\Pages\CreateColor;
use App\Filament\Resources\Colors\Pages\EditColor;
use App\Filament\Resources\Colors\Pages\ListColors;
use App\Filament\Resources\Colors\Pages\ViewColor;
use App\Filament\Resources\Colors\Schemas\ColorForm;
use App\Filament\Resources\Colors\Schemas\ColorInfolist;
use App\Filament\Resources\Colors\Tables\ColorsTable;
use App\Models\Color;
use UnitEnum;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;

class ColorResource extends Resource
{
  protected static ?string $model = Color::class;
  protected static ?string $recordTitleAttribute = 'Color';
  protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-swatch';
  protected static ?string $navigationLabel = 'الألوان';
  protected static ?string $pluralModelLabel = 'الألوان';
  protected static ?string $modelLabel = 'لون';
  protected static string|UnitEnum|null $navigationGroup = 'إدارة المنتجات';
  protected static ?int $navigationSort = 2;

  public static function form(Schema $schema): Schema
  {
    return ColorForm::configure($schema);
  }

  public static function infolist(Schema $schema): Schema
  {
    return ColorInfolist::configure($schema);
  }

  public static function table(Table $table): Table
  {
    return ColorsTable::configure($table);
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
      'index' => ListColors::route('/'),
      'create' => CreateColor::route('/create'),
      'view' => ViewColor::route('/{record}'),
      'edit' => EditColor::route('/{record}/edit'),
    ];
  }
}