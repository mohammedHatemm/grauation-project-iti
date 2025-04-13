<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('My Orders') }}
            </h2>
        </div>
    </x-slot>

    <div class="m-10">
        <div class="relative overflow-x-auto shadow-md sm:rounded-lg bg-[#202022] text-white">
            <table class="w-full text-sm text-left rtl:text-right dark:bg-[#202022] text-gray-500 dark:text-gray-400">
                <thead class="bg-[#202022] text-gray-500 dark:text-white">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-center">
                            Client Name
                        </th>
                        <th scope="col" class="px-6 py-3 text-center">
                            Phone Number
                        </th>
                        <th scope="col" class="px-6 py-3 text-center">
                            City
                        </th>
                        <th scope="col" class="px-6 py-3 text-center">
                            Shipping Type
                        </th>
                        <th scope="col" class="px-6 py-3 text-center">
                            Payment Method
                        </th>
                        <th scope="col" class="px-6 py-3 text-center">
                            Status
                        </th>
                        <th scope="col" class="px-6 py-3 text-center">
                            Total Weight
                        </th>
                        <th scope="col" class="px-6 py-3 text-center">
                            Total Price
                        </th>
                        <th scope="col" class="px-6 py-3 text-center">
                            Action
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-[#202022] text-white">
                    @forelse($orders as $order)
                    <tr class="hover:bg-[#2d2d2f] dark:hover:bg-[#2d2d2f]">
                        <th scope="row" class="px-6 py-4 flex justify-center font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            {{ $order->client_name }}
                        </th>
                        <td class="px-6 py-4 text-center">
                            {{ $order->client_phone }}
                        </td>
                        <td class="px-6 py-4 text-center">
                            {{ $order->client_city }}
                        </td>
                        <td class="px-6 py-4 flex justify-center">
                            <span class="px-2 py-1 w-24 text-center text-white text-sm font-semibold rounded
                                {{ $order->shipping_type == 'normal' ? 'bg-[#10b981]' : 'bg-red-500' }}">
                                {{ $order->shipping_type == 'normal' ? 'Normal' : 'Express (24 Hours)' }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-center">
                            {{ ucfirst(str_replace('_', ' ', $order->payment_type)) }}
                        </td>
                        <td class="px-6 py-4 text-center">
                            <span>
                                {{ ucfirst(str_replace('_', ' ', $order->status)) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-center">
                            {{ $order->total_weight }} Kg
                        </td>
                        <td class="px-6 py-4 text-center">
                            {{ $order->total_price }} EGP
                        </td>
                        <td>
                            <a href="{{ route('orders.view', $order->id) }}" class="px-3 py-1.5 text-xs font-medium rounded text-white bg-transparent border border-[#10b981] hover:bg-[#10b981] transition  duration-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">View Details</a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="9" class="px-6 py-4 text-center">No Orders recorded for you yet</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
            <div>
                {{$orders->links()}}
            </div>
        </div>

    </div>
</x-app-layout>
