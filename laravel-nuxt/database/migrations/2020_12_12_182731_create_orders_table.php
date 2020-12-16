<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->bigInteger('user_id')->unsigned()->default('0');
            $table->integer('price')->unsigned();
            $table->string('address', 128);
            $table->string('phone', 12);
            $table->foreign('user_id')->references('id')->on('users')->onDelete('SET DEFAULT');
            $table->bigInteger('status')->unsigned()->default(0);
            $table->foreign('status')->references('id')->on('orders_statuses');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
}
