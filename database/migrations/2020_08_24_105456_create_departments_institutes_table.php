<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDepartmentsInstitutesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('departments_institutes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('departments_id');
            $table->foreignId('institutes_id');
            $table->string('stamp')->nullable();
            $table->string('image')->nullable();
            $table->foreignId('addresses_id')->nullable();            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('departments_institutes');
    }
}
