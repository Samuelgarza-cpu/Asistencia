<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCommunitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('communities', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('postalCode',5);
            $table->enum('type',['colonia', 'ejido', 'equipamiento', 'fraccionamiento', 'granja', 'paraje', 'pueblo', 'rancheria', 'unidad habitacional', 'zona industrial', 'barrio', 'rancho', 'zona federal', 'aeropuerto', 'condominio', 'finca', 'hacienda', 'Zona comercial', 'Parque industrial', 'Zona militar', 'Puerto', 'Conjunto habitacional', 'Congregación', 'Exhacienda', 'Villa', 'Ampliación', 'Gran usuario','Residencial','Poblado comunal', 'Estación', 'Campamento', 'Zona naval']);
            $table->enum('zone',['urbana', 'rural', 'Semiurbana']);
            $table->foreignId('municipalities_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('communities');
    }
}
