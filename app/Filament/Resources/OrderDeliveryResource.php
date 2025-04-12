<?php

namespace App\Filament\Resources;

use App\Filament\Resources\OrderDeliveryResource\Pages;
use App\Filament\Resources\OrderDeliveryResource\RelationManagers;
use App\Models\Order;
use App\Models\OrderDelivery;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class OrderDeliveryResource extends Resource
{
    protected static ?string $model = OrderDelivery::class;

    protected static ?string $navigationIcon = 'heroicon-m-shopping-cart';

    protected static ?string $modelLabel = "Order Assignment";

    protected static ?string $navigationGroup = "Delivery System";

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('order_id')
                    ->label("Order's Client's name")
                    ->options(function (OrderDelivery $record = null) {
                        $query = Order::query();

                        if ($record) {
                            $query->where(function ($q) use ($record) {
                                $q->where('status', 'pending')
                                    ->orWhere('id', $record->order_id);
                            });
                        } else {
                            $query->where('status', 'pending');
                        }

                        return $query->pluck('client_name', 'id');
                    })
                    ->searchable()
                    ->reactive()
                    ->afterStateUpdated(fn (callable $set) => $set('user_id', null))
                    ->required(),

                Forms\Components\Select::make('user_id')
                    ->label('Delivery Man')
                    ->options(function (callable $get) {
                        $orderId = $get('order_id');

                        if (!$orderId) {
                            return [];
                        }

                        $orderRegionId = Order::find($orderId)?->region_id;

                        return User::query()
                            ->where('role', 'delivery_man')
                            ->whereHas('regionDelivery', function ($query) use ($orderRegionId) {
                                $query->where('region_id', $orderRegionId);
                            })
                            ->pluck('name', 'id');
                    })
                    ->searchable()
                    ->required()
                    ->disabled(fn (callable $get) => !$get('order_id')),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('order.client_name')
                ->label("Client's Name")->searchable()->alignCenter(),
                Tables\Columns\TextColumn::make('user.name')
                ->label("Delivery Man's Name")->alignCenter()->searchable(),
                Tables\Columns\TextColumn::make('order.region.name')
                ->label("Region Name")->alignCenter()->searchable(),
            ])
            ->filters([
                //
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
            'index' => Pages\ListOrderDeliveries::route('/'),
            'create' => Pages\CreateOrderDelivery::route('/create'),
            'edit' => Pages\EditOrderDelivery::route('/{record}/edit'),
        ];
    }
}
