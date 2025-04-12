<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Your Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-[#18181b] dark:bg-gray-700 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-white bg-[#202022]">
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                        <!-- Waiting -->
                        <div class="bg-white/10 backdrop-blur-xl rounded-2xl shadow-lg  p-6 flex flex-col items-center justify-center text-center">
                            <div class="p-2 bg-amber-100 rounded-full">
                                <svg class="w-8 h-8 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                                </svg>
                            </div>
                            <h3 class="text-lg font-semibold text-white">Waiting</h3>
                            <p class="text-2xl font-bold text-[#10b981]">{{ $statistics['Waiting'] }}</p>
                        </div>

                        <!-- Delivered -->
                        <div class="bg-white/10 backdrop-blur-xl rounded-2xl shadow-lg  p-6 flex flex-col items-center justify-center text-center">
                            <div class="p-2 bg-green-100 rounded-full">
                                <svg class="w-8 h-8 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                            </div>
                            <h3 class="text-lg font-semibold text-white">Delivered</h3>
                            <p class="text-2xl font-bold text-[#10b981]">{{ $statistics['delivered'] }}</p>
                        </div>

                        <!-- On its way -->
                        <div class="bg-white/10 backdrop-blur-xl rounded-2xl shadow-lg  p-6 flex flex-col items-center justify-center text-center">
                            <div class="p-2 bg-purple-100 rounded-full">
                                <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8h2a2 2 0 012 2v6a2 2 0 01-2 2h-2v4l-4-4H9a1.994 1.994 0 01-1.414-.586m0 0L11 14h4a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2v4l.586-.586z"></path>
                                </svg>
                            </div>
                            <h3 class="text-lg font-semibold text-white">On its way</h3>
                            <p class="text-2xl font-bold text-[#10b981]">{{ $statistics['On_its_way'] }}</p>
                        </div>

                        <!-- Accepted and Waiting -->
                        <div class="bg-white/10 backdrop-blur-xl rounded-2xl shadow-lg  p-6 flex flex-col items-center justify-center text-center">
                            <div class="p-2 bg-blue-100 rounded-full">
                                <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <h3 class="text-lg font-semibold text-white">Accepted and Waiting</h3>
                            <p class="text-2xl font-bold text-[#10b981]">{{ $statistics['Accepted_and_waiting'] }}</p>
                        </div>

                        <!-- Rejected (Centered) -->
                        <div class="bg-white/10 backdrop-blur-xl rounded-2xl shadow-lg  p-6 flex flex-col items-center justify-center text-center col-span-2 col-start-2">
                            <div class="p-2 bg-red-100 rounded-full">
                                <svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                            </div>
                            <h3 class="text-lg font-semibold text-white">Rejected</h3>
                            <p class="text-2xl font-bold text-red-600">{{ $statistics['Rejected'] }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
