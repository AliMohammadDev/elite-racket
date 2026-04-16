<?php

namespace App\Filament\Resources\Couches\Pages;

use App\Filament\Resources\Couches\CouchResource;
use Filament\Resources\Pages\CreateRecord;
use Filament\Actions;


class CreateCouch extends CreateRecord
{
  protected static string $resource = CouchResource::class;

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
