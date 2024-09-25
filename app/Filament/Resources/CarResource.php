<?php

namespace App\Filament\Resources;

use App\Models\Car;
use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Support\RawJs;
use Filament\Resources\Resource;
use Filament\Tables\Filters\Filter;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\CarResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\CarResource\RelationManagers;

class CarResource extends Resource
{
    protected static ?string $model = Car::class;

    protected static ?string $navigationIcon = 'heroicon-o-truck';

    protected static ?string $navigationGroup = 'Data Master';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('brand')
                    ->label('Merek Mobil')
                    ->placeholder('Honda')
                    ->required(),
                TextInput::make('model')
                    ->label('Model Mobil')
                    ->placeholder('Jazz')
                    ->required(),
                TextInput::make('license_plate')
                    ->label('Plat Nomor')
                    ->placeholder('B 1234 AB')
                    ->maxLength(12)
                    ->required(),
                TextInput::make('rates')
                    ->label('Harga Sewa')
                    ->placeholder('50,000')
                    ->prefix('Rp. ')
                    ->mask(RawJs::make('$money($input)'))
                    ->stripCharacters(',')
                    ->numeric()
                    ->required(),
                Select::make('status')
                    ->options([
                        'Available' => 'Tersedia',
                        'Not Available' => 'Tidak Tersedia',
                    ])
                    ->default('Available')
                    ->native(false)
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('brand')
                    ->label('Merek Mobil')
                    ->searchable(),
                TextColumn::make('model')
                    ->label('Model Mobil')
                    ->searchable(),
                TextColumn::make('license_plate')
                    ->label('Plat Nomor')
                    ->searchable(),
                TextColumn::make('rates')
                    ->label('Harga Sewa')
                    ->money('IDR', true)
                    ->sortable(),
                TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'Available' => 'success',
                        'Not Available' => 'danger',
                    }),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->options([
                        'Available' => 'Tersedia',
                        'Not Available' => 'Tidak Tersedia',
                    ])
                    ->native(false),
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

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCars::route('/'),
            'create' => Pages\CreateCar::route('/create'),
            'edit' => Pages\EditCar::route('/{record}/edit'),
        ];
    }
}
