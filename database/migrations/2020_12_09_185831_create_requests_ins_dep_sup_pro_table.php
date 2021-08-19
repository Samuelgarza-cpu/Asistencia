<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRequestsInsDepSupProTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('requests_ins_dep_sup_pro', function (Blueprint $table) {
            $table->id();
            $table->foreignId('requests_id')->nullable();
            $table->foreignId('products_id')->nullable();
            $table->integer('qty')->nullable();
            $table->string('price')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('requests_ins_dep_sup_pro');
    }
}
