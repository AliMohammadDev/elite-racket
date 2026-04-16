<?php

namespace App\Filament\Resources\Couches\Pages;

use App\Filament\Resources\Couches\CouchResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;
use Filament\Actions;


class ViewCouch extends ViewRecord
{
  protected static string $resource = CouchResource::class;

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
}