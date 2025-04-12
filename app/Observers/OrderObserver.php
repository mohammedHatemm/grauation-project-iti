<?php

namespace App\Observers;

use App\Models\Order;
use App\Models\ShippingRate;

class OrderObserver
{
    /**
     * Handle the Order "created" event.
     */


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

        // الحصول على أحدث أسعار الشحن من قاعدة البيانات
        $shippingRate = ShippingRate::latest()->first();
        if (!$shippingRate) {
            $shippingRate = ShippingRate::create([
                'base_shipping_price' => 20.00,
                'extra_weight_price_per_kg' => 10.00,
                'village_fee' => 20.00,
                'express_shipping_fee' => 20.00,
                'weight_limit' => 5.00
            ]);
        }

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
        $order->total_weight = 0;
        $order->total_price = 0;
        $order->order_price = 0;
        $order->shipping_price = 0;

        // حساب الوزن الكلي وسعر الطلب
        foreach ($order->products as $product) {
            $order->total_weight += $product['product_weight'] * $product['product_quantity'];
            $order->order_price += $product['product_price'] * $product['product_quantity'];
        }

        // الحصول على أحدث أسعار الشحن من قاعدة البيانات
        $shippingRate = ShippingRate::latest()->first();
        if (!$shippingRate) {
            $shippingRate = ShippingRate::create([
                'base_shipping_price' => 20.00,
                'extra_weight_price_per_kg' => 10.00,
                'village_fee' => 20.00,
                'express_shipping_fee' => 20.00,
                'weight_limit' => 5.00
            ]);
        }

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
