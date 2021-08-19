<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRPDDisabilitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('RPD_disabilities', function (Blueprint $table) {
            $table->id();
            $table->foreignId('disability_id');
            $table->foreignId('disabilitycategories_id');
            $table->string('requestsPersonalData_id');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('RPD_disabilities');
    }
}
