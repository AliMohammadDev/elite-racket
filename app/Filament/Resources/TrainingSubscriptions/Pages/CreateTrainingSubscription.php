<?php

namespace App\Filament\Resources\TrainingSubscriptions\Pages;

use App\Filament\Resources\TrainingSubscriptions\TrainingSubscriptionResource;
use Filament\Resources\Pages\CreateRecord;
use Filament\Actions;


class CreateTrainingSubscription extends CreateRecord
{
  protected static string $resource = TrainingSubscriptionResource::class;

  protected function getHeaderActions(): array
  {
    return [
      Actions\Action::make('back')
        ->label('رجوع')
        ->color('gray')
        ->url($this->getResource()::getUrl('index')),
    ];
  }

  protected function getRedirectUrl(): string
  {
    return $this->getResource()::getUrl('index');
  }
}
