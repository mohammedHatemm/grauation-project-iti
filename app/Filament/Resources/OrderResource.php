<?php

namespace App\Filament\Resources;

use App\Filament\Resources\OrderResource\Pages;
use App\Filament\Resources\OrderResource\RelationManagers;
use App\Models\Order;
use App\Models\Region;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Components\Tab;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\Wizard;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\HtmlString;

class OrderResource extends Resource
{
    protected static ?string $model = Order::class;

    protected static ?string $navigationIcon = 'heroicon-s-truck';

    protected static ?string $navigationGroup = "System Data";

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::where('status', 'pending')->count();
    }

    public static function getNavigationBadgeColor(): ?string
    {
        return static::getModel()::where('status', 'pending')->count() < 5 ? 'primary' : 'warning';
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Wizard::make([
                    Wizard\Step::make('Merchant Data')
                        ->icon('heroicon-m-user-circle')
                        ->description('enter the merchant info')
                        ->schema([
                            Forms\Components\Select::make('user_id')->label('Merchant')
                                ->options(User::where('role', 'merchant')->pluck('name', 'id'))->searchable()->required()->columnSpanFull(),
                            Forms\Components\Select::make('region_id')->label('Region')
                                ->options(Region::where('status', 'active')->pluck('name', 'id'))->searchable()->required()->columnSpanFull(),
                        ]),
                    Wizard\Step::make('Client Data')
                        ->description('enter the Client info')
                        ->icon('heroicon-m-identification')
                        ->schema([
                            Forms\Components\TextInput::make('client_name')->label('Client Name')->required(),
                            Forms\Components\TextInput::make('client_phone')->label('Client Phone')->required(),
                            Forms\Components\TextInput::make('client_city')->label('Client City')->required(),
                            Forms\Components\Checkbox::make('village')->label('Village'),
                        ]),
                    Wizard\Step::make('Product Data')
                        ->icon('heroicon-m-shopping-bag')
                        ->description('insert your products')
                        ->schema([
                            Forms\Components\Repeater::make('products')->label('Product')
                                ->schema([
                                    Forms\Components\TextInput::make('product_name'),
                                    Forms\Components\TextInput::make('product_weight'),
                                    Forms\Components\TextInput::make('product_quantity'),
                                    Forms\Components\TextInput::make('product_price'),
                                ])->columns(4)->collapsible(),
                        ]),
                    Wizard\Step::make('Shipping Info')
                        ->description('how to ship it')
                        ->icon('heroicon-m-truck')
                        ->schema([
                            Forms\Components\Select::make('shipping_type')->label('Shipping Type')
                                ->options([
                                    'normal' => 'Normal',
                                    'shipping_in_24_hours' => 'Shipping in 24 hours'
                                ]),
                            Forms\Components\Select::make('payment_type')->label('Payment Type')
                                ->options([
                                    'on_delivery' => 'On Delivery',
                                    'online_payment' => 'Online Payment',
                                    'before_shipping' => 'Before Shipping'
                                ]),
                            Forms\Components\Select::make('status')->label('Status')
                                ->options([
                                    'pending' => 'Pending',
                                    'rejected' => 'Rejected',
                                    'processing' => 'Processing',
                                    'on_shipping' => 'On Shipping',
                                    'shipped' => 'Shipped'
                                ]),
                        ])
                ])->columnSpanFull()
                    ->persistStepInQueryString()
                    ->skippable()
                    ->submitAction(new HtmlString(Blade::render(<<<BLADE
    <x-filament::button
        type="submit"
        size="sm"
    >
        Create Order
    </x-filament::button>
BLADE
                    )))
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user.name')->searchable()->label('Merchant Name'),
                Tables\Columns\TextColumn::make('region.name')->searchable()->label('Governorate Name'),
                Tables\Columns\TextColumn::make('client_name')->searchable(),
                Tables\Columns\TextColumn::make('client_phone')->searchable(),
                Tables\Columns\TextColumn::make('client_city')->searchable(),
                Tables\Columns\IconColumn::make('village')
                    ->icon(fn(string $state): string => match ($state) {
                        '1' => 'heroicon-o-check-circle',
                        '0' => 'heroicon-o-x-circle',
                    })
                    ->color(fn(string $state): string => match ($state) {
                        '1' => 'success',
                        '0' => 'danger',
                    })
                    ->label('Village'),

                Tables\Columns\TextColumn::make('products')
                    ->label('Products')
                    ->formatStateUsing(function ($state) {
                        if (is_array($state)) {
                            $products = $state;
                        } else {
                            $jsonString = '[' . $state . ']';
                            $products = json_decode($jsonString, true);
                        }

                        if (!$products) {
                            return '';
                        }

                        return collect($products)->map(function ($product) {
                            return $product['product_name'] . ' (' .
                                $product['product_quantity'] . ' pcs, ' .
                                $product['product_weight'] . ' kg, ' . $product['product_price'] . ' EGP)';
                        })->join('<br>');
                    })
                    ->html(),
                Tables\Columns\TextColumn::make('shipping_type')->sortable(),
                Tables\Columns\TextColumn::make('payment_type')->sortable(),
                Tables\Columns\TextColumn::make('status')->sortable(),
                Tables\columns\TextColumn::make('order_price')->searchable(),
                Tables\columns\TextColumn::make('shipping_price')->searchable(),
                Tables\columns\TextColumn::make('total_price')->searchable(),
                Tables\columns\TextColumn::make('total_weight')->searchable(),

            ])
            ->filters([
                Tables\Filters\SelectFilter::make('shipping_type')
                    ->options([
                        'normal' => 'Normal',
                        'shipping_in_24_hours' => '24 hour Shipping',
                    ]),
                Tables\Filters\SelectFilter::make('payment_type')
                    ->options([
                        'on_delivery' => 'On Delivery',
                        'online_payment' => 'Online Payment',
                        'before_shipping' => 'Before Shopping',
                    ]),
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'pending' => 'Pending',
                        'processing' => 'Processing',
                        'on_shipping' => 'On Shipping',
                        'shipped' => 'Shipped',
                        'rejected' => 'Rejected',
                    ])
            ])
            ->actions([
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
            'index' => Pages\ListOrders::route('/'),
            'create' => Pages\CreateOrder::route('/create'),
            'edit' => Pages\EditOrder::route('/{record}/edit'),
        ];
    }
}
