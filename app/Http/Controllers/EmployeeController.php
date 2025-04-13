<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Order;
use App\Models\User;
use App\Models\Region;
use App\Models\RegionDelivery;
use App\Models\OrderDelivery;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

class EmployeeController extends Controller
{

    public function index()
    {
        $user = Auth::user();
        $orders = Order::with("region", "orderDelivery.user.region")->latest()->paginate(10);
        foreach ($orders as $order) {
            if ($order->region) {

                $hasDelegates = User::where('role', 'delivery_man')
                    ->whereHas('region', function ($query) use ($order) {
                        $query->where('region_id', $order->region->id);
                    })
                    ->exists();
                $order->region->status = $hasDelegates ? 'active' : 'not_active';
            }
        }
        if($user->role === 'employee'){
            return view('employee.orders.index', compact('orders'));
        }
        else{
            abort(403);
        }
    }

    public function pendingOrders()
    {
        $user = Auth::user();
        $orders = Order::with('region')->where('status', 'pending')->latest()->paginate(5);
        $delegates = User::where('role', 'delivery_man')->with('region')->paginate(5);
        foreach ($orders as $order) {
            if ($order->region) {

                $hasDelegates = User::where('role', 'delivery_man')
                    ->whereHas('region', function ($query) use ($order) {
                        $query->where('region_id', $order->region->id);
                    })
                    ->exists();
                $order->region->status = $hasDelegates ? 'active' : 'not_active';
            }
        }
        if($user->role === 'employee'){
            return view('employee.orders.pending', compact('orders', 'delegates'));
        }
        else{
            abort(403);
        }
    }

    public function activateRegion($regionId)
    {
        $region = Region::findOrFail($regionId);
        $region->update(['status' => 'active']);

        return redirect()->route('employee.orders.pending')->with('success', 'ٌRegion activated successfully');
    }


    public function showOrder($id)
    {
        $user = Auth::user();
        $order = Order::with('orderDelivery.user.region')->findOrFail($id);
        session(['previous_page' => url()->previous()]);

        if($user->role === 'employee') {
            return view('employee.orders.show', compact('order'));
        }
        else{
            abort(403);

        }
    }

    public function confirmProcessing($orderId)
    {
        $order = Order::findOrFail($orderId);


        $order->update(['status' => 'processing']);

        return redirect()->route('employee.orders.pending')->with('success', 'order confirmed successfully.');
    }


    public function getDelegates($orderId)
    {
        $delegates = User::select('users.*')
            ->join('region_deliveries', 'users.id', '=', 'region_deliveries.user_id')
            ->join('orders', 'region_deliveries.region_id', '=', 'orders.region_id')
            ->where('users.role', 'delivery_man')
            ->where('orders.id', $orderId)
            ->get()
            ->map(function ($delegate) {
                return [
                    'id' => $delegate->id,
                    'name' => $delegate->name,
                    'region' => $delegate->address,
                    'phone' => $delegate->phone,
                ];
            });

        return response()->json($delegates);
    }

    public function assignDelegate($orderId, $delegateId)
    {
        $order = Order::findOrFail($orderId);
        $delegate = User::findOrFail($delegateId);


        if ($order->orderDelivery()->where('user_id', $delegateId)->exists()) {
            return response()->json(['error' => 'This delivery has already been assigned.'], 400);
        }


        $order->orderDelivery()->updateOrCreate(['order_id' => $orderId], ['user_id' => $delegate->id]);

        return response()->json(['message' => 'Assigned successfully.']);
    }
    public function rejectOrder($orderId)
    {
        $order = Order::findOrFail($orderId);
        $order->status = 'rejected';
        $order->save();

        return redirect()->route('employee.orders.pending')->with('success', 'order rejected');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:6',
            'address' => 'nullable|string',
            'phone' => 'required|string',
            'region_id' => 'required|exists:regions,id',
        ]);

        try {
            DB::beginTransaction();


            $delegate = User::create([
                'name' => $validatedData['name'],
                'email' => $validatedData['email'],
                'password' => bcrypt($validatedData['password']),
                'address' => $validatedData['address'] ?? null,
                'phone' => $validatedData['phone'],
                'role' => 'delivery_man',
            ]);

            if (!$delegate) {
                throw new \Exception('Failed to create the delivery');
            }


            RegionDelivery::create([
                'user_id' => $delegate->id,
                'region_id' => $validatedData['region_id'],
            ]);


            Region::where('id', $validatedData['region_id'])->update(['status' => 'active']);

            DB::commit();

            return redirect()->route('employee.orders.pending')->with('success', 'delivery added and linked to the region successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', ' Error occurred while adding the delegate ' . $e->getMessage());
        }
    }

    public function create()
    {
        $regions = Region::all();
        return view('employee.orders.create', compact('regions'));
    }



    public function empdashboard()
    {
        $user = Auth::user();
        $statistics = [
            'delivered' => Order::where('status', 'shipped')
                ->count(),
            'On_its_way' => Order::where('status', 'on_shipping')
                ->count(),
            'Waiting' => Order::where('status', 'pending')
                ->count(),
            'Accepted_and_waiting' => Order::where('status', 'processing')
                ->count(),
            'Rejected' => Order::where('status', 'rejected')
                ->count(),
        ];

        if ($user->role === 'employee') {
            return view('employee.orders.empdash', compact('statistics'));
        }else{
            abort(403);
        }
    }



}
