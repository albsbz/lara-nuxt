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
        Schema::create('productFeature_product', function (Blueprint $table) {
            $table->bigInteger('product_feature_id')->unsigned();
            $table->bigInteger('product_id')->unsigned();
            $table->text('value');
            $table->timestamps();
            $table->foreign('product_feature_id')->references('id')->on('product_features');
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
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
        Schema::dropIfExists('productFeature_product');
        Schema::dropIfExists('product_features');
        Schema::enableForeignKeyConstraints();
    }
}
