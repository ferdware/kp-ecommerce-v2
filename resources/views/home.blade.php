@extends('layouts.app')

@section('content')
    <div class="max-w-7xl mx-auto py-16 px-4 sm:px-6 lg:px-8">
        <div class="text-center">
            <h1 class="text-4xl font-extrabold text-gray-900 sm:text-5xl sm:tracking-tight lg:text-6xl">
                Welcome to our Store
            </h1>
            <p class="mt-5 max-w-xl mx-auto text-xl text-gray-500">
                Discover our amazing products and start shopping today!
            </p>
            <div class="mt-8">
                <a href="{{ route('products.index') }}" class="inline-flex items-center justify-center px-6 py-3 border border-transparent text-base font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    View Products
                </a>
            </div>
        </div>

        <div class="mt-16 grid grid-cols-1 gap-8 sm:grid-cols-2 lg:grid-cols-3">
            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="px-4 py-5 sm:p-6">
                    <h3 class="text-lg font-medium text-gray-900">Quality Products</h3>
                    <p class="mt-2 text-sm text-gray-500">
                        We offer only the highest quality products to ensure customer satisfaction.
                    </p>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="px-4 py-5 sm:p-6">
                    <h3 class="text-lg font-medium text-gray-900">Fast Shipping</h3>
                    <p class="mt-2 text-sm text-gray-500">
                        We ship all orders within 24 hours to get your products to you as quickly as possible.
                    </p>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="px-4 py-5 sm:p-6">
                    <h3 class="text-lg font-medium text-gray-900">Secure Payment</h3>
                    <p class="mt-2 text-sm text-gray-500">
                        Our secure payment system ensures your financial information is always protected.
                    </p>
                </div>
            </div>
        </div>
    </div>
@endsection