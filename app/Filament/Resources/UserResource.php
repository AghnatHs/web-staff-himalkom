<?php

namespace App\Filament\Resources;

use Log;
use Dom\Text;
use Filament\Forms;
use App\Models\User;
use Filament\Tables;
use Filament\Forms\Form;
use App\Models\Department;
use Filament\Tables\Table;
use Illuminate\Support\Str;
use Filament\Resources\Resource;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Filament\Forms\Components\Select;
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

    protected static ?string $navigationIcon = 'heroicon-o-user';

    public static function getNavigationGroup(): ?string
    {
        return 'User';
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')->placeholder("Ex. Budi Utomo")->required(),
                TextInput::make('email')->email()->required(),
                Select::make('role_id')
                    ->label('Role')
                    ->options(Role::pluck('name', 'id'))
                    ->searchable()
                    ->preload()
                    ->required(),
                Select::make('department_id')
                    ->label('Department')
                    ->options(Department::pluck('name', 'id'))
                    ->searchable()
                    ->preload()
                    ->required()
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id'),
                TextColumn::make('name')->searchable(),
                TextColumn::make('email')->searchable(),
                TextColumn::make('department.name')
                    ->placeholder('Null')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('roles.name')
                    ->placeholder('Null')
            ])
            ->filters([
                SelectFilter::make('role')
                    ->label('Filter by Role')
                    ->options(Role::pluck('name', 'name'))
                    ->query(fn($query, $data) => $query->whereHas('roles', fn($q) => $q->where('name', $data))),
                SelectFilter::make('department')
                    ->label('Filter by Department')
                    ->options(Department::pluck('name', 'name'))
                    ->query(fn($query, $data) => $query->whereHas('department', fn($q) => $q->where('name', $data)))
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

    public static function afterCreate($record)
    {
        $randomPassword = Str::random(12);
        $record->password = Hash::make($randomPassword);
        $record->save();
        info("New user created: {$record->email} | Password: {$randomPassword}");
    }

    public static function getRelations(): array
    {
        return [];
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
