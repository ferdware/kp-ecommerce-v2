<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        // Get cart from session
        $cart = session()->get('cart', []);
        $cartItems = [];
        $cartTotal = 0;
        
        // Transform cart data into a format that works with our view
        foreach ($cart as $id => $details) {
            $product = Product::find($id);
            if ($product) {
                $cartItems[] = [
                    'product' => $product,
                    'quantity' => $details['quantity']
                ];
                $cartTotal += $product->retail_price * $details['quantity'];
            }
        }
        
        return view('cart.index', [
            'cartItems' => $cartItems,
            'cartTotal' => $cartTotal,
        ]);
    }

    public function add(Product $product)
    {
        $cart = session()->get('cart', []);
        
        // Check if product is already in cart
        if (isset($cart[$product->product_id])) {
            $cart[$product->product_id]['quantity']++;
        } else {
            $cart[$product->product_id] = [
                'quantity' => 1,
                'price' => $product->retail_price,
                'name' => $product->product_name,
                'image' => $product->main_image
            ];
        }
        
        session()->put('cart', $cart);
        
        return redirect()->route('cart.index')->with('success', 'Product added to cart successfully!');
    }
    
    public function remove(Product $product)
    {
        $cart = session()->get('cart', []);
        
        if (isset($cart[$product->product_id])) {
            unset($cart[$product->product_id]);
            session()->put('cart', $cart);
        }
        
        return redirect()->route('cart.index')->with('success', 'Product removed from cart successfully!');
    }
    
    public function update(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,product_id',
            'quantity' => 'required|integer|min:1'
        ]);
        
        $productId = $request->product_id;
        $quantity = $request->quantity;
        
        $cart = session()->get('cart', []);
        
        if (isset($cart[$productId])) {
            $cart[$productId]['quantity'] = $quantity;
            session()->put('cart', $cart);
            
            return response()->json([
                'success' => true,
                'message' => 'Cart updated successfully'
            ]);
        }
        
        return response()->json([
            'success' => false,
            'message' => 'Product not found in cart'
        ], 404);
    }
}