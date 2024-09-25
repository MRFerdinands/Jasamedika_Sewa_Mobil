<?php

namespace App\Filament\Resources\ReturnCarResource\Pages;

use App\Filament\Resources\ReturnCarResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditReturnCar extends EditRecord
{
    protected static string $resource = ReturnCarResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
