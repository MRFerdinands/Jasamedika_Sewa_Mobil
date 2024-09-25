<?php

namespace App\Filament\Resources\RentCarResource\Pages;

use Carbon\Carbon;
use App\Models\Car;
use Filament\Actions;
use Filament\Pages\Actions\ButtonAction;
use Filament\Resources\Pages\CreateRecord;
use App\Filament\Resources\RentCarResource;

class CreateRentCar extends CreateRecord
{
    protected static string $resource = RentCarResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $car = Car::find($data['id_car']);
        $startDate = Carbon::parse($data['start_date']);
        $endDate = Carbon::parse($data['end_date']);

        $data['id_user'] = auth()->id();
        $data['total'] = $startDate->diffInDays($endDate) * $car->rates;
        $car->status = 'Not Available';
        $car->save();

        return $data;
    }

    protected function getFormActions(): array
    {
        return [
            // ButtonAction::make('create')
            //     ->label('Sewa Mobil')
            //     ->submit('store'),
        ];
    }
}
