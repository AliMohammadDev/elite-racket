<?php

namespace App\Filament\Resources\Colors\Pages;

use App\Filament\Resources\Colors\ColorResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;
use Filament\Actions;


class ViewColor extends ViewRecord
{
  protected static string $resource = ColorResource::class;

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
