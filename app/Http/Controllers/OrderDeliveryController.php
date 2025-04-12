<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\RegionDelivery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderDeliveryController extends Controller
{

    public function myOrders()
    {
        $user = Auth::user();


        $orders = Order::whereIn('id', function ($query) use ($user) {
            $query->select('order_id')
                ->from('order_deliveries')
                ->where('user_id', $user->id)
                ->whereNotIn('status', ['pending', 'rejected']);
        })->orderBy('status')->paginate(5);
        if($user->role === 'delivery_man'){
        return view('orders.my_orders', compact('orders'));
    }
    else{
        abort(403);

    }
}

    public function viewOrder($id)
    {
        $user = Auth::user();


        $order = Order::where('id', $id)
            ->whereIn('id', function ($query) use ($user) {
                $query->select('order_id')
                    ->from('order_deliveries')
                    ->where('user_id', $user->id);
            })->firstOrFail();

        if($user->role === 'delivery_man'){
        return view('orders.view', compact('order'));
        }
        else{
            abort(403);
        }
    }

    public function updateStatus(Request $request, $id)
    {
        $order = Order::findOrFail($id);
        $order->status = $request->status;
        $order->save();

        return redirect()->back()->with('success', 'Order status updated successfully!');
    }

    public function delidashboard()
    {
        $user = Auth::user();
        $regions = RegionDelivery::where('user_id', $user->id)->get();
        $statistics = [
            'delivered' => Order::whereIn('id', function ($query) use ($user) {
                $query->select('order_id')
                    ->from('order_deliveries')
                    ->where('user_id', $user->id);})->where('status', 'shipped')->count(),
            'On_its_way' =>Order::whereIn('id', function ($query) use ($user) {
                $query->select('order_id')
                    ->from('order_deliveries')
                    ->where('user_id', $user->id);})->where('status', 'on_shipping')->count(),
            'Accepted_and_waiting' => Order::whereIn('id', function ($query) use ($user) {
                $query->select('order_id')
                    ->from('order_deliveries')
                    ->where('user_id', $user->id);})->where('status', 'processing')->count(),
        ];

        if ($user->role === 'delivery_man') {
            return view('orders.delidash', compact('statistics', 'regions'));
        }else{
            abort(403);
        }
    }



}
