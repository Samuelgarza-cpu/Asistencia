<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRequestsPersonalDataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('requests_personal_data', function (Blueprint $table) {
            $table->id();
            $table->foreignId('requests_id')->nullable();;
            $table->foreignId('personalData_id')->nullable();;
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
        Schema::dropIfExists('requests_personal_data');
    }
}
