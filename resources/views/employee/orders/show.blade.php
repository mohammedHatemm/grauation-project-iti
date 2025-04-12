<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Order Details') }}
            </h2>
        </div>
    </x-slot>

    <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-8">
        {{-- Order Info --}}
        <div class="bg-white dark:bg-[#1f1f22] shadow-xl rounded-2xl mb-6 border border-gray-200 dark:border-gray-700/60 backdrop-blur-md">
            <div class="bg-gray-100 dark:bg-[#2a2a2e] p-4 rounded-t-2xl border-b border-gray-300 dark:border-gray-700/50">
                <h5 class="text-lg font-semibold text-gray-800 dark:text-white">Order Details</h5>
            </div>
            <div class="p-6">
                <table class="min-w-full">
                    <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                        <tr>
                            <th class="py-3 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase">Client Name</th>
                            <td class="py-3 text-sm font-medium text-gray-900 dark:text-gray-100">{{ $order->client_name }}</td>
                        </tr>
                        <tr>
                            <th class="py-3 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase">Client City</th>
                            <td class="py-3 text-sm text-gray-700 dark:text-gray-300">{{ $order->client_city }}</td>
                        </tr>
                        <tr>
                            <th class="py-3 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase">Total Weight</th>
                            <td class="py-3 text-sm text-gray-700 dark:text-gray-300">{{ $order->total_weight }} KG</td>
                        </tr>
                        <tr>
                            <th class="py-3 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase">Total Price</th>
                            <td class="py-3 text-sm text-gray-700 dark:text-gray-300">{{ $order->total_price }} EGP</td>
                        </tr>
                        <tr>
                            <th class="py-3 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase">Status</th>
                            <td class="py-3 text-sm">
                                @if($order->status == 'pending')
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-200 text-yellow-800 dark:bg-yellow-500/10 dark:text-yellow-300">Pending</span>
                                @elseif($order->status == 'processing')
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-200 text-blue-800 dark:bg-blue-400/10 dark:text-blue-300">Processing</span>
                                @elseif($order->status == 'on_shipping')
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-200 text-blue-800 dark:bg-blue-400/10 dark:text-blue-300">On Shipping</span>
                                @elseif($order->status == 'rejected')
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-800 text-red-100 dark:bg-red-800 dark:text-red-100">Rejected</span>
                                @elseif($order->status == 'shipped')
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-200 text-green-800 dark:bg-[#10b981]/10 dark:text-[#10b981]">Shipped</span>
                                @else
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-200 text-gray-800 dark:bg-gray-600/40 dark:text-gray-200">{{ ucfirst($order->status) }}</span>
                                @endif
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Delivery Info --}}
        @if($order->orderDelivery->isNotEmpty())
        <div class="bg-white dark:bg-[#1f1f22] shadow-xl rounded-2xl mb-6 border border-gray-200 dark:border-gray-700/60 backdrop-blur-md">
            <div class="bg-gray-100 dark:bg-[#2a2a2e] p-4 rounded-t-2xl border-b border-gray-300 dark:border-gray-700/50">
                <h5 class="text-lg font-semibold text-gray-800 dark:text-white">Delivery Info</h5>
            </div>
            <div class="p-6">
                <table class="min-w-full">
                    <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                        <tr>
                            <th class="py-3 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase">Delivery Man's Name</th>
                            <td class="py-3 text-sm text-gray-700 dark:text-gray-300" id="delegate-name">{{ $order->orderDelivery->first()->user->name ?? 'Not assigned yet' }}</td>
                        </tr>
                        <tr>
                            <th class="py-3 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase">Address</th>
                            <td class="py-3 text-sm text-gray-700 dark:text-gray-300" id="delegate-address">{{ $order->orderDelivery->first()->user->address ?? 'Unknown' }}</td>
                        </tr>
                        <tr>
                            <th class="py-3 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase">Phone</th>
                            <td class="py-3 text-sm text-gray-700 dark:text-gray-300" id="delegate-phone">{{ $order->orderDelivery->first()->user->phone ?? 'Not available' }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        @else
        <div class="bg-[#1f1f22] text-gray-200 p-4 rounded-xl mb-6 text-center border border-dashed border-[#10b981]/40 shadow-inner">
            No Delivery man has been assigned to this order yet.
        </div>
        @endif

        {{-- Actions --}}
        @php
        $backURL = session("previous_page") ?? route('employee.orders.pending');
        @endphp

        <div class="flex justify-between mt-4">
            <a href="{{ $backURL }}"
                class="bg-[#202022] hover:bg-[#2a2a2c] text-white border border-[#10b981] hover:text-white px-4 py-2 rounded-lg transition duration-200 shadow-sm">
                Back
            </a>

            @if($order->status == 'pending' && $order->orderDelivery->isNotEmpty())
            <form action="{{ route('employee.orders.confirm.processing', $order->id) }}" method="POST">
                @csrf
                <button type="submit"
                    class="bg-[#10b981] hover:bg-[#0e9e6f] text-white px-4 py-2 rounded-lg transition duration-200 shadow">
                    Confirm Order (Send it)
                </button>
            </form>
            @endif
        </div>
    </div>
</x-app-layout>