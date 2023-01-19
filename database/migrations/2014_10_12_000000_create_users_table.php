<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
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
            $table->string('surname')->default(''); // nazwisko
            $table->string('phone')->default(''); // telefon
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->tinyInteger('is_active')->default('0'); // nieaktywny/aktywny
            // typ usera 1:admin, 2:user ...
            $table->unsignedBigInteger('type_id')->default('2');
            // oddział usera 1:Gdańsk, 2:Katowice ...
            $table->unsignedBigInteger('department_id')->default('1');
            $table->unsignedBigInteger('altum_id')->default('0'); // id usera w Altum
            $table->timestamps();
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
};
