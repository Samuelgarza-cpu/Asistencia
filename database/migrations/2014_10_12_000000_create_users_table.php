<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('password');
            $table->string('email',100)->nullable();
            $table->string('signature')->nullable();
            $table->boolean('active')->default(true);
            $table->string('owner');
            $table->rememberToken();
            $table->string('token')->nullable();
            $table->string('api_token')->default(Str::random(50));        
            $table->timestamps();
            $table->foreignId('roles_id');
            $table->foreignId('departments_institutes_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
