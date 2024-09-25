<?php

namespace App\Filament\Resources\ReturnCarResource\Pages;

use App\Filament\Resources\ReturnCarResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListReturnCars extends ListRecords
{
    protected static string $resource = ReturnCarResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
