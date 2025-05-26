@extends('layouts.app')

@section('content')
    <div class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
        <h1 class="text-3xl font-bold text-gray-900 mb-8">Your Shopping Cart</h1>

        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4" role="alert">
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        @endif

        @if(isset($cartItems) && count($cartItems) > 0)
            <div class="bg-white shadow overflow-hidden sm:rounded-lg">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Product
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Price
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Quantity
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Subtotal
                        </th>
                        <th scope="col" class="relative px-6 py-3">
                            <span class="sr-only">Actions</span>
                        </th>
                    </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($cartItems as $item)
                        <tr data-id="{{ $item['product']->product_id }}">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="h-10 w-10 flex-shrink-0">
                                        <img class="h-10 w-10 object-cover rounded"
                                             src="{{ $item['product']->main_image }}"
                                             alt="{{ $item['product']->product_name }}">
                                    </div>
                                    <div class="ml-4">
                                        <a href="{{ route('products.show', ['product' => $item['product']->product_id]) }}"
                                           class="text-sm font-medium text-gray-900 hover:text-blue-600">
                                            {{ $item['product']->product_name }}
                                        </a>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                ${{ number_format($item['product']->retail_price, 2) }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                <div class="flex items-center space-x-3">
                                    <button class="quantity-btn minus-btn text-gray-500 hover:text-gray-700 focus:outline-none">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M3 10a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z" clip-rule="evenodd" />
                                        </svg>
                                    </button>

                                    <input type="number" min="1" 
                                           value="{{ $item['quantity'] }}" 
                                           data-id="{{ $item['product']->product_id }}"
                                           class="cart-quantity-input form-input rounded-md shadow-sm w-16 text-center" />

                                    <button class="quantity-btn plus-btn text-gray-500 hover:text-gray-700 focus:outline-none">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
                                        </svg>
                                    </button>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                ${{ number_format($item['product']->retail_price * $item['quantity'], 2) }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <form action="{{ route('cart.remove', ['product' => $item['product']->product_id]) }}" method="POST" class="inline">
                                    @csrf
                                    <button type="submit"
                                            class="text-red-600 hover:text-red-900">
                                        Remove
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>

                <div class="px-6 py-4 bg-gray-50 border-t border-gray-200 sm:px-8">
                    <div class="flex justify-between items-center">
                        <span class="text-lg font-medium text-gray-900">Total: ${{ number_format($cartTotal, 2) }}</span>

                        <div class="space-x-4">
                            <a href="{{ route('products.index') }}"
                               class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-gray-600 hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                                Continue Shopping
                            </a>
                            <a href="#"
                               class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                Proceed to Checkout
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @else
            <div class="bg-white shadow overflow-hidden sm:rounded-lg p-8 text-center">
                <p class="text-gray-600 mb-6">Your shopping cart is empty.</p>
                <a href="{{ route('products.index') }}"
                   class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    Browse Products
                </a>
            </div>
        @endif
    </div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Handle plus/minus buttons
        document.querySelectorAll('.quantity-btn').forEach(button => {
            button.addEventListener('click', function() {
                const input = this.parentNode.querySelector('.cart-quantity-input');
                let value = parseInt(input.value);

                if (this.classList.contains('minus-btn') && value > 1) {
                    input.value = value - 1;
                } else if (this.classList.contains('plus-btn')) {
                    input.value = value + 1;
                }

                // Trigger update
                updateCartQuantity(input);
            });
        });

        // Handle direct input changes
        document.querySelectorAll('.cart-quantity-input').forEach(input => {
            input.addEventListener('change', function() {
                updateCartQuantity(this);
            });
        });

        function updateCartQuantity(input) {
            const productId = input.getAttribute('data-id');
            const quantity = parseInt(input.value);

            if (quantity < 1) {
                input.value = 1;
                return;
            }

            // Show loading indicator
            const row = input.closest('tr');
            row.classList.add('opacity-50');

            fetch('{{ route('cart.update') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    product_id: productId,
                    quantity: quantity
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Reload the page to show updated cart
                    window.location.reload();
                } else {
                    alert('Failed to update cart: ' + data.message);
                    row.classList.remove('opacity-50');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred. Please try again.');
                row.classList.remove('opacity-50');
            });
        }
    });
</script>
@endpush
