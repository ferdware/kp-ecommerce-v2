<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VariantOption extends Model
{
	use HasFactory;

	protected $primaryKey = 'option_id';

	protected $fillable = [
		'variant_id',
		'option_value',
		'sku',
		'price',
		'stock_qty',
		'image',
		'display_order'
	];

	public function variant()
	{
		return $this->belongsTo(Variant::class, 'variant_id');
	}
}
