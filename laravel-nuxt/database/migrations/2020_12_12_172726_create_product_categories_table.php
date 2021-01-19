<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_categories', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->bigInteger('parent_id')->unsigned()->default(1)->nullable();
            $table->foreign('parent_id')->references('id')->on('product_categories')->onDelete('SET DEFAULT');
            $table->string('name')->nullable();
            $table->string('description')->nullable();
            $table->string('url')->nullable();
            $table->string('slug', 64)->unique()->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product_categories');
    }
}
