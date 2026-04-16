<?php

namespace App\Filament\Resources\Courts\Pages;

use App\Filament\Resources\Courts\CourtResource;
use Filament\Resources\Pages\CreateRecord;
use Filament\Actions;


class CreateCourt extends CreateRecord
{
  protected static string $resource = CourtResource::class;
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