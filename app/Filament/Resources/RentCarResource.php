<?php

namespace App\Filament\Resources;

use Carbon\Carbon;
use App\Models\Car;
use Filament\Forms;
use Filament\Tables;
use App\Models\RentCar;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Model;
use Filament\Forms\Components\DatePicker;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Actions\Action;
use App\Filament\Resources\RentCarResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\RentCarResource\RelationManagers;

class RentCarResource extends Resource
{
    protected static ?string $model = RentCar::class;

    protected static ?string $navigationIcon = 'heroicon-o-bookmark-square';

    protected static ?string $navigationGroup = 'Data Rental';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Sewa Mobil')
                    ->description('Isi form ini untuk melakukan sewa mobil')
                    ->schema([
                        DatePicker::make('start_date')
                            ->label('Tanggal Mulai Sewa')
                            ->required()
                            ->native(false)
                            ->locale('id')
                            ->closeOnDateSelection()
                            ->displayFormat('l, d F Y')
                            ->format('Y-m-d')
                            ->live()
                            ->minDate(Carbon::tomorrow())
                            ->live()
                            ->afterStateUpdated(function ($set, $state) {
                                $set('end_date', Carbon::parse($state)->addDay()->format('Y-m-d'));
                            })
                            ->columnSpanFull(),
                        DatePicker::make('end_date')
                            ->label('Tanggal Pengembalian')
                            ->required()
                            ->native(false)
                            ->locale('id')
                            ->closeOnDateSelection()
                            ->displayFormat('l, d F Y')
                            ->format('Y-m-d')
                            ->live()
                            ->minDate(function (callable $get) {
                                $startDate = $get('start_date');
                                return $startDate ? Carbon::parse($startDate)->addDay() : null;
                            })
                            ->columnSpanFull(),
                        Select::make('id_car')
                            ->label('Mobil')
                            ->required()
                            ->live()
                            ->options(function(): array {
                                return Car::where('status', 'Available')->get()->mapWithKeys(function ($car) {
                                    return [$car->id => $car->brand . ' ' . $car->model . ' (' . $car->license_plate . ')'];
                                })->toArray();
                            })
                            ->native(false)
                            ->searchable()
                            ->columnSpanFull(),
                        Placeholder::make('car_price')
                            ->label('Harga Sewa Mobil')
                            ->content(function ($get) {
                                $carId = $get('id_car');
                                $car = Car::find($carId);
                                return "Rp " . number_format($car ? $car->rates : 0, 0, ',', '.');
                            }),
                        Placeholder::make('total_price')
                            ->label('Total Biaya')
                            ->content(function ($get) {
                                $startDate = Carbon::parse($get('start_date'));
                                $endDate = Carbon::parse($get('end_date'));
                                $carId = $get('id_car');
                                $days = $startDate && $endDate ? $startDate->diffInDays($endDate) : 0;
                                $car = Car::find($carId);
                                $rate = $car ? $car->rates : 0;
                                $total = $days * $rate;
                                return "Rp " . number_format($total, 0, ',', '.');
                            }),
                    ])
                    ->footerActions([
                        Action::make('create')
                            ->label('Sewa Mobil')
                            ->submit('store')
                            ->color('primary'),
                    ])
                    ->aside()
                    ->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id_car')
                    ->label('Mobil')
                    ->getStateUsing(fn (Model $record): string => $record->car->brand . ' ' . $record->car->model . ' (' . $record->car->license_plate . ')'),
                TextColumn::make('start_date')
                    ->label('Mulai Sewa')
                    ->date(),
                TextColumn::make('end_date')
                    ->label('Pengembalian')
                    ->date(),
                TextColumn::make('car.rates')
                    ->label('Harga Sewa')
                    ->sortable()
                    ->money('IDR', true),
                TextColumn::make('total')
                    ->label('Total Harga')
                    ->sortable()
                    ->money('IDR', true),
                TextColumn::make('created_at')
                    ->label('Dibuat')
                    ->date(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::where('status', 'Rented')->count();
    }

    public static function getEloquentQuery(): Builder
    {
        if (auth()->user()->role === 'Admin') {
            return parent::getEloquentQuery();
        } else {
            return parent::getEloquentQuery()->where('id_user', auth()->id())->where('status', 'Rented');
        }
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListRentCars::route('/'),
            'create' => Pages\CreateRentCar::route('/create'),
            'edit' => Pages\EditRentCar::route('/{record}/edit'),
        ];
    }
}
