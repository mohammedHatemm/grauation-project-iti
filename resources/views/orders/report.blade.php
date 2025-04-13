<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Orders Report') }} </h2>
    </x-slot>

    <div class="flex justify-center mt-10">
        <a href="{{ route('orders.create') }}"
           class="bg-[#10b981] hover:bg-[#059669] text-white py-2 px-4 rounded">
            Add a new request
        </a>
    </div>

    <div class="py-12">
        @if(session('success'))
            <div class="container m-auto">
                <div id="alert-border-3"
                     class="flex items-center p-4 mb-4 text-green-800 border-t-4 border-green-300 bg-green-50 dark:text-green-400 dark:bg-gray-800 dark:border-green-800 rounded"
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

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-[#18181b] dark:bg-[#18181b] overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-white bg-[#202022]">
                    <form action="{{ route('orders.report') }}" method="GET"
                          class="mb-6 grid grid-cols-1 md:grid-cols-4 gap-4">
                                <div>
                                    <x-input-label for="from_date" value="From date" class="text-xl"/>
                                    <input id="from_date" name="from_date" type="date"
                                           class="mt-1 block w-60 border-[#10b981] dark:bg-[#18181b] dark:text-white dark:border-[#10b981] dark:focus:ring-[#10b981] dark:focus:border-[#10b981] rounded"/>
                                </div>

                                <div>
                                    <x-input-label for="to_date" value="To date" class="text-xl"/>
                                    <input id="to_date" name="to_date" type="date"
                                           class="mt-1 block w-60 border-[#10b981] dark:bg-[#18181b] dark:text-white dark:border-[#10b981] dark:focus:ring-[#10b981] dark:focus:border-[#10b981] rounded"/>
                                </div>

                                <div>
                                    <x-input-label for="status" value="Status" class="text-xl"/>
                                    <select id="status" name="status"
                                            class="mt-1 block w-60 rounded-md border-[#10b981] dark:bg-[#18181b] dark:text-white dark:border-[#10b981]">
                                        <option value="">All cases</option>
                                        @foreach(App\Models\Order::STATUS as $key => $value)
                                            <option
                                                value="{{ $key }}" {{ request('status') == $key ? 'selected' : '' }}>
                                                {{ $value }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            <div class="flex items-center mt-8 justify-end">
                                <x-primary-button class="bg-[#10b981] hover:bg-[#0f9c7a] py-3 w-40">Search</x-primary-button>
                            </div>
                    </form>
                    <div class="overflow-x-auto">
                        <table class="min-w-full text-center dark:bg-[#18181b]">
                            <thead class="bg-[#18181b] text-gray-500 dark:text-white">
                            <tr>
                                <th class="px-6 py-3 font-semibold text-sm ">Date</th>
                                <th class="px-6 py-3 text-center font-semibold text-sm ">Client Name</th>
                                <th class="px-6 py-3 text-center font-semibold text-sm ">Area</th>
                                <th class="px-6 py-3 text-center font-semibold text-sm ">Total price</th>
                                <th class="px-6 py-3 text-center font-semibold text-sm ">The Condition</th>
                                <th class="px-6 py-3 text-center font-semibold text-sm ">Actions</th>
                            </tr>
                            </thead>
                            <tbody class="bg-[#18181b] text-white">
                            @forelse($orders as $order)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $order->created_at->format('Y-m-d') }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $order->client_name }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $order->region->name }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $order->total_price }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                        {{ $order->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                        {{ $order->status === 'processing' ? 'bg-blue-100 text-blue-800' : '' }}
                                        {{ $order->status === 'on_shipping' ? 'bg-blue-100 text-blue-800' : '' }}
                                        {{ $order->status === 'shipped' ? 'bg-green-100 text-green-800' : '' }}
                                        {{ $order->status === 'rejected' ? 'bg-red-100 text-red-800' : '' }}">
                                        {{ App\Models\Order::STATUS[$order->status] }}
                                    </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex justify-center gap-2">
                                            <a href="{{ route('orders.show', $order) }}"
                                               class="bg-[#10b981] hover:bg-[#0f9c7a] text-white py-1 px-3 rounded text-sm">
                                                View
                                            </a>

                                            @if(in_array($order->status, ['pending']))
                                                <a href="{{ route('orders.edit', $order) }}"
                                                   class="bg-[#10b981] hover:bg-[#0f9c7a] text-white py-1 px-3 rounded text-sm">
                                                    Edit
                                                </a>

                                                <form action="{{ route('orders.destroy', $order) }}" method="POST"
                                                      class="inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="button"
                                                            class="bg-[#10b981] hover:bg-[#0f9c7a] text-white py-1 px-3 rounded text-sm"
                                                            id="delete-button">
                                                        Delete
                                                    </button>
                                                </form>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-4 text-center">No requests</td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-5">
                        {{$orders->links()}}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.querySelectorAll('#delete-button').forEach(button => {
            button.addEventListener('click', function (event) {
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
                        this.closest('form').submit();
                    }
                });
            });
        });
    </script>
</x-app-layout>
