<?php

namespace App\Filament\Resources\TrainingSubscriptions\Pages;

use App\Filament\Resources\TrainingSubscriptions\TrainingSubscriptionResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListTrainingSubscriptions extends ListRecords
{
  protected static string $resource = TrainingSubscriptionResource::class;

  protected function getHeaderActions(): array
  {
    return [
      CreateAction::make(),
    ];
  }


}