<?php

namespace App\Filament\Resources;

use Filament\Forms;
use App\Models\User;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Support\RawJs;
use Filament\Resources\Resource;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\UserResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\UserResource\RelationManagers;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';

    protected static ?string $navigationGroup = 'Data Master';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('role')
                    ->label('Role User')
                    ->options([
                        'User' => 'User',
                        'Admin' => 'Admin',
                    ])
                    ->default('User')
                    ->native(false)
                    ->required(),
                TextInput::make('no_sim')
                    ->label('Nomor SIM')
                    ->unique(ignoreRecord: true)
                    ->maxLength(12)
                    ->required(),
                TextInput::make('name')
                    ->label('Nama User')
                    ->autocomplete(false)
                    ->required(),
                TextInput::make('email')
                    ->label('Email User')
                    ->email()
                    ->unique(ignoreRecord: true)
                    ->required(),
                TextInput::make('phone')
                    ->label('Nomor Telepon')
                    ->unique(ignoreRecord: true)
                    ->mask(RawJs::make(<<<'JS'
                        $input.startsWith('0') ? '999999999999' : ($input.startsWith('62') ? '9999999999999' : '999999999999')
                    JS))
                    ->tel()
                    ->required(),
                TextInput::make('password')
                    ->label('Password User')
                    ->password()
                    ->autocomplete(false)
                    ->required(),
                Textarea::make('address')
                    ->label('Alamat User')
                    ->autosize()
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('role')
                    ->label('Role')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'User' => 'success',
                        'Admin' => 'info',
                    })
                    ->searchable(),
                TextColumn::make('no_sim')
                    ->label('Nomor SIM')
                    ->searchable(),
                TextColumn::make('name')
                    ->label('Nama User')
                    ->searchable(),
                TextColumn::make('email')
                    ->label('Email User')
                    ->searchable(),
                TextColumn::make('phone')
                    ->label('Nomor Telepon')
                    ->searchable(),
                TextColumn::make('address')
                    ->label('Alamat User')
                    ->wrap(),
            ])
            ->filters([
                SelectFilter::make('role')
                    ->options([
                        'User' => 'User',
                        'Admin' => 'Admin',
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
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
