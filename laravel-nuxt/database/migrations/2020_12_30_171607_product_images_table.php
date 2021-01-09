<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ProductImagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('productImages', function (Blueprint $table) {
            $table->id();
            $table->string('url');
            $table->timestamps();
        });
        Schema::create('productImage_product', function (Blueprint $table) {
            $table->bigInteger('image_id')->unsigned();
            $table->bigInteger('product_id')->unsigned();
            $table->integer('order')->unsigned()->default(0);
            $table->timestamps();
            $table->foreign('product_id')->references('id')->on('products');
            $table->foreign('image_id')->references('id')->on('productImages')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('productImage_product');
        Schema::dropIfExists('productImages');
        Schema::enableForeignKeyConstraints();
    }
}
