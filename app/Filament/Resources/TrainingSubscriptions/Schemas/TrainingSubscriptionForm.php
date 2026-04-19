<?php

namespace App\Filament\Resources\TrainingSubscriptions\Schemas;

use Filament\Forms\Components\Select;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Illuminate\Database\Eloquent\Builder;

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
              ->relationship(
                name: 'user',
                titleAttribute: 'name',
              )
              ->searchable()
              ->preload()
              ->required(),

            Select::make('training_program_id')
              ->label('البرنامج التدريبي')
              ->relationship(
                name: 'trainingProgram',
                modifyQueryUsing: function (Builder $query) {
                  return $query->where('end_date', '>=', now())
                    ->withCount('subscriptions')
                    ->havingRaw('subscriptions_count < users_count');
                }
              )
              ->getOptionLabelFromRecordUsing(function ($record) {
                $locale = app()->getLocale();
                $name = $record->name[$locale] ?? $record->name['en'];

                $remaining = $record->remaining_slots;

                return "{$name} — (المقاعد المتبقية: {$remaining})";
              })
              ->searchable()
              ->preload()
              ->required(),
          ]),
      ])->columns(1);
  }
}