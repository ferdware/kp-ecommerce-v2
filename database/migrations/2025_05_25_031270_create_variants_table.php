<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
	public function up()
	{
		Schema::create('variants', function (Blueprint $table) {
			$table->bigIncrements('variant_id');
			$table->unsignedBigInteger('product_id');
			$table->string('variant_name');
			$table->integer('display_order')->default(0);
			$table->timestamps();

			// Add foreign key constraint
			$table->foreign('product_id')
			      ->references('product_id')
			      ->on('products')
			      ->onDelete('cascade');
		});
	}

	public function down()
	{
		Schema::dropIfExists('variants');
	}
};

