<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Order Details') }}
            </h2>
        </div>
    </x-slot>

    @if(session('success'))
        <div class="container m-auto">
            <div id="alert-border-3"
                 class="flex items-center p-4 mb-4 text-[#10b981] border-t-4 border-green-300 bg-green-50 dark:text-green-400 dark:bg-gray-800 dark:border-[#10b981] rounded"
                 role="alert">
                <svg class="shrink-0 w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                     fill="currentColor" viewBox="0 0 20 20">
                    <path
                        d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
                </svg>
                <div class="ms-3 text-sm font-medium">
                    {{session('success')}}
                </div>
                <button type="button" onclick="dismissAlert()"
                        class="ms-auto -mx-1.5 -my-1.5 bg-green-50 text-green-500 rounded-lg focus:ring-2 focus:ring-green-400 p-1.5 hover:bg-green-200 inline-flex items-center justify-center h-8 w-8 dark:bg-gray-800 dark:text-green-400 dark:hover:bg-gray-700"
                        data-dismiss-target="#alert-border-3" aria-label="Close">
                    <span class="sr-only">Dismiss</span>
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                         viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                    </svg>
                </button>
            </div>
        </div>
        @push('script')
            <script>
                function dismissAlert() {
                    let alertBox = document.getElementById('alert-border-3');
                    if (alertBox) {
                        alertBox.style.display = 'none';
                    }
                }
            </script>
        @endpush
    @endif

    <div class="flex justify-center items-center min-h-screen">
        <div class="w-full m-20 max-w-4xl bg-[#202022] dark:bg-[#202022] shadow-lg rounded-lg p-6">
            <table class="w-full text-base text-left text-gray-700 dark:text-gray-300 border-collapse">
                <tbody class="text-center">
                @php
                    $fields = [
                        'Client Name' => $order->client_name,
                        'Phone Number' => $order->client_phone,
                        'City' => $order->client_city,
                        'Shipping Type' => ucfirst(str_replace('_', ' ', $order->shipping_type)),
                        'Payment Type' => ucfirst(str_replace('_', ' ', $order->payment_type)),
                        'Total Weight' => $order->total_weight . ' Kg',
                        'Order Price' => number_format($order->order_price, 2) . ' EGP',
                        'Shipping Price' => number_format($order->shipping_price, 2) . ' EGP',
                        'Total Price' => number_format($order->total_price, 2) . ' EGP'
                    ];
                @endphp

                @foreach($fields as $label => $value)
                    <tr class="border-b dark:border-gray-700">
                        <th class="px-6 py-4 w-20 font-medium text-gray-900 dark:text-white">{{ $label }}:</th>
                        <td class="px-6 py-6 w-20">{{ $value }}</td>
                    </tr>
                @endforeach

                <tr class="border-b dark:border-gray-700">
                    <th class="px-6 py-4 font-medium text-gray-900 dark:text-white">Village:</th>
                    <td class="px-6 py-6 flex justify-center">
                        @if($order->village == "1")
                            <x-heroicon-m-check-circle class="w-6 h-6 text-[#10b981]"/>
                        @else
                            <x-heroicon-s-x-circle class="w-6 h-6 text-red-600"/>
                        @endif
                    </td>
                </tr>

                <tr class="border-b dark:border-gray-700">
                    <th class="px-6 py-4 font-medium text-gray-900 dark:text-white">Products:</th>
                    <td class="px-6 py-6">
                        <ol class="pl-5">
                            @foreach($order->products as $product)
                                <li class="py-2">
                                    {{ $product['product_name'] ?? 'Unknown Product' }} -
                                    Quantity: {{ $product['product_quantity'] ?? 0 }} -
                                    Weight: {{ $product['product_weight'] }} Kg -
                                    Price: {{$product['product_price']}} EGP
                                </li>
                            @endforeach
                        </ol>
                    </td>
                </tr>

                <tr>
                    <th class="px-6 py-4 font-medium text-gray-900 dark:text-white">Status:</th>
                    <td class="px-6 py-6 flex justify-center items-center ">
                        <form method="POST" action="{{ route('orders.updateStatus', $order->id) }}">
                            @csrf
                            <select name="status" class="block mt-1 w-80 text-center border rounded dark:bg-[#18181b] border-[#10b981] dark:border-gray-700 text-white shadow-sm focus:ring-[#10b981] dark:focus:ring-[#10b981]" onchange="this.form.submit()">
                                <option value="processing" {{ $order->status == 'processing' ? 'selected' : '' }}>Processing</option>
                                <option value="on_shipping" {{ $order->status == 'on_shipping' ? 'selected' : '' }}>On Shipping</option>
                                <option value="shipped" {{ $order->status == 'shipped' ? 'selected' : '' }}>Shipped</option>
                            </select>
                        </form>
                    </td>
                </tr>
                </tbody>
            </table>

            <div class="flex justify-center mt-6">
                <a href="{{ route('orders.myOrders') }}" class="bg-[#10b981] hover:bg-emerald-700 text-white font-semibold py-2 px-6 rounded-md shadow-md transition duration-200">
                    Back to Orders
                </a>
            </div>
        </div>
    </div>
</x-app-layout>
