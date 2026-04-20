<?php

namespace App\Filament\Resources\CourtBookings;

use App\Filament\Resources\CourtBookings\Pages\CreateCourtBooking;
use App\Filament\Resources\CourtBookings\Pages\EditCourtBooking;
use App\Filament\Resources\CourtBookings\Pages\ListCourtBookings;
use App\Filament\Resources\CourtBookings\Pages\ViewCourtBooking;
use App\Filament\Resources\CourtBookings\Schemas\CourtBookingForm;
use App\Filament\Resources\CourtBookings\Schemas\CourtBookingInfolist;
use App\Filament\Resources\CourtBookings\Tables\CourtBookingsTable;
use App\Models\CourtBooking;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use UnitEnum;

class CourtBookingResource extends Resource
{
  protected static ?string $model = CourtBooking::class;
  protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-calendar-days';
  protected static ?string $recordTitleAttribute = 'CourtBooking';
  protected static string|UnitEnum|null $navigationGroup = 'إدارة الملاعب';
  protected static ?int $navigationSort = 2;
  protected static ?string $navigationLabel = 'حجوزات الملاعب';
  protected static ?string $modelLabel = 'حجز جديد';
  protected static ?string $pluralModelLabel = 'حجوزات الملاعب';

  public static function form(Schema $schema): Schema
  {
    return CourtBookingForm::configure($schema);
  }

  public static function infolist(Schema $schema): Schema
  {
    return CourtBookingInfolist::configure($schema);
  }

  public static function table(Table $table): Table
  {
    return CourtBookingsTable::configure($table);
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
      'index' => ListCourtBookings::route('/'),
      'create' => CreateCourtBooking::route('/create'),
      'view' => ViewCourtBooking::route('/{record}'),
      'edit' => EditCourtBooking::route('/{record}/edit'),
    ];
  }
}