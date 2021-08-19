<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('requests', function (Blueprint $table) {
            $table->id();
            $table->string('folio');
            $table->enum('type', ['','ts','responsiva','foliado'])->nullable();
            $table->text('description')->nullable();
            $table->string('petitioner')->nullable();
            $table->string('image')->nullable();
            $table->timestamps();
            $table->foreignId('users_id');
            $table->foreignId('usersAuth_id');
            $table->foreignId('categories_id')->nullable();;
            $table->foreignId('supports_id')->nullable();;
            $table->foreignId('status_id');
            $table->string('curpPetitioner')->nullable();
            $table->boolean('beneficiary')->default(false);
            $table->string('date')->nullable();
            $table->foreignId('departments_institutes_id')->nullable();
            $table->string('area', 5)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('requests');
    }
}
