<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clients', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug');
            $table->string('lastname');
            $table->string('email');
            $table->enum('status',['Active','Inactive','Deleted'])->default('Active');
            $table->string('dni')->nullable();
            $table->string('image')->nullable();
            $table->string('address')->nullable();
            $table->string('location')->nullable();
            $table->string('phone')->nullable();
            $table->string('mobile')->nullable();
            $table->text('details')->nullable();
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
        Schema::dropIfExists('clients');
    }
}