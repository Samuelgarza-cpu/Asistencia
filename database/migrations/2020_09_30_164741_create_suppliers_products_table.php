<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSuppliersProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('suppliers_products', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->boolean('active')->default(true);
            $table->float('price', 8, 2);
            $table->foreignId('products_id');
            $table->foreignId('suppliers_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('suppliers_products');
    }
}
