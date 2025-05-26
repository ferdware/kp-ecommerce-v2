<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Variant extends Model
{
	use HasFactory;

	protected $primaryKey = 'variant_id';

	protected $fillable = [
		'product_id',
		'variant_name',
		'display_order'
	];

	public function product()
	{
		return $this->belongsTo(Product::class, 'product_id');
	}

	public function options()
	{
		return $this->hasMany(VariantOption::class, 'variant_id')
		            ->orderBy('display_order');
	}
}
