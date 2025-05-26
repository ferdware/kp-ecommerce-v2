<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Product extends Model
{
	use HasFactory;

	protected $primaryKey = 'product_id';

	protected $fillable = [
		'product_name',
		'product_description',
		'product_type',
		'product_collection',
		'retail_price',
		'discount_price',
		'cost',
		'sku',
		'ship_location',
		'stock_qty',
		'track_qty',
		'weight_lbs',
		'weight_oz',
		'ship_length',
		'ship_width',
		'ship_height',
		'meta_tags',
		'slug',
		'main_image',
		'images',
		'seo_text',
		'vendor',
		'status'
	];

	protected static function boot()
	{
		parent::boot();

		// Generate slug from name when creating a product
		static::creating(function ($product) {
			$product->slug = $product->slug ?? Str::slug($product->product_name);
		});
	}

	public function variants()
	{
		return $this->hasMany(Variant::class, 'product_id');
	}

	// Get all images as array
	public function getImagesArrayAttribute()
	{
		return $this->images ? json_decode($this->images, true) : [];
	}

	// Set images as JSON
	public function setImagesAttribute($value)
	{
		$this->attributes['images'] = is_array($value) ? json_encode($value) : $value;
	}
}
