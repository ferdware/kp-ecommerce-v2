<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function add(Product $product)
    {
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

        return redirect()->back()->with('success', 'Product added to cart successfully!');
    }

    public function index()
    {
        $cart = session()->get('cart', []);
        $cartItems = [];
        $cartTotal = 0;

        foreach($cart as $id => $details) {
            $product = \App\Models\Product::find($id);
            if($product) {
                $cartItems[] = [
                    'product' => $product,
                    'quantity' => $details['quantity']
                ];
                $cartTotal += $product->retail_price * $details['quantity'];
            }
        }

        return view('cart.index', compact('cartItems', 'cartTotal'));
    }

    public function remove(Product $product)
    {
        $cart = session()->get('cart', []);

        if(isset($cart[$product->product_id])) {
            unset($cart[$product->product_id]);
            session()->put('cart', $cart);
        }

        return redirect()->back()->with('success', 'Product removed from cart successfully!');
    }

    public function update(Request $request)
    {
        $cart = session()->get('cart', []);

        if($request->has('product_id') && $request->has('quantity')) {
            $productId = $request->product_id;
            $quantity = $request->quantity;

            if(isset($cart[$productId])) {
                $cart[$productId]['quantity'] = $quantity;
                session()->put('cart', $cart);

                return response()->json([
                    'success' => true,
                    'message' => 'Cart updated successfully!'
                ]);
            }
        }

        return response()->json([
            'success' => false,
            'message' => 'Failed to update cart.'
        ], 400);
    }
}
