<?php

namespace App\Filament\Resources\SportTypes\Pages;

use App\Filament\Resources\SportTypes\SportTypeResource;
use Filament\Resources\Pages\CreateRecord;
use Filament\Actions;


class CreateSportType extends CreateRecord
{
  protected static string $resource = SportTypeResource::class;

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
