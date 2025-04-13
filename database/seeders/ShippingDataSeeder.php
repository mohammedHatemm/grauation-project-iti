<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Region;
use App\Models\Order;
use App\Models\RegionDelivery;
use App\Models\OrderDelivery;

class ShippingDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        
        $employee = User::create([
            'name' => 'khaled',
            'email' => 'Khaled@employee.com',
            'password' => bcrypt('password'),
            'role' => 'employee',
        ]);

       
        $deliveryMan = User::create([
            'name' => 'Saad',
            'email' => 'Saad@delivery_man.com',
            'password' => bcrypt('password'),
            'role' => 'delivery_man',
        ]);

        
        $region = Region::create([
            'name' => 'Benha',
            'status' => 'active',
        ]);

        
        RegionDelivery::create([
            'user_id' => $deliveryMan->id,
            'region_id' => $region->id,
        ]);

        
        $order = Order::create([
            'user_id' => $employee->id, 
            'region_id' => $region->id,
            'client_name' => 'Hoda',
            'client_phone' => '01093547746',
            'client_city' => 'Benha',
            'shipping_type' => 'normal',
            'payment_type' => 'on_delivery',
            'products' => json_encode(['jacket', 'T_shirt']),
            'status' => 'pending',
            'total_price' => 1000,
            'total_weight' => 1,
        ]);

       
        $orderDelivery = OrderDelivery::create([
            'user_id' => $deliveryMan->id, 
            'order_id' => $order->id,
        ]);

        
        $orderDelivery->update([
            'user_id' => $deliveryMan->id, 
        ]);
    }
}