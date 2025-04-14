<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Edit your order') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-[#202022] dark:bg-[#202022] overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-white">
                    <form action="{{ route('orders.update', $order) }}" method="POST" class="space-y-6">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <x-input-label for="client_name" value="Client Name" />
                                <input id="client_name"
                                    name="client_name" type="text" class="block mt-1 w-full border rounded dark:bg-[#18181b] border-[#10b981] dark:border-gray-700 text-white shadow-sm focus:ring-[#10b981] dark:focus:ring-[#10b981]"
                                    value="{{ old('client_name', $order->client_name) }}" required />
                                <x-input-error :messages="$errors->get('client_name')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="client_phone" value="Phone number" />
                                <input id="client_phone"
                                    name="client_phone" type="text" class="block mt-1 w-full border rounded dark:bg-[#18181b] border-[#10b981] dark:border-gray-700 text-white shadow-sm focus:ring-[#10b981] dark:focus:ring-[#10b981]"
                                    value="{{ old('client_phone', $order->client_phone) }}" required />
                                <x-input-error :messages="$errors->get('client_phone')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="client_city" value="City" />
                                <input id="client_city"
                                    name="client_city" type="text" class="block mt-1 w-full border rounded dark:bg-[#18181b] border-[#10b981] dark:border-gray-700 text-white shadow-sm focus:ring-[#10b981] dark:focus:ring-[#10b981]"
                                    value="{{ old('client_city', $order->client_city) }}" required />
                                <x-input-error :messages="$errors->get('client_city')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="region_id" value="Region" />
                                <select id="region_id" name="region_id"
                                    class="block mt-1 w-full border rounded dark:bg-[#18181b] border-[#10b981] dark:border-gray-700 text-white shadow-sm focus:ring-[#10b981] dark:focus:ring-[#10b981]" required>
                                    @foreach ($regions as $region)
                                    <option value="{{ $region->id }}"
                                        {{ $order->region_id == $region->id ? 'selected' : '' }}>
                                        {{ $region->name }}
                                    </option>
                                    @endforeach
                                </select>
                                <x-input-error :messages="$errors->get('region_id')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="shipping_type" value="Shipping type" />
                                <select id="shipping_type"
                                    name="shipping_type" class="block mt-1 w-full border rounded dark:bg-[#18181b] border-[#10b981] dark:border-gray-700 text-white shadow-sm focus:ring-[#10b981] dark:focus:ring-[#10b981]"
                                    required>
                                    @foreach ($shippingTypes as $key => $value)
                                    <option value="{{ $key }}"
                                        {{ $order->shipping_type === $key ? 'selected' : '' }}>
                                        {{ $value }}
                                    </option>
                                    @endforeach
                                </select>
                                <x-input-error :messages="$errors->get('shipping_type')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="payment_type" value="Payment type" />
                                <select id="payment_type"
                                    name="payment_type" class="block mt-1 w-full border rounded dark:bg-[#18181b] border-[#10b981] dark:border-gray-700 text-white shadow-sm focus:ring-[#10b981] dark:focus:ring-[#10b981]"
                                    required>
                                    @foreach ($paymentTypes as $key => $value)
                                    <option value="{{ $key }}"
                                        {{ $order->payment_type === $key ? 'selected' : '' }}>
                                        {{ $value }}
                                    </option>
                                    @endforeach
                                </select>
                                <x-input-error :messages="$errors->get('payment_type')" class="mt-2" />
                            </div>
                        </div>
                        <div class="flex">
                            <div class="flex items-center h-5">
                                <input id="village-checkbox" type="checkbox" value="1" name="village"
                                    class="w-4 h-4 text-[#10b981] bg-gray-100 border-gray-300 rounded-sm focus:ring-[#10b981] dark:focus:ring-[#10b981] dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600"
                                    {{ old('village', $order->village) ? 'checked' : '' }}>
                            </div>
                            <div class="ms-2 text-sm">
                                <label for="village-checkbox" class="font-medium text-gray-900 dark:text-gray-300">Village</label>
                                <p class="text-xs font-normal text-gray-500 dark:text-gray-300">Is this order for a
                                    village?</p>
                            </div>
                        </div>
                        <div class="mt-6">
                            <h3 class="text-lg font-medium mb-4">Products</h3>
                            <div class="flex justify-end mt-6">
                                <button type="button" id="add-product"
                                    class="bg-[#10b981] hover:bg-[#0f9c7a] text-white px-4 py-2 rounded mb-5">+ Add Product
                                </button>
                            </div>
                            <div id="products-container">
                                @foreach ($order->products as $index => $product)

                                <div class=" p-4 rounded mb-4">
                                    <div class="grid grid-cols-1 md:grid-cols-5 gap-4">
                                        <div>
                                            <x-input-label value="Product Name" />
                                            <input name="products[{{ $index }}][product_name]"
                                                type="text" class="block mt-1 w-full border rounded dark:bg-[#18181b] border-[#10b981] dark:border-gray-700 text-white shadow-sm focus:ring-[#10b981] dark:focus:ring-[#10b981]"
                                                value="{{ $product['product_name'] }}" required />
                                        </div>
                                        <div>
                                            <x-input-label value="Quantity" />
                                            <input name="products[{{ $index }}][product_quantity]"
                                                oninput="this.value = Math.abs(this.value)" step="1"
                                                type="number" min="1" class="block mt-1 w-full border rounded dark:bg-[#18181b] border-[#10b981] dark:border-gray-700 text-white shadow-sm focus:ring-[#10b981] dark:focus:ring-[#10b981]"
                                                value="{{ $product['product_quantity'] }}" required />
                                        </div>
                                        <div>
                                            <x-input-label value="Weight (kg)" />
                                            <input name="products[{{ $index }}][product_weight]"
                                                oninput="this.value = Math.abs(this.value)"
                                                type="number" step="0.01" min="0.1"
                                                class="block mt-1 w-full border rounded dark:bg-[#18181b] border-[#10b981] dark:border-gray-700 text-white shadow-sm focus:ring-[#10b981] dark:focus:ring-[#10b981]"
                                                value="{{ $product['product_weight'] }}"
                                                required />
                                        </div>
                                        <div>
                                            <x-input-label value="Price (EGP)" />
                                            <input name="products[{{ $index }}][product_price]"
                                                oninput="this.value = Math.abs(this.value)"
                                                type="number" step="0.01" min="0"
                                                class="block mt-1 w-full border rounded dark:bg-[#18181b] border-[#10b981] dark:border-gray-700 text-white shadow-sm focus:ring-[#10b981] dark:focus:ring-[#10b981]"
                                                value="{{ $product['product_price'] }}"
                                                required />
                                        </div>

                                        <div class="flex justify-center items-center "
                                            style="display: {{ count($order->products) > 1 ? 'flex' : 'none' }};">

                                            <button type="button"
                                                class="remove-product bg-red-500 text-white p-2 rounded-full flex items-center justify-center w-10 h-10 ">
                                                <span class="heroicons--trash"></span> </button>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <x-input-label for="order_price" value="order price" />
                                <input id="order_price" name="order_price" type="number" step="0.01"
                                    class="block mt-1 w-full border rounded dark:bg-[#18181b] border-[#10b981] dark:border-gray-700 text-[#10b981] shadow-sm focus:ring-[#10b981] dark:focus:ring-[#10b981]"
                                    value="{{ old('order_price', $order->order_price) }}"
                                    disabled />
                            </div>
                            <div>
                                <x-input-label for="shipping_price" value="shipping price" />
                                <input id="shipping_price" name="shipping_price" type="number"
                                    step="0.01" class="block mt-1 w-full border rounded dark:bg-[#18181b] border-[#10b981] dark:border-gray-700 text-[#10b981] shadow-sm focus:ring-[#10b981] dark:focus:ring-[#10b981]"
                                    value="{{ old('shipping_price', $order->shipping_price) }}" disabled />
                            </div>
                            <div>
                                <x-input-label for="total_weight" value="Total Weight" />
                                <input id="total_weight" name="total_weight" type="number" step="0.01"
                                    class="block mt-1 w-full border rounded dark:bg-[#18181b] border-[#10b981] dark:border-gray-700 text-[#10b981] shadow-sm focus:ring-[#10b981] dark:focus:ring-[#10b981]"
                                    value="{{ old('total_weight', $order->total_weight) }}"
                                    disabled />
                            </div>
                            <div>
                                <x-input-label for="total_price" value="Total price" />
                                <input id="total_price" name="total_price" type="number" min="0"
                                    step="0.01" class="block mt-1 w-full border rounded dark:bg-[#18181b] border-[#10b981] dark:border-gray-700 text-[#10b981] shadow-sm focus:ring-[#10b981] dark:focus:ring-[#10b981]"
                                    value="{{ old('total_price', $order->total_price) }}" disabled />
                            </div>
                        </div>

                        <div class="flex justify-end mt-6">
                            <x-primary-button>Finish Editing</x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @push('script')
    <script>
        const shippingRates = @json($shippingRatesData) || {
            base_shipping_price: 0,
            weight_limit: 0,
            extra_weight_price_per_kg: 0,
            village_fee: 0,
            express_shipping_fee: 0
        };

        document.addEventListener("DOMContentLoaded", function() {
            let productCount = 1;

            function updateDeleteButtons() {
                const productRows = document.querySelectorAll('#products-container > div.p-4');
                const removeButtons = document.querySelectorAll('.remove-product');

                removeButtons.forEach(button => {
                    button.closest('div').style.display = productRows.length <= 1 ? 'none' : 'flex';
                });
            }

            // Add new product
            document.getElementById('add-product').addEventListener('click', function() {
                const container = document.getElementById('products-container');
                const newRow = document.createElement('div');
                newRow.className = 'p-4 rounded mb-4';

                newRow.innerHTML = `
                    <div class="grid grid-cols-1 md:grid-cols-5 gap-4">
                        <div>
                            <x-input-label value="Product Name"/>
                            <input name="products[${productCount}][product_name]" type="text" class="block mt-1 w-full border rounded dark:bg-[#18181b] border-[#10b981] dark:border-gray-700 text-white shadow-sm focus:ring-[#10b981] dark:focus:ring-[#10b981]" required/>
                        </div>
                        <div>
                            <x-input-label value="Quantity"/>
                            <input name="products[${productCount}][product_quantity]" type="number" step="1" min="1" value="0" class="block mt-1 w-full border rounded dark:bg-[#18181b] border-[#10b981] dark:border-gray-700 text-white shadow-sm focus:ring-[#10b981] dark:focus:ring-[#10b981]" required oninput="this.value = Math.abs(this.value)"/>
                        </div>
                        <div>
                            <x-input-label value="Weight (kg)"/>
                            <input name="products[${productCount}][product_weight]" type="number" step="0.01" min="0.1" value="0" class="block mt-1 w-full border rounded dark:bg-[#18181b] border-[#10b981] dark:border-gray-700 text-white shadow-sm focus:ring-[#10b981] dark:focus:ring-[#10b981]" required oninput="this.value = Math.abs(this.value)"/>
                        </div>
                        <div>
                            <x-input-label value="Price (EGP)"/>
                            <input name="products[${productCount}][product_price]" type="number" step="0.01" min="0" value="0" class="block mt-1 w-full border rounded dark:bg-[#18181b] border-[#10b981] dark:border-gray-700 text-white shadow-sm focus:ring-[#10b981] dark:focus:ring-[#10b981]" required oninput="this.value = Math.abs(this.value)"/>
                        </div>
                        <div class="flex justify-center items-center">
                            <button type="button" class="remove-product bg-red-500 text-white p-2 rounded-full flex items-center justify-center w-10 h-10">
                                <span class="heroicons--trash"></span>
                            </button>
                        </div>
                    </div>
                `;

                container.appendChild(newRow);
                productCount++;
                // updateCalculations();
                // updateDeleteButtons();
            });

            // Remove product button handler
            document.getElementById('products-container').addEventListener('click', function(e) {
                const removeBtn = e.target.closest('.remove-product');
                if (removeBtn) {
                    const row = removeBtn.closest('.p-4');
                    if (row && document.querySelectorAll('#products-container > div.p-4').length > 1) {
                        row.remove();
                        updateCalculations();
                        updateDeleteButtons();
                    }
                }
            });

            function updateCalculations() {
                const productPrices = document.querySelectorAll('input[name^="products"][name$="[product_price]"]');
                const productQuantities = document.querySelectorAll('input[name^="products"][name$="[product_quantity]"]');
                const productWeights = document.querySelectorAll('input[name^="products"][name$="[product_weight]"]');
                const villageCheckbox = document.querySelector('input[name="village"]');
                const shippingType = document.querySelector('select[name="shipping_type"]').value;

                let totalOrderPrice = 0;
                let totalWeight = 0;

                productPrices.forEach((priceInput, index) => {
                    const price = parseFloat(priceInput.value) || 0;
                    const quantity = parseInt(productQuantities[index].value) || 1;
                    const weight = parseFloat(productWeights[index].value) || 0;

                    totalOrderPrice += price * quantity;
                    totalWeight += weight * quantity;
                });

                let shippingPrice = shippingRates.base_shipping_price || 0;

                if (totalWeight > shippingRates.weight_limit) {
                    const extraWeight = totalWeight - shippingRates.weight_limit;
                    shippingPrice += extraWeight * shippingRates.extra_weight_price_per_kg;
                }

                if (villageCheckbox && villageCheckbox.checked) {
                    shippingPrice += shippingRates.village_fee || 0;
                }

                if (shippingType === "shipping_in_24_hours") {
                    shippingPrice += shippingRates.express_shipping_fee || 0;
                }

                document.getElementById('order_price').value = totalOrderPrice.toFixed(2);
                document.getElementById('shipping_price').value = shippingPrice.toFixed(2);
                document.getElementById('total_weight').value = totalWeight.toFixed(2);
                document.getElementById('total_price').value = (totalOrderPrice + shippingPrice).toFixed(2);
            }

            // Handle input changes for all relevant fields
            document.addEventListener('input', function(e) {
                if (e.target.name && (
                    e.target.name.includes('[product_price]') ||
                    e.target.name.includes('[product_quantity]') ||
                    e.target.name.includes('[product_weight]') ||
                    e.target.name === 'village' ||
                    e.target.name === 'shipping_type'
                )) {
                    updateCalculations();
                }
            });

            // Initial setup
            // updateCalculations();
            // updateDeleteButtons();
        });
    </script>
    @endpush
</x-app-layout>
