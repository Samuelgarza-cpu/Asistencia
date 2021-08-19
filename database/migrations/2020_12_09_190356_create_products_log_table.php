<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsLogTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('productslog', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->foreignId('suppliersProducts_id');
            $table->string('price', 20);
            $table->string('productName');
            $table->string('supplierName');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products_log');
    }
}
