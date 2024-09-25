<?php

namespace App\Filament\Resources\RentCarResource\Pages;

use App\Filament\Resources\RentCarResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditRentCar extends EditRecord
{
    protected static string $resource = RentCarResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
