<?php

namespace App\Filament\Resources\CarResource\Pages;

use Filament\Actions;
use App\Filament\Resources\CarResource;
use Filament\Tables\Actions\ButtonAction;
use Filament\Resources\Pages\CreateRecord;

class CreateCar extends CreateRecord
{
    protected static string $resource = CarResource::class;

    protected function getFormActions(): array
    {
        return [
            ButtonAction::make('create')
                ->label('Simpan Mobil')
                ->submit('store'),
            ButtonAction::make('cancel')
                ->label('Cancel')
                ->url($this->getResource()::getUrl('index'))
                ->color('secondary'),
        ];
    }
}
