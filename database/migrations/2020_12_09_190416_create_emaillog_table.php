<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmaillogTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('emaillog', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('sender');
            $table->string('recipient');
            $table->string('status');
            $table->string('descriptionStatus');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('emaillog');
    }
}
