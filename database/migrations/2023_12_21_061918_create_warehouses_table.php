<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWarehousesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('warehouses', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug');
            $table->string('location')->nullable();
            $table->string('address')->nullable();
            $table->boolean('status')->default(1);
            $table->string('branch_manager')->nullable();
            $table->string('phone')->nullable();
            $table->string('mobile')->nullable();
            $table->text('details')->nullable();
            $table->integer('cashiers')->default(1);
            $table->timestamp('deleted_at')->nullable(); // Opcional si deseas tener una marca de tiempo de eliminación
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('warehouses');
    }
}
