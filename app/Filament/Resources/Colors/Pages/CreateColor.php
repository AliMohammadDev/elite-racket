<?php

namespace App\Filament\Resources\Colors\Pages;

use App\Filament\Resources\Colors\ColorResource;
use Filament\Resources\Pages\CreateRecord;
use Filament\Actions;


class CreateColor extends CreateRecord
{
  protected static string $resource = ColorResource::class;

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
