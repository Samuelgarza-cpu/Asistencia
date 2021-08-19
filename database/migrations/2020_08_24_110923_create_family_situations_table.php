<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFamilySituationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('familySituations', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('lastname')->nullable();
            $table->string('secondlastname')->nullable();
            $table->tinyInteger('age')->nullable();
            $table->enum('relationship', ['','padre', 'madre', 'hermano(a)','tio(a)','primo(a)','amigo(a)','hijo(a)','abuelo(a)','otros'])->nullable();
            $table->enum('civilStatus',['','soltero(a)','casado(a)','divorciado(a)','viudo(a)','unionLibre'])->nullable();
            $table->enum('scholarship',['','sinEstudios','primaria','secundaria','bachillerato/tecnico','licenciatura/profesional','posgrado'])->nullable();
            $table->foreignId('employments_id')->nullable();
            $table->foreignId('requests_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('familySituations');
    }
}
