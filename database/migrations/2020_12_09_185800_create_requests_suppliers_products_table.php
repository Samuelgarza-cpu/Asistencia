<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRequestsSuppliersProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('requests_suppliersProducts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('requests_id')->nullable();
            $table->foreignId('suppliersProducts_id')->nullable();
            $table->integer('qty')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('requests_suppliersProducts');
    }
}
