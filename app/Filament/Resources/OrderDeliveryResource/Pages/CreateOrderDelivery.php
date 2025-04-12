<?php

namespace App\Filament\Resources\OrderDeliveryResource\Pages;

use App\Filament\Resources\OrderDeliveryResource;
use App\Models\Order;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateOrderDelivery extends CreateRecord
{
    protected static string $resource = OrderDeliveryResource::class;

    protected function afterCreate(): void
    {
        $order = Order::find($this->record->order_id);
        $order->update(['status' => 'processing']);
    }
}
