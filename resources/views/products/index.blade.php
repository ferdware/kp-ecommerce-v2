@extends('layouts.app')

@section('content')
    <div class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
        <h1 class="text-3xl font-bold text-gray-900 mb-8">Our Products</h1>

        <div class="grid grid-cols-1 gap-y-10 gap-x-6 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
            @foreach($products as $product)
                <div class="group relative bg-white rounded-lg shadow overflow-hidden">
                    <!-- Product Image (Linked) -->
                    <div class="aspect-w-3 aspect-h-2 overflow-hidden">
                        <a href="{{ route('products.show', ['product' => $product->product_id]) }}">
                            <img src="{{ $product->main_image }}" alt="{{ $product->product_name }}"
                                 class="w-full h-56 object-cover object-center group-hover:opacity-75 transition-opacity">
                        </a>
                    </div>

                    <div class="p-4">
                        <!-- Product Title (Linked) -->
                        <h3 class="text-lg font-semibold">
                            <a href="{{ route('products.show', ['product' => $product->product_id]) }}" class="text-gray-900 hover:text-blue-600">
                                {{ $product->product_name }}
                            </a>
                        </h3>

                        <!-- Price -->
                        <p class="mt-2 text-xl font-medium text-gray-900">${{ number_format($product->retail_price, 2) }}</p>

                        <!-- Short Description -->
                        <p class="mt-2 text-gray-600 text-sm line-clamp-2">
                            {{ $product->product_description }}
                        </p>

                        <!-- Action Buttons -->
                        <div class="mt-4 flex space-x-2">
                            <a href="{{ route('products.show', ['product' => $product->product_id]) }}"
                               class="flex-1 bg-gray-200 py-2 px-4 border border-transparent rounded-md text-sm font-medium text-gray-900 hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 text-center">
                                View Details
                            </a>
                            <a href="{{ route('cart.add', ['product' => $product->product_id]) }}"
                               class="flex-1 bg-blue-600 py-2 px-4 border border-transparent rounded-md text-sm font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 text-center">
                                Add to Cart
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Pagination if needed -->
        <div class="mt-8">
            {{ $products->links() }}
        </div>
    </div>
@endsection
