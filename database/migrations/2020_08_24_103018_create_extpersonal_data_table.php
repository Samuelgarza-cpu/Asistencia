<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExtpersonalDataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('extpersonal_data', function (Blueprint $table) {
            $table->id();
            $table->enum('civilStatus',['','soltero(a)','casado(a)','divorciado(a)','viudo(a)','unionLibre'])->nullable();
            $table->enum('scholarShip',['','sinEstudios','primaria','secundaria','bachillerato/tecnico','licenciatura/profesional','posgrado'])->nullable();
            $table->string('number',12)->default('0000000000')->nullable();;
            $table->foreignId('personal_data_id')->nullable();;
            $table->foreignId('employments_id')->nullable();;
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('extpersonal_data');
    }
}
