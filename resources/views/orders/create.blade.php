<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Add New Order') }}
            </h2>
        </div>
    </x-slot>

        <div class="py-12 max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-[#202022] dark:bg-[#202022] overflow-hidden shadow-sm sm:rounded-lg p-6 text-white">
                    @if($errors->any())
                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                            <ul>
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('orders.store') }}" method="POST">
                        @csrf
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                            {{--client name--}}
                            <div>
                                <x-input-label for="client_name" value="Recipient's name"/>
                                <input id="client_name" name="client_name" type="text"
                                       class="block mt-1 w-full border rounded dark:bg-[#18181b] border-[#10b981] dark:border-gray-700 text-white shadow-sm focus:ring-[#10b981] dark:focus:ring-[#10b981]"
                                       required/>
                                <x-input-error :messages="$errors->get('client_name')" class="mt-2"/>
                            </div>

                            {{--client phone--}}
                            <div>
                                <x-input-label for="client_phone" value="Phone Number"/>
                                <input id="client_phone" name="client_phone" type="text"
                                       class="block mt-1 w-full border rounded dark:bg-[#18181b] border-[#10b981] dark:border-gray-700 text-white shadow-sm focus:ring-[#10b981] dark:focus:ring-[#10b981]"
                                       required/>
                                <x-input-error :messages="$errors->get('client_phone')" class="mt-2"/>
                            </div>

                            {{--region--}}
                            <div>
                                <x-input-label for="region_id" value="Governorate"/>
                                <select id="region_id" name="region_id"
                                        class="block mt-1 w-full border rounded dark:bg-[#18181b] border-[#10b981] dark:border-gray-700 text-white shadow-sm focus:ring-[#10b981] dark:focus:ring-[#10b981]"
                                        required>
                                    <option value="" selected disabled>Choose Governorate</option>
                                    @foreach($regions as $region)
                                        <option value="{{ $region->id}}">{{ $region->name }}</option>
                                    @endforeach
                                </select>
                                <x-input-error :messages="$errors->get('region_id')" class="mt-2"/>
                            </div>

                            {{--city--}}
                            <div>
                                <x-input-label for="client_city" value="City"/>
                                <input id="client_city" name="client_city" type="text"
                                       class="block mt-1 w-full border rounded dark:bg-[#18181b] border-[#10b981] dark:border-gray-700 text-white shadow-sm focus:ring-[#10b981] dark:focus:ring-[#10b981]"
                                       required/>
                                <x-input-error :messages="$errors->get('client_city')" class="mt-2"/>
                            </div>

                            {{--shipping type--}}
                            <div>
                                <x-input-label for="shipping_type" value="Shipping type"/>
                                <select id="shipping_type" name="shipping_type"
                                        class="block mt-1 w-full border rounded dark:bg-[#18181b] border-[#10b981] dark:border-gray-700 text-white shadow-sm focus:ring-[#10b981] dark:focus:ring-[#10b981]"
                                        required>
                                    <option value="" selected disabled>Shipping type</option>
                                    @foreach($shippingTypes as $key => $value)
                                        <option value="{{ $key }}">{{ $value }}</option>
                                    @endforeach
                                </select>
                                <x-input-error :messages="$errors->get('shipping_type')" class="mt-2"/>
                            </div>

                            {{--payment type--}}
                            <div>
                                <x-input-label for="payment_type" value="Payment Type"/>
                                <select id="payment_type" name="payment_type"
                                        class="block mt-1 w-full border rounded dark:bg-[#18181b] border-[#10b981] dark:border-gray-700 text-white shadow-sm focus:ring-[#10b981] dark:focus:ring-[#10b981]"
                                        required>
                                    <option value="" selected disabled>Payment Type</option>
                                    @foreach($paymentTypes as $key => $value)
                                        <option value="{{ $key }}">{{ $value }}</option>
                                    @endforeach
                                </select>
                                <x-input-error :messages="$errors->get('payment_type')" class="mt-2"/>
                            </div>


                            {{--village--}}
                            <div class="flex">
                                <div class="flex items-center h-5">
                                    <input id="helper-checkbox" aria-describedby="helper-checkbox-text" type="checkbox"
                                           value="1" name="village"
                                           class="w-4 h-4 text-[#10b981] bg-gray-100 border-gray-300 rounded-sm focus:ring-[#10b981] dark:focus:ring-[#10b981] dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                </div>
                                <div class="ms-2 text-sm">
                                    <label for="helper-checkbox" class="font-medium text-gray-900 dark:text-gray-300">Village</label>
                                    <p id="helper-checkbox-text"
                                       class="text-xs font-normal text-gray-500 dark:text-gray-300">Is this order for a
                                        village?</p>
                                </div>
                            </div>
                        </div>

                        {{--products--}}
                        <div class="mt-6">
                            <div class="flex justify-between items-center mb-4">
                                <h3 class="text-lg font-medium text-white">Products</h3>
                                <button type="button" id="add-product"
                                        class="px-4 py-2 bg-[#10b981] hover:bg-[#0f9c7a] text-white px-4 py-2 rounded mb-5">
                                    Add Products
                                </button>
                            </div>

                            <div class="mt-6">
                                <h3 class="text-lg font-medium mb-4">Product details</h3>
                                <div class="p-4 rounded" id="products-container">
                                    <div class="grid grid-cols-1 md:grid-cols-5 gap-4">
                                        <div>
                                            <x-input-label value="Product Name"/>
                                            <input name="products[0][product_name]" type="text"
                                                          class="block mt-1 w-full border rounded dark:bg-[#18181b] border-[#10b981] dark:border-gray-700 text-white shadow-sm focus:ring-[#10b981] dark:focus:ring-[#10b981]"
                                                          required/>
                                        </div>
                                        <div>
                                            <x-input-label value="Quantity"/>
                                            <input name="products[0][product_quantity]" type="number" min="1"
                                                          id="product_quantity" step="1"
                                                          oninput="this.value = Math.abs(this.value)"
                                                          class="block mt-1 w-full border rounded dark:bg-[#18181b] border-[#10b981] dark:border-gray-700 text-white shadow-sm focus:ring-[#10b981] dark:focus:ring-[#10b981]" required/>
                                        </div>
                                        <div>
                                            <x-input-label value="Weight (kg)"/>
                                            <input name="products[0][product_weight]" type="number" step="0.01"
                                                          min="0.1" oninput="this.value = Math.abs(this.value)"
                                                          id="product_weight"
                                                          class="block mt-1 w-full border rounded dark:bg-[#18181b] border-[#10b981] dark:border-gray-700 text-white shadow-sm focus:ring-[#10b981] dark:focus:ring-[#10b981]" required/>
                                        </div>
                                        <div>
                                            <x-input-label value="Price (EGP)"/>
                                            <input name="products[0][product_price]"
                                                          oninput="this.value = Math.abs(this.value)"
                                                          id="product_price"
                                                          type="number" step="0.01" min="0"
                                                          class="block mt-1 w-full border rounded dark:bg-[#18181b] border-[#10b981] dark:border-gray-700 text-white shadow-sm focus:ring-[#10b981] dark:focus:ring-[#10b981]" required/>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            {{--end of products--}}

                            {{--totals--}}
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
                                <div>
                                    <x-input-label for="order_price" value="Order price"/>
                                    <input id="order_price" name="order_price" type="number" min="0" step="0.01"
                                                  class="block mt-1 w-full border rounded dark:bg-[#18181b] border-[#10b981] dark:border-gray-700 text-[#10b981] shadow-sm focus:ring-[#10b981] dark:focus:ring-[#10b981]" disabled/>
                                </div>
                                <div>
                                    <x-input-label for="shipping_price" value="Shipping price"/>
                                    <input id="shipping_price" name="shipping_price" type="number" min="0"
                                                  step="0.01" class="block mt-1 w-full border rounded dark:bg-[#18181b] border-[#10b981] dark:border-gray-700 text-[#10b981] shadow-sm focus:ring-[#10b981] dark:focus:ring-[#10b981]" disabled/>
                                </div>
                                <div>
                                    <x-input-label for="total_weight" value="Total weight (kg)"/>
                                    <input id="total_weight" name="total_weight" type="number" min="0"
                                                  step="0.01"
                                                  class="block mt-1 w-full border rounded dark:bg-[#18181b] border-[#10b981] dark:border-gray-700 text-[#10b981] shadow-sm focus:ring-[#10b981] dark:focus:ring-[#10b981]" disabled/>
                                </div>
                                <div>
                                    <x-input-label for="total_price" value="Total price (EGP)"/>
                                    <input id="total_price" name="total_price" type="number" min="0" step="0.01"
                                                  class="block mt-1 w-full border rounded dark:bg-[#18181b] border-[#10b981] dark:border-gray-700 text-[#10b981] shadow-sm focus:ring-[#10b981] dark:focus:ring-[#10b981]" disabled/>
                                </div>
                            </div>
                            {{--end of totals--}}

                            {{--submit button--}}
                            <div class="flex justify-end mt-6">
                                <x-primary-button type="submit">Confirm your order</x-primary-button>
                            </div>
                    </form>
                </div>
            </div>
    @push('script')
        <script>
            document.addEventListener("DOMContentLoaded", function () {
                let productCount = 1;

                // Add new product
                document.getElementById('add-product').addEventListener('click', function () {
                    const container = document.getElementById('products-container');
                    const newRow = document.createElement('div');
                    newRow.className = 'grid grid-cols-1 md:grid-cols-5 gap-4 mt-4';

                    newRow.innerHTML = `
            <div>
                <x-input-label value="Product Name"/>
                <input name="products[${productCount}][product_name]" type="text" class="block mt-1 w-full border rounded dark:bg-[#18181b] border-[#10b981] dark:border-gray-700 text-white shadow-sm focus:ring-[#10b981] dark:focus:ring-[#10b981]" required/>
            </div>
            <div>
                <x-input-label value="Quantity"/>
                <input name="products[${productCount}][product_quantity]" type="number" step="1" min="1" class="block mt-1 w-full border rounded dark:bg-[#18181b] border-[#10b981] dark:border-gray-700 text-white shadow-sm focus:ring-[#10b981] dark:focus:ring-[#10b981]" required     oninput="this.value = Math.abs(this.value)"/>
            </div>
            <div>
                <x-input-label value="Weight (kg)"/>
                <input name="products[${productCount}][product_weight]" type="number" step="0.01" min="0.1" class="block mt-1 w-full border rounded dark:bg-[#18181b] border-[#10b981] dark:border-gray-700 text-white shadow-sm focus:ring-[#10b981] dark:focus:ring-[#10b981]" required oninput="this.value = Math.abs(this.value)"/>
            </div>
            <div>
                <x-input-label value="Price (EGP)"/>
                <input name="products[${productCount}][product_price]" type="number" step="0.01" min="0" class="block mt-1 w-full border rounded dark:bg-[#18181b] border-[#10b981] dark:border-gray-700 text-white shadow-sm focus:ring-[#10b981] dark:focus:ring-[#10b981]"     oninput="this.value = Math.abs(this.value)" required/>
            </div>
     <div class="flex justify-center mt-6">
    <button type="button" class="remove-product bg-red-500 text-white p-2 rounded-full flex items-center justify-center w-10 h-10">
    <span class="heroicons--trash remove-product"></span>
    </button>
</div>
        `;

                    container.appendChild(newRow);
                    productCount++;


                    updateCalculations();
                });

                document.getElementById('products-container').addEventListener('click', function (e) {
                    if (e.target.classList.contains('remove-product')) {
                        const row = e.target.closest('.grid');
                        if (row) {
                            row.remove();
                            productCount--;

                            // تحديث الحسابات
                            updateCalculations();
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
                        const quantity = parseFloat(productQuantities[index].value) || 1;
                        const weight = parseFloat(productWeights[index].value) || 0;

                        totalOrderPrice += price * quantity;
                        totalWeight += weight * quantity;
                    });


                    let shippingPrice = 20;  // سعر الشحن الأساسي
                    let extraWeight = totalWeight > 5 ? totalWeight - 5 : 0;

                    if (totalWeight > 5) {
                        shippingPrice += extraWeight * 10;
                    }

                    if (villageCheckbox && villageCheckbox.checked) {
                        shippingPrice += 20; // رسوم القرية
                    }

                    if (shippingType === "shipping_in_24_hours") {
                        shippingPrice += 20;
                    }

                    document.getElementById('order_price').value = totalOrderPrice.toFixed(2);
                    document.getElementById('total_weight').value = totalWeight.toFixed(2);
                    document.getElementById('shipping_price').value = shippingPrice.toFixed(2);
                    document.getElementById('total_price').value = (totalOrderPrice + shippingPrice).toFixed(2);
                }

                document.addEventListener('input', function (e) {
                    if (e.target.name.includes('[product_price]') ||
                        e.target.name.includes('[product_quantity]') ||
                        e.target.name.includes('[product_weight]') ||
                        e.target.name === 'village' ||
                        e.target.name === 'shipping_type') {
                        updateCalculations();
                    }
                });

            });
        </script>
    @endpush

</x-app-layout>
