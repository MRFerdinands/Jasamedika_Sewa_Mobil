<?php

namespace App\Filament\Resources\RentCarResource\Pages;

use App\Filament\Resources\RentCarResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListRentCars extends ListRecords
{
    protected static string $resource = RentCarResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
