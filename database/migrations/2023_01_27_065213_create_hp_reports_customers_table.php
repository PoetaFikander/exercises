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
        Schema::create('hp_reports_customers', function (Blueprint $table) {
            $table->id();
            $table->integer('altum_id')->default('0'); // id artikla w Altum
            $table->string('code',50);
            $table->string('name',352);
            $table->string('tin',20);
            $table->tinyInteger('blocked_for_deletion')->default('0'); // 1 - nie można usuwać z tabeli
            $table->dateTime('created_at', $precision = 0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('hp_reports_customers');
    }
};
