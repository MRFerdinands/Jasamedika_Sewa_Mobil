<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\RentCar;
use Filament\Forms\Form;
use App\Models\ReturnCar;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Section;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\Actions\Action;
use App\Filament\Resources\ReturnCarResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\ReturnCarResource\RelationManagers;

class ReturnCarResource extends Resource
{
    protected static ?string $model = ReturnCar::class;

    protected static ?string $navigationIcon = 'heroicon-m-calendar-days';

    protected static ?string $navigationGroup = 'Data Rental';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Pengembalian Mobil')
                    ->description('Isi form ini untuk melakukan pengembalian mobil')
                    ->schema([
                        Select::make('id_car')
                            ->label('Mobil')
                            ->required()
                            ->options(function(): array {
                                return RentCar::where('id_user', auth()->user()->id)->where('status', 'Rented')->get()->mapWithKeys(function ($rent) {
                                    return [$rent->id => $rent->car->brand . ' ' . $rent->car->model . ' (' . $rent->car->license_plate . ')'];
                                })->toArray();
                            })
                            ->native(false)
                            ->searchable()
                            ->columnSpanFull(),
                    ])
                    ->footerActions([
                        Action::make('create')
                            ->label('Kembalikan Mobil')
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
                TextColumn::make('return_date')
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

    public static function getEloquentQuery(): Builder
    {
        if (auth()->user()->role === 'Admin') {
            return parent::getEloquentQuery();
        } else {
            return parent::getEloquentQuery()->where('id_user', auth()->id());
        }
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
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
            'index' => Pages\ListReturnCars::route('/'),
            'create' => Pages\CreateReturnCar::route('/create'),
            'edit' => Pages\EditReturnCar::route('/{record}/edit'),
        ];
    }
}
