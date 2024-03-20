<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSuppliersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('suppliers', function (Blueprint $table) {
            $table->id();
            $table->string('social_reason');
            $table->string('slug');
            $table->string('contact');
            $table->string('email');
            $table->string('cuit')->nullable();
            $table->enum('status',['Active','Inactive','Deleted'])->default('Active');
            $table->string('image')->nullable();
            $table->string('address')->nullable();
            $table->string('location')->nullable();
            $table->string('phone');
            $table->string('mobile')->nullable();
            $table->timestamp('deleted_at')->nullable();
            $table->text('details');
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
        Schema::dropIfExists('suppliers');
    }
}
