<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\RelationManagers;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-m-user';

    protected static ?string $navigationGroup = "System Data";


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')->required(),
                Forms\Components\TextInput::make('email')->email()->required(),
                Forms\Components\TextInput::make('password')->password()->required(),
                Forms\Components\Select::make('role')->label('Role')
                ->options([
                    'merchant'=>'Merchant',
                    'employee'=>'Employee',
                    'delivery_man'=>'Delivery Man',
                ])->required(),
                Forms\Components\TextInput::make('company_name')->label('Company Name')->nullable(),
                Forms\Components\TextInput::make('address')->label('Address')->nullable(),
                Forms\Components\Select::make('gender')->label('Gender')
                ->options([
                    'male'=>'Male',
                    'female'=>'Female'
                ])->nullable(),
                Forms\Components\TextInput::make('phone')->label('Phone Number')->nullable(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')->searchable()->label('Name')->alignCenter(),
                Tables\Columns\TextColumn::make('email')->searchable()->label('Email')->alignCenter(),
                Tables\Columns\TextColumn::make('role')->label('Role')->alignCenter(),
                Tables\Columns\TextColumn::make('company_name')->searchable()->label('Company Name')->placeholder('No company name')->alignCenter(),
                Tables\Columns\TextColumn::make('address')->searchable()->label('Address')->placeholder('No Address')->alignCenter(),
                Tables\Columns\TextColumn::make('gender')->label('Gender')->placeholder('No gender added')->alignCenter(),
                Tables\Columns\TextColumn::make('phone')->label('Phone')->placeholder('No phone added')->alignCenter(),

            ])
            ->filters([
                Tables\Filters\SelectFilter::make('role')
                ->options([
                    'merchant'=>'Merchant',
                    'employee'=>'Employee',
                    'delivery_man'=>'Delivery Man',
                ]),
                Tables\Filters\SelectFilter::make('gender')
                ->options([
                    'male'=>'Male',
                    'female'=>'Female',
                ])
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
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
