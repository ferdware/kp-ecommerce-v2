@extends('layouts.app')

@section('content')
    <div class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
        <div class="bg-white shadow overflow-hidden sm:rounded-lg">
            <div class="lg:flex">
                <!-- Product Image -->
                <div class="lg:w-1/2">
                    <a href="{{ route('products.show', ['product' => $product->product_id]) }}">
                        <img src="{{ $product->main_image }}" alt="{{ $product->product_name }}"
                             class="w-full h-96 object-cover object-center">
                    </a>
                </div>

                <!-- Product Details -->
                <div class="p-8 lg:w-1/2">
                    <!-- Back button -->
                    <a href="{{ route('products.index') }}" class="text-blue-600 hover:text-blue-800 mb-4 inline-block">
                        &larr; Back to Products
                    </a>

                    <h1 class="text-3xl font-bold text-gray-900 mt-2">
                        <a href="{{ route('products.show', ['product' => $product->product_id]) }}">{{ $product->product_name }}</a>
                    </h1>

                    <p class="mt-4 text-2xl font-bold text-gray-900">${{ number_format($product->retail_price, 2) }}</p>

                    <div class="mt-6 border-t border-gray-200 pt-6">
                        <h3 class="text-lg font-medium text-gray-900">Description</h3>
                        <div class="mt-2 prose prose-blue text-gray-700">
                            <p>{{ $product->product_description }}</p>
                        </div>
                    </div>

                    <!-- Add to Cart form with AJAX functionality -->
                    <div class="mt-8 flex space-x-4">
                        <a href="{{ route('products.show', ['product' => $product->product_id]) }}"
                           class="flex-1 bg-gray-200 py-3 px-8 border border-transparent rounded-md text-base font-medium text-gray-900 hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 text-center">
                            View Details
                        </a>

                        <form action="{{ route('add.to.cart', $product->product_id) }}" method="POST" id="add-to-cart-form" class="flex-1">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $product->product_id }}">
                            <button type="submit"
                                    class="w-full bg-blue-600 py-3 px-8 border border-transparent rounded-md text-base font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 text-center">
                                Add to Cart
                            </button>
                        </form>
                    </div>

                    <!-- Status message for AJAX response -->
                    <div id="status-message" class="mt-4 hidden"></div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script>
$(document).ready(function() {
    $('#add-to-cart-form').on('submit', function(e) {
        e.preventDefault(); // This is critical - it stops the form from submitting normally
        
        var form = $(this);
        var url = form.attr('action');
        var submitBtn = form.find('button[type="submit"]');
        
        // Disable button during request
        submitBtn.prop('disabled', true);
        
        // Send AJAX request
        $.ajax({
            type: "POST",
            url: url,
            data: form.serialize(),
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            dataType: 'json', // Explicitly set dataType to json
            success: function(response) {
                // Re-enable button
                submitBtn.prop('disabled', false);
                
                // Show success message
                var statusMessage = $('#status-message');
                statusMessage
                    .removeClass('hidden bg-red-100 text-red-700')
                    .addClass('bg-green-100 text-green-700 p-3 rounded')
                    .text(response.message || 'Product added to cart successfully')
                    .show();
                
                // Update cart count in navigation
                if (response.cart_count > 0) {
                    var cartCountElement = $('.cart-count-indicator');
                    
                    if (cartCountElement.length === 0) {
                        // If the cart count element doesn't exist, create it
                        $('.cart-icon').append('<span class="cart-count-indicator absolute -top-1 -right-1 bg-red-600 text-white rounded-full w-5 h-5 flex items-center justify-center text-xs">' + response.cart_count + '</span>');
                    } else {
                        // Otherwise, update the existing element
                        cartCountElement.text(response.cart_count);
                    }
                }
                
                // Auto-hide message after 3 seconds
                setTimeout(function() {
                    statusMessage.fadeOut();
                }, 3000);
            },
            error: function(xhr) {
                // Re-enable button
                submitBtn.prop('disabled', false);
                
                // Get error message
                var errorMessage = 'An error occurred. Please try again.';
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    errorMessage = xhr.responseJSON.message;
                }
                
                // Show error message
                var statusMessage = $('#status-message');
                statusMessage
                    .removeClass('hidden bg-green-100 text-green-700')
                    .addClass('bg-red-100 text-red-700 p-3 rounded')
                    .text(errorMessage)
                    .show();
                
                // Auto-hide message after 3 seconds
                setTimeout(function() {
                    statusMessage.fadeOut();
                }, 3000);
            }
        });
    });
});
</script>