<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateModulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('modules', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('setting_id');
            $table->foreign('setting_id')->references('id')->on('settings')->onDelete('cascade');
            $table->string('title')->nullable();
            $table->text('details')->nullable();
            $table->string('image')->nullable();
            $table->text('benefits')->nullable();
            $table->text('features')->nullable();
            $table->decimal('price', 10, 2)->default(0);
            $table->string('amount')->length(10)->nullable();
            $table->enum('payment_method',['Cash', 'Debit', 'Credit Card'])->default('Cash')->nullable();
            $table->string('transaction_id')->length(10)->nullable();
            $table->enum('status', ['Pending','In process','Approved','Rejected','Canceled','Completed','Refunded'])->default('Pending')->nullable();
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
        Schema::dropIfExists('modules');
    }
}
