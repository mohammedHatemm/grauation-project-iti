<?php
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\DeliveryManController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OrderDeliveryController;
use Livewire\Livewire;


//! laravel 3ady
Route::get('/', function () {
    return view('welcome');
});


//? rawda delivery man
Route::middleware(['auth'])->group(function () {
    Route::get('/my-orders', [OrderDeliveryController::class, 'myOrders'])->name('orders.myOrders');
    Route::get('/orders/delidash', [OrderDeliveryController::class, 'delidashboard'])->name('orders.delidash');
    Route::get('/orders/{id}/view', [OrderDeliveryController::class, 'viewOrder'])->name('orders.view');
    Route::post('/orders/{id}/update-status', [OrderDeliveryController::class, 'updateStatus'])->name('orders.updateStatus');
});



//? menna employee
Route::middleware(['auth'])->group(function ()  {
    Route::get('/employee/orders', [EmployeeController::class, 'index'])->name('employee.orders.index');
    Route::get('/employee/orders/pending', [EmployeeController::class, 'pendingOrders'])->name('employee.orders.pending');
    Route::get('/employee/orders/empdash', [EmployeeController::class, 'empdashboard'])->name('employee.orders.empdash');
    Route::get('/employee/orders/show/{id}', [EmployeeController::class, 'showOrder'])->name('employee.orders.show');
    Route::post('/employee/orders/{order}/assign-delegate/{delegate}', [EmployeeController::class, 'assignDelegate']);
    Route::post('/employee/orders/reject-order/{orderId}', [EmployeeController::class, 'rejectOrder'])->name('employee.rejectOrder');
    Route::post('/employee/orders/confirm-processing/{orderId}', [EmployeeController::class, 'confirmProcessing'])->name('employee.orders.confirm.processing');
    Route::get('/employee/orders/{orderId}/delegates', [EmployeeController::class, 'getDelegates']);
    Route::post('/employee/orders/regions/activate/{regionId}', [EmployeeController::class, 'activateRegion'])->name('employee.activateRegion');
    Route::post('/employee/orders/store', [EmployeeController::class, 'store'])->name('employee.orders.store');
    Route::get('/employee/orders/create', [EmployeeController::class, 'create'])->name('employee.orders.create');
    // Route::get('{order}/delegates', [OrderController::class, 'getDelegates'])->name('employee.orders.delegates');
    // Route::get('/employee/orders/my-orders', [EmployeeController::class, 'myOrders'])->name('employee.orders.my_orders');

});

//! da laravel 3ady
Route::get('/dashboard', function () {
    return abort(403);
})->middleware(['auth', 'verified'])->name('dashboard');


Route::middleware('auth')->group(function (){
//? mostafa merchant
    Route::resource('orders', OrderController::class);
    Route::put('orders/{order}/status', [OrderController::class, 'updateStatus'])->name('orders.update-status');
    Route::get('orders-report', [OrderController::class, 'report'])->name('orders.report');
    Route::get('/conclusion', [OrderController::class, 'conclusion'])->name('conclusion');
});



//! da laravel 3ady
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

});

require __DIR__.'/auth.php';
