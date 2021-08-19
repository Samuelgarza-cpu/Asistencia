<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLifeConditionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lifeConditions', function (Blueprint $table) {
            $table->id();
            $table->string('typeHouse')->nullable();;
            $table->tinyInteger('number_rooms')->nullable();;
            $table->foreignId('requests_id')->nullable();;
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('lifeConditions');
    }
}
