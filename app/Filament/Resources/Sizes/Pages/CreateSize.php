<?php

namespace App\Filament\Resources\Sizes\Pages;

use App\Filament\Resources\Sizes\SizeResource;
use Filament\Resources\Pages\CreateRecord;
use Filament\Actions;


class CreateSize extends CreateRecord
{
  protected static string $resource = SizeResource::class;

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
