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
        Schema::create('hp_reports_articles', function (Blueprint $table) {
            $table->id();
            $table->integer('altum_id')->default('0'); // id artikla w Altum
            $table->string('code',50);
            $table->string('name',256);
            $table->string('catalogue_number',100)->default('');
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
        Schema::dropIfExists('hp_reports_articles');
    }
};
