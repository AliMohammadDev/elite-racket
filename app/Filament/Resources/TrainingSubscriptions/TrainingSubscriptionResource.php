<?php

namespace App\Filament\Resources\TrainingSubscriptions;

use App\Filament\Resources\TrainingSubscriptions\Pages\CreateTrainingSubscription;
use App\Filament\Resources\TrainingSubscriptions\Pages\EditTrainingSubscription;
use App\Filament\Resources\TrainingSubscriptions\Pages\ListTrainingSubscriptions;
use App\Filament\Resources\TrainingSubscriptions\Pages\ViewTrainingSubscription;
use App\Filament\Resources\TrainingSubscriptions\Schemas\TrainingSubscriptionForm;
use App\Filament\Resources\TrainingSubscriptions\Schemas\TrainingSubscriptionInfolist;
use App\Filament\Resources\TrainingSubscriptions\Tables\TrainingSubscriptionsTable;
use App\Models\TrainingSubscription;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use UnitEnum;

class TrainingSubscriptionResource extends Resource
{
  protected static ?string $model = TrainingSubscription::class;
  protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-clipboard-document-check';
  protected static ?string $recordTitleAttribute = 'TrainingSubscription';
  protected static string|UnitEnum|null $navigationGroup = 'إدارة الملاعب';
  protected static ?int $navigationSort = 3;
  protected static ?string $navigationLabel = 'اشتراكات البرامج';
  protected static ?string $modelLabel = 'اشتراك';
  protected static ?string $pluralModelLabel = 'اشتراكات البرامج التدريبية';

  public static function form(Schema $schema): Schema
  {
    return TrainingSubscriptionForm::configure($schema);
  }

  public static function infolist(Schema $schema): Schema
  {
    return TrainingSubscriptionInfolist::configure($schema);
  }

  public static function table(Table $table): Table
  {
    return TrainingSubscriptionsTable::configure($table);
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
      'index' => ListTrainingSubscriptions::route('/'),
      'create' => CreateTrainingSubscription::route('/create'),
      'view' => ViewTrainingSubscription::route('/{record}'),
      'edit' => EditTrainingSubscription::route('/{record}/edit'),
    ];
  }
}
