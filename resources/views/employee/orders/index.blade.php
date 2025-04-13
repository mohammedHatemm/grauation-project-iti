<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('All Orders') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div id="statusMessage" class="hidden mb-4 p-4 rounded"></div>

            <div class="overflow-x-auto bg-[#202022] text-gray-500 dark:text-white shadow-md rounded-lg">
                <table class="min-w-full text-center dark:bg-[#202022]">
                    <thead class="bg-[#202022] text-gray-500 dark:text-white">
                        <tr>
                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-600 dark:text-gray-300 uppercase">Client Name</th>
                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-600 dark:text-gray-300 uppercase">Region</th>
                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-600 dark:text-gray-300 uppercase">Assigned Delivery man</th>
                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-600 dark:text-gray-300 uppercase">Total Weight</th>
                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-600 dark:text-gray-300 uppercase">Total Price</th>
                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-600 dark:text-gray-300 uppercase">Order Date</th>
                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-600 dark:text-gray-300 uppercase">Region Status</th>
                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-600 dark:text-gray-300 uppercase">Order Status</th>
                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-600 dark:text-gray-300 uppercase">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-[#202022] text-white">
                        @forelse($orders as $order)
                        <tr class="hover:bg-[#2d2d2f] dark:hover:bg-[#2d2d2f]">
                            <td class="px-6 py-4 text-sm font-medium text-gray-900 dark:text-gray-200">{{ $order->client_name }}</td>
                            <td class="px-6 py-4 text-sm text-gray-500 dark:text-gray-400">{{ optional($order->region)->name ?? 'Unknown' }}</td>
                            <td class="px-6 py-4 text-sm text-gray-500 dark:text-gray-400">{{ $order->orderDelivery->first()->user->name ?? 'Not assigned' }}</td>
                            <td class="px-6 py-4 text-sm text-gray-500 dark:text-gray-400">{{ $order->total_weight }}</td>
                            <td class="px-6 py-4 text-sm text-gray-500 dark:text-gray-400">{{ $order->total_price }} EGP</td>
                            <td class="px-6 py-4 text-sm text-gray-500 dark:text-gray-400">{{ $order->created_at }}</td>
                            <td class="px-6 py-4 text-sm">
                                @if($order->region && $order->region->status == 'not_active')
                                <span class="px-2 py-1 text-xs font-semibold rounded-full bg-red-100 dark:bg-red-800 text-red-800 dark:text-red-100">Inactive</span>
                                @else
                                <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 dark:bg-green-800 text-green-800 dark:text-green-100">Active</span>
                                @endif
                            </td>
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
                            <td class="px-6 py-4 text-sm space-x-2">
                                <a href="{{ route('employee.orders.show', $order->id) }}" class="inline-flex items-center px-3 py-1.5 text-xs font-medium rounded text-white bg-transparent border border-[#10b981] hover:bg-[#10b981] transition  duration-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">Show</a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="px-6 py-4 text-center">No orders to navigate!</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
                <div class="my-5 mx-10">
                    {{$orders->links()}}
                </div>
            </div>
        </div>
    </div>

    <!-- Modal dialog - using a hidden element that becomes visible with JS -->
    <div id="assignModal" class="fixed inset-0 z-10 hidden overflow-y-auto" aria-labelledby="assignModalLabel" aria-modal="true">
        <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <!-- Background overlay -->
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>

            <!-- Center modal -->
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

            <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                <div class="bg-gray-800 px-4 py-3 sm:px-6 flex justify-between items-center">
                    <h5 class="text-lg font-medium text-white" id="assignModalLabel">Assign Delivery</h5>
                    <button type="button" class="text-white hover:text-gray-300" id="closeModalBtn">
                        <span class="sr-only">Close</span>
                        <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
                <div class="px-4 py-3 sm:px-6">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Phone</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Action</th>
                                </tr>
                            </thead>
                            <tbody id="delegates-body" class="bg-white divide-y divide-gray-200">
                                <!-- This will be filled by AJAX -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
