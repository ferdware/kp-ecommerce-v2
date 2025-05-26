<?php

namespace App\Services;

use Illuminate\Support\Facades\Session;
use App\Models\Product;
use App\Models\VariantOption;

class CartService
{
	protected $sessionKey = 'cart';

	/**
	 * Get cart contents
	 */
	public function getContent()
	{
		return Session::get($this->sessionKey, []);
	}

	/**
	 * Add item to cart
	 */
	public function add($product, $quantity = 1)
	{
		$id = $product->product_id;
		$cart = $this->getContent();

		$cartItem = [
			"id" => $product->product_id,
			"type" => 'product',
			"name" => $product->product_name,
			"quantity" => $quantity,
			"price" => $product->discount_price ?? $product->retail_price,
			"image" => $product->main_image,
			"option" => null,
			"option_id" => null
		];

		// Check if same product is already in cart
		if(isset($cart[$id])) {
			$cart[$id]['quantity'] += $quantity;
		} else {
			$cart[$id] = $cartItem;
		}

		Session::put($this->sessionKey, $cart);

		return $cart;
	}

	/**
	 * Add product with variant option to cart
	 */
	public function addWithOption($product, $option, $quantity = 1)
	{
		$uniqueId = $product->product_id . '_' . $option->option_id;
		$cart = $this->getContent();

		$cartItem = [
			"id" => $product->product_id,
			"type" => 'variant',
			"name" => $product->product_name,
			"quantity" => $quantity,
			"price" => $option->price > 0 ? $option->price : ($product->discount_price ?? $product->retail_price),
			"image" => $option->image ?? $product->main_image,
			"option" => $option->option_value,
			"option_id" => $option->option_id,
			"unique_id" => $uniqueId
		];

		// For variant options, we use a unique ID combining product and option
		if(isset($cart[$uniqueId])) {
			$cart[$uniqueId]['quantity'] += $quantity;
		} else {
			$cart[$uniqueId] = $cartItem;
		}

		Session::put($this->sessionKey, $cart);

		return $cart;
	}

	/**
	 * Update cart item
	 */
	public function update($id, $quantity)
	{
		$cart = $this->getContent();

		if(isset($cart[$id])) {
			$cart[$id]['quantity'] = $quantity;
			Session::put($this->sessionKey, $cart);
		}

		return $cart;
	}

	/**
	 * Remove item from cart
	 */
	public function remove($id)
	{
		$cart = $this->getContent();

		if(isset($cart[$id])) {
			unset($cart[$id]);
			Session::put($this->sessionKey, $cart);
		}

		return $cart;
	}

	/**
	 * Clear cart
	 */
	public function clear()
	{
		Session::forget($this->sessionKey);
	}

	/**
	 * Get cart total
	 */
	public function getTotal()
	{
		$total = 0;
		$cart = $this->getContent();

		foreach($cart as $item) {
			$total += $item['price'] * $item['quantity'];
		}

		return $total;
	}

	/**
	 * Get count of items in cart
	 */
	public function getCount()
	{
		return count($this->getContent());
	}
}
