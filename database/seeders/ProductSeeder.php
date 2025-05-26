<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Variant;
use App\Models\VariantOption;

class ProductSeeder extends Seeder
{
	public function run()
	{
		// Create a sample product
		$product = Product::create([
			'product_name' => 'Sample T-Shirt',
			'product_description' => 'A comfortable cotton t-shirt available in multiple colors and sizes.',
			'product_type' => 'Clothing',
			'product_collection' => 'Summer Collection',
			'retail_price' => 29.99,
			'discount_price' => 19.99,
			'cost' => 10.00,
			'sku' => 'TSHIRT-001',
			'ship_location' => 'Warehouse A',
			'stock_qty' => 100,
			'weight_lbs' => 0,
			'weight_oz' => 8,
			'meta_tags' => 'tshirt, cotton, clothing',
			'main_image' => 'https://via.placeholder.com/600x400?text=T-Shirt',
			'images' => json_encode([
				'https://via.placeholder.com/600x400?text=T-Shirt-Front',
				'https://via.placeholder.com/600x400?text=T-Shirt-Back',
			]),
			'vendor' => 'Fashion Brand',
			'status' => 'active'
		]);

		// Create size variant
		$sizeVariant = Variant::create([
			'product_id' => $product->product_id,
			'variant_name' => 'Size',
			'display_order' => 1
		]);

		// Size options
		VariantOption::create([
			'variant_id' => $sizeVariant->variant_id,
			'option_value' => 'Small',
			'sku' => 'TSHIRT-001-S',
			'stock_qty' => 25,
			'display_order' => 1
		]);

		VariantOption::create([
			'variant_id' => $sizeVariant->variant_id,
			'option_value' => 'Medium',
			'sku' => 'TSHIRT-001-M',
			'stock_qty' => 30,
			'display_order' => 2
		]);

		VariantOption::create([
			'variant_id' => $sizeVariant->variant_id,
			'option_value' => 'Large',
			'sku' => 'TSHIRT-001-L',
			'stock_qty' => 30,
			'display_order' => 3
		]);

		VariantOption::create([
			'variant_id' => $sizeVariant->variant_id,
			'option_value' => 'XL',
			'sku' => 'TSHIRT-001-XL',
			'stock_qty' => 15,
			'display_order' => 4
		]);

		// Create color variant
		$colorVariant = Variant::create([
			'product_id' => $product->product_id,
			'variant_name' => 'Color',
			'display_order' => 2
		]);

		// Color options
		VariantOption::create([
			'variant_id' => $colorVariant->variant_id,
			'option_value' => 'Black',
			'image' => 'https://via.placeholder.com/600x400?text=Black-T-Shirt',
			'display_order' => 1
		]);

		VariantOption::create([
			'variant_id' => $colorVariant->variant_id,
			'option_value' => 'White',
			'image' => 'https://via.placeholder.com/600x400?text=White-T-Shirt',
			'display_order' => 2
		]);

		VariantOption::create([
			'variant_id' => $colorVariant->variant_id,
			'option_value' => 'Blue',
			'image' => 'https://via.placeholder.com/600x400?text=Blue-T-Shirt',
			'display_order' => 3
		]);
	}
}
