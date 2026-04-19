<?php

namespace App\Filament\Resources\Courts\Pages;

use App\Filament\Resources\Courts\CourtResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;
use Filament\Actions;


class ViewCourt extends ViewRecord
{
  protected static string $resource = CourtResource::class;

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
