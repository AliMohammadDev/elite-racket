<?php

namespace App\Filament\Resources\Sizes\Pages;

use App\Filament\Resources\Sizes\SizeResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;
use Filament\Actions;


class EditSize extends EditRecord
{
  protected static string $resource = SizeResource::class;

  protected function getHeaderActions(): array
  {
    return [

      Actions\Action::make('back')
        ->label('رجوع')
        ->color('gray')
        ->url($this->getResource()::getUrl('index')),
      ViewAction::make(),
      DeleteAction::make(),
    ];
  }
  protected function getRedirectUrl(): string
  {
    return $this->getResource()::getUrl('index');
  }
}