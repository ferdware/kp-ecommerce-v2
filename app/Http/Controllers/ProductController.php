<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the products.
     */
    public function index()
    {
        $products = Product::paginate(12);
        return view('products.index', compact('products'));
    }

    /**
     * Display the specified product.
     */
    public function show(Product $product)
    {
        return view('products.show', compact('product'));
    }

    /**
     * Add a product to the cart.
     */
    public function addToCart($id)
    {
        $product = Product::find($id);

        if(!$product) {
            return response()->json([
                'success' => false,
                'message' => 'Product not found'
            ], 404);
        }

        // Get the cart from the session or initialize an empty array
        $cart = session()->get('cart', []);

        // Add the product to the cart or increment quantity if already exists
        if(isset($cart[$product->product_id])) {
            $cart[$product->product_id]['quantity']++;
        } else {
            $cart[$product->product_id] = [
                'product_id' => $product->product_id,
                'name' => $product->product_name,
                'price' => $product->retail_price,
                'image' => $product->main_image,
                'quantity' => 1
            ];
        }

        // Update the cart in the session
        session()->put('cart', $cart);

        // Calculate cart count for response
        $cartCount = 0;
        foreach ($cart as $item) {
            $cartCount += $item['quantity'];
        }

        return response()->json([
            'success' => true,
            'message' => 'Product added to cart successfully!',
            'cart_count' => $cartCount
        ]);
    }
}
