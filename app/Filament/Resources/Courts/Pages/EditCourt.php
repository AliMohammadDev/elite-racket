<?php

namespace App\Filament\Resources\Courts\Pages;

use App\Filament\Resources\Courts\CourtResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;
use Filament\Actions;


class EditCourt extends EditRecord
{
  protected static string $resource = CourtResource::class;

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
