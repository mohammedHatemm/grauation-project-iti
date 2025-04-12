<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Pending Orders') }}
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
                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-600 dark:text-gray-300 uppercase">Total Weight</th>
                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-600 dark:text-gray-300 uppercase">Total Price</th>
                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-600 dark:text-gray-300 uppercase">Region Status</th>
                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-600 dark:text-gray-300 uppercase">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-[#202022] text-white">
                        @forelse($orders as $order)
                        <tr class="hover:bg-[#2d2d2f] dark:hover:bg-[#2d2d2f]">
                            <td class="px-6 py-4 text-sm font-medium text-gray-900 dark:text-gray-200">{{ $order->client_name }}</td>
                            <td class="px-6 py-4 text-sm text-gray-500 dark:text-gray-400">{{ optional($order->region)->name ?? 'Unknown' }}</td>
                            <td class="px-6 py-4 text-sm text-gray-500 dark:text-gray-400">{{ $order->total_weight }}</td>
                            <td class="px-6 py-4 text-sm text-gray-500 dark:text-gray-400">{{ $order->total_price }} EGP</td>
                            <td class="px-6 py-4 text-sm">
                                @if($order->region && $order->region->status == 'not_active')
                                <span class="px-2 py-1 text-xs font-semibold rounded-full bg-red-100 dark:bg-red-800 text-red-800 dark:text-red-100">Inactive</span>
                                @else
                                <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 dark:bg-green-800 text-green-800 dark:text-green-100">Active</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-sm space-x-2">
                                @if($order->region && $order->region->status == 'not_active')
                                <form action="{{ route('employee.activateRegion', $order->region->id) }}" method="POST" class="inline">
                                    @csrf
                                    <button type="button" class="inline-flex items-center px-3 py-1.5 border border-transparent text-xs font-medium rounded text-white bg-[#10b981] hover:bg-[#0e9e73] transition  duration-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500" onclick="showNotActiveAlert()">Assign</button>
                                </form>
                                @else
                                @if($order->region && $order->region->status == 'active')
                                <button class="inline-flex items-center px-3 py-1.5 border border-transparent text-xs font-medium rounded text-white bg-[#10b981] hover:bg-[#0e9e73] transition  duration-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 assign-btn" data-order-id="{{ $order->id }}">Assign</button>
                                @endif
                                @endif

                                <form action="{{ route('employee.rejectOrder', $order->id) }}" method="POST" class="inline">
                                    @csrf
                                    <button type="submit" class="inline-flex items-center px-3 py-1.5 border border-transparent text-xs font-medium rounded text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500" onclick="confirmReject(event)">Reject</button>
                                </form>

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

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        function confirmReject(event) {
            event.preventDefault();
            Swal.fire({
                title: 'Are you Sure?',
                text: "Do you want to reject this Order?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, Reject',
                cancelButtonText: 'No'
            }).then((result) => {
                if (result.isConfirmed) {
                    event.target.closest('form').submit();
                }
            });
        }

        function showNotActiveAlert() {
            Swal.fire({
                icon: 'warning',
                title: 'Region Not Active',
                text: 'This region is currently not active!',
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'OK'
            });
        }

        $(document).ready(function() {
            let selectedOrderId;

            // Open modal when assign button is clicked
            $('.assign-btn').click(function() {
                selectedOrderId = $(this).data('order-id');

                $.ajax({
                    url: `/employee/orders/${selectedOrderId}/delegates`,
                    method: 'GET',
                    success: function(response) {
                        console.log(response);
                        $('#assignModal').removeClass('hidden');
                        $('#delegates-body').empty();

                        response.forEach(function(delegate) {
                            $('#delegates-body').append(`
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${delegate.name}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${delegate.phone ?? "no phone added"}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        <button class="inline-flex items-center px-3 py-1.5 border border-transparent text-xs font-medium rounded text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 choose-delegate" data-delegate-id="${delegate.id}">
                                            Choose
                                        </button>
                                    </td>
                                </tr>
                            `);
                        });
                    },
                    error: function(xhr) {
                        console.error(xhr);
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'An error occurred while fetching delegate data',
                        });
                    }
                });
            });

            // Close modal when close button is clicked
            $('#closeModalBtn').click(function() {
                $('#assignModal').addClass('hidden');
            });

            // Close modal when clicking outside of it
            $('#assignModal').click(function(e) {
                if (e.target === this) {
                    $(this).addClass('hidden');
                }
            });

            // Handle delegate selection
            $(document).on('click', '.choose-delegate', function() {
                const delegateId = $(this).data('delegate-id');

                $.ajax({
                    url: `/employee/orders/${selectedOrderId}/assign-delegate/${delegateId}`,
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        $('#assignModal').addClass('hidden');

                        Swal.fire({
                            icon: 'success',
                            title: 'Assigned Successfully!',
                            text: 'The delivery has been assigned to this order',
                            confirmButtonText: 'OK'
                        });

                        // location.reload();
                    },
                    error: function(xhr) {
                        if (xhr.status === 400 && xhr.responseJSON.error) {
                            Swal.fire({
                                icon: 'warning',
                                title: '',
                                text: xhr.responseJSON.error,
                                confirmButtonText: 'OK'
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error!',
                                text: 'An error occurred while assigning the delivery',
                                confirmButtonText: 'OK'
                            });
                        }
                    }
                });
            });

            function showMessage(message, type) {
                const messageDiv = $('#statusMessage');
                messageDiv.removeClass('hidden bg-green-100 bg-red-100')
                    .addClass(`${type === 'success' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'}`)
                    .text(message)
                    .fadeIn()
                    .delay(3000)
                    .fadeOut(function() {
                        $(this).addClass('hidden');
                    });
            }
        });
    </script>
</x-app-layout>
