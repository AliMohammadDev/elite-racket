<?php

namespace App\Filament\Resources\Sizes;

use App\Filament\Resources\Sizes\Pages\CreateSize;
use App\Filament\Resources\Sizes\Pages\EditSize;
use App\Filament\Resources\Sizes\Pages\ListSizes;
use App\Filament\Resources\Sizes\Pages\ViewSize;
use App\Filament\Resources\Sizes\Schemas\SizeForm;
use App\Filament\Resources\Sizes\Schemas\SizeInfolist;
use App\Filament\Resources\Sizes\Tables\SizesTable;
use App\Models\Size;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use UnitEnum;

class SizeResource extends Resource
{
  protected static ?string $model = Size::class;
  protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-arrows-pointing-out';
  protected static ?string $navigationLabel = 'المقاسات';
  protected static ?string $pluralModelLabel = 'المقاسات';
  protected static ?string $modelLabel = 'مقاس';
  protected static string|UnitEnum|null $navigationGroup = 'إدارة المنتجات';
  protected static ?int $navigationSort = 3;
  protected static ?string $recordTitleAttribute = 'Size';

  public static function form(Schema $schema): Schema
  {
    return SizeForm::configure($schema);
  }

  public static function infolist(Schema $schema): Schema
  {
    return SizeInfolist::configure($schema);
  }

  public static function table(Table $table): Table
  {
    return SizesTable::configure($table);
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
      'index' => ListSizes::route('/'),
      'create' => CreateSize::route('/create'),
      'view' => ViewSize::route('/{record}'),
      'edit' => EditSize::route('/{record}/edit'),
    ];
  }
}