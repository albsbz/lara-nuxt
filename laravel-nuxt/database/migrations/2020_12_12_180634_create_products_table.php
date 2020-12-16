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
            $table->timestamps();
            $table->integer('category_id')->unsigned()->nullable();
            $table->string('imgPath', 128)->nullable();
            $table->string('gallery')->nullable();
            $table->string('name', 64);
            $table->integer('price')->unsigned();
            $table->string('description')->nullable();
            $table->string('slug', 64)->unique();
            $table->boolean('instock')->default(0);
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
