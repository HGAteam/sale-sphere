<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug');
            $table->string('image')->nullable();
            $table->string('barcode')->nullable();
            $table->enum('status',['Empty','To Enter Stock', 'In Process', 'Processed'])->default('To Enter Stock')->nullable();
            $table->text('description')->nullable();
            $table->boolean('requires_returnable')->default(false);
            $table->boolean('requires_stock')->default(true);
            $table->unsignedBigInteger('brand_id');  // Añadida clave foránea para la relación con la tabla de marcas
            $table->unsignedBigInteger('category_id');  // Añadida clave foránea para la relación con la tabla de categorías
            $table->decimal('purchase_price', 10, 2)->default(0);  // Precio de compra
            $table->decimal('selling_price', 10, 2)->default(0);   // Precio de venta
            $table->decimal('wholesale_price', 10, 2)->default(0)->nullable();   // Precio de mayorista
            $table->string('unit')->default('Unit'); // Unidad de medida (ej. gramos, unidad, litros, etc.)
            $table->integer('quantity')->default(0);
            $table->timestamps();

            // Definición de las claves foráneas
            $table->foreign('brand_id')->references('id')->on('brands')->onDelete('cascade');
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
}
