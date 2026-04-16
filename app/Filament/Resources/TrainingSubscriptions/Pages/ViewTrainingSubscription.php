<?php

namespace App\Filament\Resources\TrainingSubscriptions\Pages;

use App\Filament\Resources\TrainingSubscriptions\TrainingSubscriptionResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;
use Filament\Actions;


class ViewTrainingSubscription extends ViewRecord
{
  protected static string $resource = TrainingSubscriptionResource::class;

  protected function getHeaderActions(): array
  {
    return [
      Actions\Action::make('back')
        ->label('رجوع')
        ->color('gray')
        ->url($this->getResource()::getUrl('index')),
      EditAction::make(),
    ];
  }
  protected function getRedirectUrl(): string
  {
    return $this->getResource()::getUrl('index');
  }
}
