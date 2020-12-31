<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ProductFeatureTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_features', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps();
        });
        Schema::create('product_features_product', function (Blueprint $table) {
            $table->bigInteger('feature_id')->unsigned();
            $table->bigInteger('product_id')->unsigned();
            $table->json('value');
            $table->timestamps();
            $table->foreign('feature_id')->references('id')->on('product_features')->onDelete('cascade');
            $table->foreign('product_id')->references('id')->on('products');
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
        Schema::dropIfExists('feature_product');
        Schema::dropIfExists('features');
        Schema::enableForeignKeyConstraints();
    }
}
