<?php

namespace App\Filament\Resources\Couches\Pages;

use App\Filament\Resources\Couches\CouchResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListCouches extends ListRecords
{
    protected static string $resource = CouchResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
