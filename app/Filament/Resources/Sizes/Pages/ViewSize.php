<?php

namespace App\Filament\Resources\Sizes\Pages;

use App\Filament\Resources\Sizes\SizeResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;
use Filament\Actions;


class ViewSize extends ViewRecord
{
  protected static string $resource = SizeResource::class;

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