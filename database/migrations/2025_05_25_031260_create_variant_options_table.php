<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
	public function up()
	{
		Schema::create('variant_options', function (Blueprint $table) {
			$table->bigIncrements('option_id');
			$table->unsignedBigInteger('variant_id');
			$table->string('option_value');
			$table->string('sku')->nullable();
			$table->decimal('price', 10, 2)->default(0);
			$table->integer('stock_qty')->default(0);
			$table->string('image')->nullable();
			$table->integer('display_order')->default(0);
			$table->timestamps();

			// Add foreign key constraint
			$table->foreign('variant_id')
			      ->references('variant_id')
			      ->on('variants')
			      ->onDelete('cascade');
		});
	}

	public function down()
	{
		Schema::dropIfExists('variant_options');
	}
};

