<?php

namespace App\Observers;

use App\Models\Order;
use App\Models\ShippingRate;
use App\Models\User;

class OrderObserver
{
    /**
     * Handle the Order "created" event.
     */
    public function created(Order $order): void
    {
        // Notify employees about the new order
        $employees = User::where('role', 'employee')->get();

        foreach ($employees as $employee) {
            $employee->customNotify('new_order', [
                'title' => 'New Order Created',
                'message' => "A new order has been created by {$order->user->name}"
            ]);
        }

        // Notify merchants about the new order
        $merchants = User::where('role', 'merchant')->get();

        foreach ($merchants as $merchant) {
            $merchant->customNotify('new_order', [
                'title' => 'New Purchase Order',
                'message' => "New order #{$order->id} requires your attention"
            ]);
        }
    }

    public function creating(Order $order): void
    {
        $order->total_weight = 0;
        $order->total_price = 0;
        $order->order_price = 0;
        $order->shipping_price = 0;

        // حساب الوزن الكلي وسعر الطلب
        foreach ($order->products as $product) {
            $order->total_weight += $product['product_weight'] * $product['product_quantity'];
            $order->order_price += $product['product_price'] * $product['product_quantity'];
        }

        // استخدام أحدث معدلات الشحن عند إنشاء الطلب
        $shippingRateData = ShippingRate::getCurrentPrices();
        if (!$shippingRateData) {
            // إذا لم يكن هناك معدل شحن، استخدم المعدل الافتراضي
            $shippingRate = ShippingRate::create([
                'base_shipping_price' => 20.00,
                'extra_weight_price_per_kg' => 10.00,
                'village_fee' => 20.00,
                'express_shipping_fee' => 20.00,
                'weight_limit' => 5.00
            ]);
        } else {
            $shippingRate = ShippingRate::find($shippingRateData['id']);
        }
        $order->shipping_rate_id = $shippingRate->id;

        // حساب سعر الشحن الأساسي
        $order->shipping_price = $shippingRate->base_shipping_price;

        // إضافة رسوم الوزن الزائد
        if ($order->total_weight > $shippingRate->weight_limit) {
            $extra_weight = $order->total_weight - $shippingRate->weight_limit;
            $order->shipping_price += $extra_weight * $shippingRate->extra_weight_price_per_kg;
        }

        // إضافة رسوم القرية إذا كان التوصيل للقرية
        if ($order->village) {
            $order->shipping_price += $shippingRate->village_fee;
        }

        // إضافة رسوم الشحن السريع
        if ($order->shipping_type === 'shipping_in_24_hours') {
            $order->shipping_price += $shippingRate->express_shipping_fee;
        }

        // حساب السعر الإجمالي
        $order->total_price = $order->shipping_price + $order->order_price;
    }

    /**
     * Handle the Order "updated" event.
     */
    public function updated(Order $order): void
    {
        // Check if status was changed
        if ($order->isDirty('status')) {
            $merchants = User::where('role', 'merchant')->get();
            foreach ($merchants as $merchant) {
                $merchant->customNotify('order_status_changed', [
                    'title' => 'Order Status Updated',
                    'message' => "Order #{$order->id} status has been updated to {$order->status}",
                    'order_id' => $order->id,
                    'status' => $order->status
                ]);
            }
        }

        $order->total_weight = 0;
        $order->total_price = 0;
        $order->order_price = 0;
        $order->shipping_price = 0;

        // حساب الوزن الكلي وسعر الطلب
        foreach ($order->products as $product) {
            $order->total_weight += $product['product_weight'] * $product['product_quantity'];
            $order->order_price += $product['product_price'] * $product['product_quantity'];
        }

        // استخدام أحدث معدلات الشحن عند إنشاء الطلب
        $shippingRateData = ShippingRate::getRatesForOrderEdit($order);
        if (!$shippingRateData) {
            // إذا لم يكن هناك معدل شحن، استخدم المعدل الافتراضي
            $shippingRate = ShippingRate::create([
                'base_shipping_price' => 20.00,
                'extra_weight_price_per_kg' => 10.00,
                'village_fee' => 20.00,
                'express_shipping_fee' => 20.00,
                'weight_limit' => 5.00
            ]);
        } else {
            $shippingRate = ShippingRate::find($shippingRateData['id']);
        }
        $order->shipping_rate_id = $shippingRate->id;

        // حساب سعر الشحن الأساسي
        $order->shipping_price = $shippingRate->base_shipping_price;

        // إضافة رسوم الوزن الزائد
        if ($order->total_weight > $shippingRate->weight_limit) {
            $extra_weight = $order->total_weight - $shippingRate->weight_limit;
            $order->shipping_price += $extra_weight * $shippingRate->extra_weight_price_per_kg;
        }

        // إضافة رسوم القرية إذا كان التوصيل للقرية
        if ($order->village) {
            $order->shipping_price += $shippingRate->village_fee;
        }

        // إضافة رسوم الشحن السريع
        if ($order->shipping_type === 'shipping_in_24_hours') {
            $order->shipping_price += $shippingRate->express_shipping_fee;
        }

        // حساب السعر الإجمالي
        $order->total_price = $order->shipping_price + $order->order_price;

        $order->saveQuietly();
    }

    /**
     * Handle the Order "deleted" event.
     */
    public
    function deleted(Order $order): void
    {
        //
    }

    /**
     * Handle the Order "restored" event.
     */
    public
    function restored(Order $order): void
    {
        //
    }

    /**
     * Handle the Order "force deleted" event.
     */
    public
    function forceDeleted(Order $order): void
    {
        //
    }
}
