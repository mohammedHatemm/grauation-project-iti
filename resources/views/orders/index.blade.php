<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Orders') }}
            </h2>
            <div class="flex gap-2">
                <a href="{{ route('conclusion') }}"
                    class="bg-purple-500 hover:bg-purple-700 text-white py-2 px-4 rounded">
                    Home

                </a>
                <a href="{{ route('orders.create') }}"
                    class="bg-blue-500 hover:bg-blue-700 text-white py-2 px-4 rounded">
                    Add a new request
                </a>
                <a href="{{ route('orders.report') }}"
                    class="bg-green-500 hover:bg-green-700 text-white py-2 px-4 rounded">
                    Requests report
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        @if(session('success'))
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mb-4">
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative"
                role="alert">
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        </div>
        @endif

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="mb-4 flex justify-between items-center">
                        <form action="{{ route('orders.index') }}" method="GET" class="flex gap-4">
                            <select name="status" class="rounded-md border-gray-300" onchange="this.form.submit()">
                                <option value="">All cases</option>@foreach(App\Models\Order::STATUS as $key => $value)
                                <option value="{{ $key }}" {{ request('status') == $key ? 'selected' : '' }}>
                                    {{ $value }}
                                </option>
                                @endforeach
                            </select>
                        </form>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 text-center">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-center text-base font-medium text-gray-500">
                                        Client
                                    </th>
                                    <th class="px-6 py-3 text-center text-base font-medium text-gray-500">
                                        Area
                                    </th>
                                    <th class="px-6 py-3 text-center text-base font-medium text-gray-500">
                                        Products
                                    </th>
                                    <th class="px-6 py-3 text-center text-base font-medium text-gray-500">
                                        Total price
                                    </th>
                                    <th class="px-6 py-3 text-center text-base font-medium text-gray-500">
                                        The Condition
                                    </th>
                                    <th class="px-6 py-3 text-center text-base font-medium text-gray-500">
                                        Operations
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($orders as $order)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $order->client_name }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $order->region->name }}</td>
                                    <td class="px-6 py-4">
                                        <ul class="list-disc list-inside">
                                            @foreach($order->products as $product)
                                            <li>
                                                {{ $product['product_name'] }}
                                                (quantity: {{ $product['product_quantity'] }},
                                                Weight: {{ number_format($product['product_weight'], 2) }} kg)

                                            </li>
                                            @endforeach
                                        </ul>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="space-y-1">
                                            <p>Order price: {{ number_format($order->order_price, 2) }} pounds</p>
                                            <p>Shipping price: {{ number_format($order->shipping_price, 2) }} pounds</p>
                                            <p class="font-bold">Total: {{ number_format($order->total_price, 2) }}
                                                pounds</p>
                                            <p>Weight: {{ number_format($order->total_weight, 2) }} kg</p>...
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span
                                            class="px-2 py-1 rounded {{ $order->status === 'shipped' ? 'bg-green-100 text-green-800' : '' }} {{ $order->status === 'rejected' ? 'bg-red-100 text-red-800' : '' }}">
                                            {{ App\Models\Order::STATUS[$order->status] }}
                                        </span>
                                    </td>

                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <div class="flex justify-end gap-2">
                                            <a href="{{ route('orders.show', $order) }}"
                                                class="bg-blue-500 hover:bg-blue-700 text-white py-1 px-3 rounded text-sm">

                                                View </a>

                                            @if(!in_array($order->status, ['on_shipping', 'shipped']))
                                            <a href="{{ route('orders.edit', $order) }}"
                                                class="bg-yellow-500 hover:bg-yellow-700 text-white py-1 px-3 rounded text-sm">
                                                Edit
                                            </a>

                                            <form action="{{ route('orders.destroy', $order) }}" method="POST"
                                                class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="bg-red-500 hover:bg-red-700 text-white py-1 px-3 rounded text-sm"
                                                    onclick="return confirm('Are you sure you want to delete this request?')">
                                                    Delete
                                                </button>
                                            </form>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="8" class="px-6 py-4 text-center">No orders yet</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-4">
                        {{ $orders->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>