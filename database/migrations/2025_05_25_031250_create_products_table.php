<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
	public function up()
	{
		Schema::create('products', function (Blueprint $table) {
			$table->bigIncrements('product_id')->primary();
			$table->string('product_name');
			$table->longText('product_description')->nullable();
			$table->string('product_type')->nullable();
			$table->longText('product_collection')->nullable();
			$table->decimal('retail_price', 10, 2)->default(0);
			$table->decimal('discount_price', 10, 2)->nullable();
			$table->decimal('cost', 10, 2)->nullable();
			$table->string('sku')->nullable();
			$table->string('ship_location')->nullable();
			$table->integer('stock_qty')->default(0);
			$table->integer('track_qty')->nullable();
			$table->integer('weight_lbs')->nullable();
			$table->integer('weight_oz')->nullable();
			$table->integer('ship_length')->nullable();
			$table->integer('ship_width')->nullable();
			$table->integer('ship_height')->nullable();
			$table->longText('meta_tags')->nullable();
			$table->string('slug')->unique();
			$table->string('main_image')->nullable();
			$table->longText('images')->nullable();
			$table->longText('seo_text')->nullable();
			$table->string('vendor')->nullable();
			$table->longText('status')->nullable();
			$table->timestamps();
		});
	}

	public function down()
	{
		Schema::dropIfExists('products');
	}
};
