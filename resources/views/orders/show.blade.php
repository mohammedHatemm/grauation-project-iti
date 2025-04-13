<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-100 leading-tight">
            {{ __('Order Details') }}
        </h2>
    </x-slot>

    <div class="py-12">
        @if(session('success'))
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mb-4">
                <div class="bg-green-600 border border-green-400 text-white px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            </div>
        @endif

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-[#18181b] text-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <div class="grid grid-cols-1 md-grid-cols-2 gap-8">
                    <div>
                        <h3 class="text-lg font-medium mb-4 text-[#10b981]">Customer Information</h3>
                        <p><strong>Name:</strong> {{ $order->client_name }}</p>
                        <p><strong>Phone:</strong> {{ $order->client_phone }}</p>
                        <p><strong>City:</strong> {{ $order->client_city }}</p>
                        <p><strong>Region:</strong> {{ $order->region->name }}</p>
                    </div>
                    <div>
                        <h3 class="text-lg font-medium mb-4 text-[#10b981]">Order Information</h3>
                        <p><strong>Shipping Type:</strong> {{ App\Models\Order::SHIPPING_TYPES[$order->shipping_type] }}</p>
                        <p><strong>Payment Type:</strong> {{ App\Models\Order::PAYMENT_TYPES[$order->payment_type] }}</p>
                        <p><strong>Status:</strong> {{ App\Models\Order::STATUS[$order->status] }}</p>
                        <p><strong>Products:</strong>
                        <ol class=" pl-4">
                            @foreach($order->products as $product)
                                <li class="py-2">
                                    Name: <strong>{{ $product['product_name'] ?? 'Unknown Product' }}</strong> -
                                    Quantity: <strong>{{ $product['product_quantity'] ?? 0 }}</strong> -
                                    Weight: <strong>{{ $product['product_weight'] }} Kg</strong> -
                                    Price: <strong>{{$product['product_price']}} EGP</strong>
                                </li>
                            @endforeach
                        </ol>
                        <p><strong>Order price:</strong> {{ $order->order_price }}</p>
                        <p><strong>Shipping price:</strong> {{ $order->shipping_price }}</p>
                        <p><strong>Total price:</strong> {{ $order->total_price }}</p>
                        <p><strong>Total weight:</strong> {{ $order->total_weight }}</p>
                    </div>
                </div>

                <div class="mt-8 flex flex-wrap gap-3">
                    <a href="{{ route('orders.report') }}" class="bg-transparent border border-[#10b981] hover:bg-[#10b981] transition  duration-300  text-white py-2 px-4 rounded-lg shadow-md">
                        Back to Home
                    </a>
                    @if(!in_array($order->status, ['on_shipping', 'shipped']))
                        <a href="{{ route('orders.edit', $order) }}" class="bg-[#10b981] hover:bg-[#0e9e73] transition  duration-300 text-white py-2 px-4 rounded-lg shadow-md">
                            Update my order
                        </a>
                        <form id="delete-form" action="{{ route('orders.destroy', $order) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="button" id="delete-button" class="bg-[#6b7280] hover:bg-[#374151] transition  duration-300 text-white py-2 px-4 rounded-lg shadow-md">
                                Delete my order
                            </button>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.getElementById('delete-button').addEventListener('click', function (event) {
            event.preventDefault();
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#10b981',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('delete-form').submit();
                }
            });
        });
    </script>
</x-app-layout>
