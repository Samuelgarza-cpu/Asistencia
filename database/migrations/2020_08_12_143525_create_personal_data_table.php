<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePersonalDataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('personalData', function (Blueprint $table) {
            $table->id();
            $table->string('curp',18)->nullable();;
            $table->string('name')->nullable();;
            $table->string('lastName')->nullable();;
            $table->string('secondLastName')->nullable();;
            $table->tinyInteger('age')->nullable();;
            $table->foreignId('addresses_id')->nullable();;
            $table->boolean('familiar')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('personalData');
    }
}
