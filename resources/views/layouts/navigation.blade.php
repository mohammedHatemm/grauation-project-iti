@php use Illuminate\Support\Facades\Auth; @endphp
<nav x-data="{ open: false }" class="bg-white dark:bg-[#18181b] border-b border-gray-100 dark:border-gray-700">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 dark:bg-[#18181b]">
        <div class="flex justify-between h-16 dark:bg-[#18181b]">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    @if(Auth::user()->role === 'merchant')
                    <a href="{{ route('conclusion') }}">
                        @endif
                        @if(Auth::user()->role === 'employee')
                        <a href="{{ route('employee.orders.empdash') }}">
                            @endif
                            @if(Auth::user()->role === 'delivery_man')
                            <a href="{{ route('orders.delidash') }}">
                                @endif
                                <img src="{{ asset('images/logo.png') }}" alt="Saree3 Logo" class="mx-auto w-auto h-11">
                            </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    {{--Merchant Nav--}}
                    @if(Auth::user()->role === 'merchant')
                    <x-nav-link :href="route('conclusion')" :active="request()->routeIs('conclusion')" class="text-gray-200">
                        {{ __('Dashboard') }}
                    </x-nav-link>
                    <x-nav-link :href="route('orders.report')" :active="request()->routeIs('orders.report')" class="text-gray-200">
                        {{ __('Orders') }}
                    </x-nav-link>
                    @endif

                    {{--EMP NAV--}}
                    @if(Auth::user()->role === 'employee')
                    <x-nav-link :href="route('employee.orders.empdash')" :active="request()->routeIs('employee.orders.empdash')" class="text-gray-200">
                        {{ __('Dashboard') }}
                    </x-nav-link>
                    <x-nav-link :href="route('employee.orders.pending')" :active="request()->routeIs('employee.orders.pending')" class="text-gray-200 hover:text-[#10b981]">
                        {{ __('Pending orders') }}
                    </x-nav-link>
                    <x-nav-link :href="route('employee.orders.index')" :active="request()->routeIs('employee.orders.index')" class="text-gray-200 hover:text-[#10b981]">
                        {{ __('All orders') }}
                    </x-nav-link>
                    @endif

                    {{--DELI NAV--}}
                    @if(Auth::user()->role === 'delivery_man')
                    <x-nav-link :href="route('orders.delidash')" :active="request()->routeIs('orders.delidash')" class="text-gray-200">
                        {{ __('Dashboard') }}
                    </x-nav-link>
                    <x-nav-link :href="route('orders.myOrders')" :active="request()->routeIs('orders.myOrders')" class="text-gray-200 hover:text-[#10b981]">
                        {{ __('Your Orders') }}
                    </x-nav-link>
                    @endif
                </div>

            </div>

            <!-- Notifications -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <div x-data="{ open: false }" @click.away="open = false" class="relative">
                    @livewire('notification-list')
                </div>
            </div>

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 dark:text-gray-400 bg-white dark:bg-[#18181b] hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none transition ease-in-out duration-150">
                            <div>{{ Auth::user()->name }}</div>

                            <div class="ms-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content" class="bg-[#18181b] dark:bg-[#18181b] text-white rounded-md shadow-none border-none">
                        <div class="bg-[#18181b] dark:bg-[#18181b] text-white rounded-md shadow-none border-none">
                            <x-dropdown-link :href="route('profile.edit')" class="hover:bg-[#202022] dark:hover:bg-[#202022]">
                                {{ __('Profile') }}
                            </x-dropdown-link>

                            <!-- Authentication -->
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf

                                <x-dropdown-link :href="route('logout')" class="hover:bg-[#202022] dark:hover:bg-[#202022]"
                                    onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                    {{ __('Log Out') }}
                                </x-dropdown-link>
                            </form>
                        </div>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 dark:text-gray-500 hover:text-gray-500 dark:hover:text-gray-400 hover:bg-gray-100 dark:hover:bg-[#18181b] focus:outline-none focus:bg-gray-100 dark:focus:bg-[#18181b] focus:text-gray-500 dark:focus:text-gray-400 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            @if(Auth::user()->role === 'merchant')
            <x-responsive-nav-link :href="route('conclusion')" :active="request()->routeIs('conclusion')" class="text-gray-200 hover:text-[#10b981]">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('orders.report')" :active="request()->routeIs('orders.report')" class="text-gray-200 hover:text-[#10b981]">
                {{ __('Orders') }}
            </x-responsive-nav-link>
            @endif

            {{--EMP NAV--}}
            @if(Auth::user()->role === 'employee')
            <x-responsive-nav-link :href="route('employee.orders.empdash')" :active="request()->routeIs('employee.orders.empdash')" class="text-gray-200 hover:text-[#10b981]">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('employee.orders.pending')" :active="request()->routeIs('employee.orders.pending')" class="text-gray-200 hover:text-[#10b981]">
                {{ __('Pending orders') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('employee.orders.index')" :active="request()->routeIs('employee.orders.index')" class="text-gray-200 hover:text-[#10b981]">
                {{ __('All orders') }}
            </x-responsive-nav-link>
            @endif

            {{--DELI NAV--}}
            @if(Auth::user()->role === 'delivery_man')
            <x-responsive-nav-link :href="route('orders.delidash')" :active="request()->routeIs('orders.delidash')" class="text-gray-200 hover:text-[#10b981]">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('orders.myOrders')" :active="request()->routeIs('orders.myOrders')" class="text-gray-200 hover:text-[#10b981]">
                {{ __('Your Orders') }}
            </x-responsive-nav-link>
            @endif
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200 dark:border-gray-600">
            <div class="px-4">
                <div class="font-medium text-base text-gray-800 dark:text-gray-200">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">
                    {{ __('Profile') }}
                </x-responsive-nav-link>

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-responsive-nav-link :href="route('logout')"
                        onclick="event.preventDefault();
                                        this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>













<!-- <nav x-data="{ open: false }" class="bg-white dark:bg-gray-800 border-b border-gray-100 dark:border-gray-700">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}">
                        <x-application-logo class="block h-9 w-auto fill-current text-gray-800 dark:text-gray-200" />
                    </a>
                </div>

                <div class="hidden space-x-8 space-x-reverse sm:-my-px sm:mr-10 sm:flex">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                        {{ __('Home') }}
                    </x-nav-link>
                    <x-nav-link :href="route('orders.index')" :active="request()->routeIs('orders.index')">
                        {{ __('Orders') }}
                    </x-nav-link>
                    <x-nav-link :href="route('orders.report')" :active="request()->routeIs('orders.report')">
                        {{ __('Reports') }}
                    </x-nav-link>
                </div>
            </div>

        </div>
    </div>
</nav> -->
