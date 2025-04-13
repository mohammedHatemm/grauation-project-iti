<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ShippingRateResource\Pages;
use App\Models\ShippingRate;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;

class ShippingRateResource extends Resource
{
  protected static ?string $model = ShippingRate::class;
  protected static ?string $navigationIcon = 'heroicon-o-truck';
  protected static ?string $navigationLabel = 'shiping prices';
  protected static ?string $modelLabel = 'shipping price';

  public static function form(Form $form): Form
  {
    $latestRate = ShippingRate::latest()->first();

    return $form
      ->schema([
        TextInput::make('old_base_shipping_price')
          ->label('old base shipping price')
          ->default($latestRate?->base_shipping_price ?? 0)
          ->disabled()
          ->dehydrated(false)
          ->numeric()
          ->prefix('EGP '),
        TextInput::make('base_shipping_price')
          ->label('base shipping price')
          ->required()
          ->numeric()
          ->minValue(0),
        TextInput::make('old_extra_weight_price_per_kg')
          ->label('old extra weight price per kg')
          ->default($latestRate?->extra_weight_price_per_kg ?? 0)
          ->disabled()
          ->dehydrated(false)
          ->numeric()
          ->prefix('EGP '),
        TextInput::make('extra_weight_price_per_kg')
          ->label('extra weight price per kg')
          ->required()
          ->numeric()
          ->minValue(0),
        TextInput::make('old_village_fee')
          ->label('old village fee')
          ->default($latestRate?->village_fee ?? 0)
          ->disabled()
          ->dehydrated(false)
          ->numeric()
          ->prefix('EGP '),
        TextInput::make('village_fee')
          ->label(' village fee')
          ->required()
          ->numeric()
          ->minValue(0),
        TextInput::make('old_express_shipping_fee')
          ->label('old express shipping fee')
          ->default($latestRate?->express_shipping_fee ?? 0)
          ->disabled()
          ->dehydrated(false)
          ->numeric()
          ->prefix('EGP '),
        TextInput::make('express_shipping_fee')
          ->label('express shipping fee')
          ->required()
          ->numeric()
          ->minValue(0),
        TextInput::make('old_weight_limit')
          ->label('old weight limit')
          ->default($latestRate?->weight_limit ?? 0)
          ->disabled()
          ->dehydrated(false)
          ->suffix('kg'),
        TextInput::make('weight_limit')
          ->label(' weight limit')
          ->required()
          ->numeric()
          ->minValue(0),
      ]);
  }

  public static function table(Table $table): Table
  {
    return $table
      ->columns([
        TextColumn::make('base_shipping_price')
          ->label(' base shipping price')
          ->numeric()
          ->prefix('EGP '),
        TextColumn::make('extra_weight_price_per_kg')
          ->label(' extra weight price per kg')
          ->numeric()
          ->prefix('EGP '),
        TextColumn::make('village_fee')
          ->label(' village fee')
          ->numeric()
          ->prefix('EGP '),
        TextColumn::make('express_shipping_fee')
          ->label('express shipping fee')
          ->numeric()
          ->prefix('EGP '),
        TextColumn::make('weight_limit')
          ->label(' weight limit')
          ->suffix(' kg'),
        TextColumn::make('created_at')
          ->label('created at')
          ->dateTime('d/m/Y H:i:s')
          ->sortable(),
      ]);
  }

  public static function getPages(): array
  {
    return [
      'index' => Pages\ListShippingRates::route('/'),
      'create' => Pages\CreateShippingRate::route('/create'),
      'edit' => Pages\EditShippingRate::route('/{record}/edit'),
    ];
  }
}
