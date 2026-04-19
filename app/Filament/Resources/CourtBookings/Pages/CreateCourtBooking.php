<?php

namespace App\Filament\Resources\CourtBookings\Pages;

use App\Filament\Resources\CourtBookings\CourtBookingResource;
use Filament\Resources\Pages\CreateRecord;
use Filament\Actions;


class CreateCourtBooking extends CreateRecord
{
  protected static string $resource = CourtBookingResource::class;
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
