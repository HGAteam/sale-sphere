<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePriceChangesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('price_changes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('product_id');
            $table->decimal('old_purchase_price', 10, 2)->default(0);
            $table->decimal('new_purchase_price', 10, 2)->default(0);
            $table->decimal('old_selling_price', 10, 2)->default(0);
            $table->decimal('new_selling_price', 10, 2)->default(0);
            $table->decimal('old_wholesale_price', 10, 2)->default(0);
            $table->decimal('new_wholesale_price', 10, 2)->default(0);
            $table->text('details')->default('Los detalles ayudan a identificar el motivo del cambio');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('price_changes');
    }
}
