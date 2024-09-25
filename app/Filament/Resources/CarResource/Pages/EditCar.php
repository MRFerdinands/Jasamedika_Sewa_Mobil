<?php

namespace App\Filament\Resources\CarResource\Pages;

use Filament\Actions;
use App\Filament\Resources\CarResource;
use Filament\Pages\Actions\ButtonAction;
use Filament\Resources\Pages\EditRecord;

class EditCar extends EditRecord
{
    protected static string $resource = CarResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function getFormActions(): array
    {
        return [
            ButtonAction::make('edit')
                ->label('Simpan')
                ->submit('edit'),
            ButtonAction::make('cancel')
                ->label('Cancel')
                ->url($this->getResource()::getUrl('index'))
                ->color('secondary'),
        ];
    }
}
