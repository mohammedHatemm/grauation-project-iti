<x-guest-layout>
    <form method="POST" action="{{ route('register') }}">
        @csrf
        <!-- Alpine.js for wizard steps -->
        <div x-data="{ step: 1 }">

            <!-- Step 1: Name, Email -->
            <div x-show="step === 1">
                <h2 class="text-2xl font-semibold text-center text-[#10b981] mb-4">Step 1: Personal Info</h2>

                <!-- Name -->
                <div>
                    <x-input-label for="name" :value="__('Name')" />
                    <input id="name" class="block mt-1 w-full border rounded bg-[#18181b] dark:bg-[#18181b] border-[#10b981] dark:border-gray-700 text-[#10b981] shadow-sm focus:ring-[#10b981] dark:focus:ring-[#10b981]" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                </div>

                <!-- Email Address -->
                <div class="mt-4">
                    <x-input-label for="email" :value="__('Email')" />
                    <input id="email" class="block mt-1 w-full border rounded dark:bg-[#18181b] border-[#10b981] dark:border-gray-700 text-[#10b981] shadow-sm focus:ring-[#10b981] dark:focus:ring-[#10b981]" type="email" name="email" :value="old('email')" required autocomplete="username" />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <!-- Gender -->
                <div class="mt-4">
                    <x-input-label for="gender" :value="__('Gender')" />
                    <select name="gender" id="gender" class="block mt-1 w-full border rounded dark:bg-[#18181b] border-[#10b981] dark:border-gray-700 text-[#10b981] shadow-sm focus:ring-[#10b981] dark:focus:ring-[#10b981]">
                        <option value="" disabled selected>Select your gender</option>
                        <option value="male">Male</option>
                        <option value="female">Female</option>
                    </select>
                    <x-input-error :messages="$errors->get('gender')" class="mt-2" />
                </div>

                <div class="flex justify-end mt-4">
                    <button type="button" @click="step = 2" class="px-4 py-2 bg-[#10b981] text-white rounded-lg hover:bg-[#0e9e74] transition">
                        Next
                    </button>
                </div>
            </div>

            <!-- Step 2: Company Info -->
            <div x-show="step === 2">
                <h2 class="text-2xl font-semibold text-center text-[#10b981] mb-4">Step 2: Company Info</h2>

                <!-- Company Name -->
                <div>
                    <x-input-label for="company_name" :value="__('Company Name')" />
                    <input id="company_name" class="block mt-1 w-full border rounded dark:bg-[#18181b] border-[#10b981] dark:border-gray-700 text-[#10b981] shadow-sm focus:ring-[#10b981] dark:focus:ring-[#10b981]" type="text" name="company_name" :value="old('company_name')" required autofocus autocomplete="company_name" />
                    <x-input-error :messages="$errors->get('company_name')" class="mt-2" />
                </div>

                <!-- Phone -->
                <div class="mt-4">
                    <x-input-label for="phone" :value="__('Phone')" />
                    <input id="phone" class="block mt-1 w-full border rounded dark:bg-[#18181b] border-[#10b981] dark:border-gray-700 text-[#10b981] shadow-sm focus:ring-[#10b981] dark:focus:ring-[#10b981]" type="text" name="phone" :value="old('phone')" required autofocus autocomplete="phone" />
                    <x-input-error :messages="$errors->get('phone')" class="mt-2" />
                </div>

                <!-- Address -->
                <div class="mt-4">
                    <x-input-label for="address" :value="__('Address')" />
                    <input id="address" class="block mt-1 w-full border rounded dark:bg-[#18181b] border-[#10b981] dark:border-gray-700 text-[#10b981] shadow-sm focus:ring-[#10b981] dark:focus:ring-[#10b981]" type="text" name="address" :value="old('address')" required autofocus autocomplete="address" />
                    <x-input-error :messages="$errors->get('address')" class="mt-2" />
                </div>

                <div class="flex justify-between mt-4">
                    <button type="button" @click="step = 1" class="px-4 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600 transition">
                        Back
                    </button>
                    <button type="button" @click="step = 3" class="px-4 py-2 bg-[#10b981] text-white rounded-lg hover:bg-[#0e9e74] transition">
                        Next
                    </button>

                </div>
            </div>

            <!-- Step 3: Gender, Password -->
            <div x-show="step === 3">
                <h2 class="text-2xl font-semibold text-center text-[#10b981] mb-4">Step 3: Account Setup</h2>

                <!-- Password -->
                <div class="mt-4">
                    <x-input-label for="password" :value="__('Password')" />
                    <input id="password" class="block mt-1 w-full border rounded dark:bg-[#18181b] border-[#10b981] dark:border-gray-700 text-[#10b981] shadow-sm focus:ring-[#10b981] dark:focus:ring-[#10b981]" type="password" name="password" required autocomplete="new-password" />
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <!-- Confirm Password -->
                <div class="mt-4">
                    <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
                    <input id="password_confirmation" class="block mt-1 w-full border rounded dark:bg-[#18181b] border-[#10b981] dark:border-gray-700 text-[#10b981] shadow-sm focus:ring-[#10b981] dark:focus:ring-[#10b981]" type="password" name="password_confirmation" required autocomplete="new-password" />
                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                </div>

                <div class="flex justify-between mt-4">
                    <button type="button" @click="step = 2" class="px-4 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600 transition">
                        Back
                    </button>
                    <x-primary-button class="ms-4">
                        {{ __('Register') }}
                    </x-primary-button>
                </div>
            </div>
        </div>
    </form>
</x-guest-layout>
