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
  protected static ?string $navigationLabel = 'أسعار الشحن';
  protected static ?string $modelLabel = 'سعر الشحن';

  public static function form(Form $form): Form
  {
    $latestRate = ShippingRate::latest()->first();

    return $form
      ->schema([
        TextInput::make('old_base_shipping_price')
          ->label('السعر الأساسي القديم')
          ->default($latestRate?->base_shipping_price ?? 0)
          ->disabled()
          ->dehydrated(false)
          ->numeric()
          ->prefix('EGP '),
        TextInput::make('base_shipping_price')
          ->label('سعر الشحن الأساسي')
          ->required()
          ->numeric()
          ->minValue(0),
        TextInput::make('old_extra_weight_price_per_kg')
          ->label('سعر الكيلو الإضافي القديم')
          ->default($latestRate?->extra_weight_price_per_kg ?? 0)
          ->disabled()
          ->dehydrated(false)
          ->numeric()
          ->prefix('EGP '),
        TextInput::make('extra_weight_price_per_kg')
          ->label('سعر الكيلو الإضافي')
          ->required()
          ->numeric()
          ->minValue(0),
        TextInput::make('old_village_fee')
          ->label('رسوم القرية القديمة')
          ->default($latestRate?->village_fee ?? 0)
          ->disabled()
          ->dehydrated(false)
          ->numeric()
          ->prefix('EGP '),
        TextInput::make('village_fee')
          ->label('رسوم القرية')
          ->required()
          ->numeric()
          ->minValue(0),
        TextInput::make('old_express_shipping_fee')
          ->label('رسوم الشحن السريع القديمة')
          ->default($latestRate?->express_shipping_fee ?? 0)
          ->disabled()
          ->dehydrated(false)
          ->numeric()
          ->prefix('EGP '),
        TextInput::make('express_shipping_fee')
          ->label('رسوم الشحن السريع')
          ->required()
          ->numeric()
          ->minValue(0),
        TextInput::make('old_weight_limit')
          ->label('حد الوزن الأساسي القديم')
          ->default($latestRate?->weight_limit ?? 0)
          ->disabled()
          ->dehydrated(false)
          ->suffix(' كجم'),
        TextInput::make('weight_limit')
          ->label('حد الوزن الأساسي')
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
          ->label('سعر الشحن الأساسي')
          ->numeric()
          ->prefix('EGP '),
        TextColumn::make('extra_weight_price_per_kg')
          ->label('سعر الكيلو الإضافي')
          ->numeric()
          ->prefix('EGP '),
        TextColumn::make('village_fee')
          ->label('رسوم القرية')
          ->numeric()
          ->prefix('EGP '),
        TextColumn::make('express_shipping_fee')
          ->label('رسوم الشحن السريع')
          ->numeric()
          ->prefix('EGP '),
        TextColumn::make('weight_limit')
          ->label('حد الوزن الأساسي')
          ->suffix(' كجم'),
        TextColumn::make('updated_at')
          ->label('آخر تحديث')
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
