<?php

namespace App\Filament\Resources\ReturnCarResource\Pages;

use Carbon\Carbon;
use App\Models\Car;
use Filament\Actions;
use App\Models\RentCar;
use Filament\Pages\Actions\ButtonAction;
use Filament\Resources\Pages\CreateRecord;
use App\Filament\Resources\ReturnCarResource;

class CreateReturnCar extends CreateRecord
{
    protected static string $resource = ReturnCarResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $rent = RentCar::find($data['id_car']);
        $car = Car::find($rent->id_car);
        $data['id_user'] = $rent->id_user;
        $data['return_date'] = Carbon::now();
        $rent->status = 'Returned';
        $rent->save();
        $car->status = 'Available';
        $car->save();
        return $data;
    }

    protected function getFormActions(): array
    {
        return [
            // ButtonAction::make('create')
            //     ->label('Kembalikan Mobil')
            //     ->submit('store'),
        ];
    }
}
