<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCashRegistersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cash_registers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('warehouse_id');
            $table->unsignedBigInteger('user_id'); // Puede ser el propietario o el empleado que realiza la transacción
            $table->string('name');
            $table->enum('status', ['Open', 'Closed'])->default('Closed');
            $table->decimal('balance', 10, 2)->default(0); // Saldo actual en la caja
            $table->decimal('opening_balance', 10, 2)->default(0); // Saldo al iniciar
            $table->decimal('closing_balance', 10, 2)->nullable(); // Saldo al cerrar
            $table->json('opening_details')->nullable(); // Detalles del arqueo al iniciar
            $table->json('closing_details')->nullable(); // Detalles del arqueo al cerrar
            $table->timestamps();

            $table->foreign('warehouse_id')->references('id')->on('warehouses')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade'); // Ajusta según tu sistema de usuarios
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cash_registers');
    }
}
