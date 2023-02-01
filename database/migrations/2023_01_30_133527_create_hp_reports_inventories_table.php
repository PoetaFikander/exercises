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
        Schema::create('hp_reports_inventories', function (Blueprint $table) {
            $table->id();
            $table->integer('report_id')->default('0'); // id raportu
            $table->integer('week_no')->default('0'); // nr tygodnia
            $table->integer('year')->default('0'); // rok
            $table->integer('article_id')->default('0'); // id artikla w Altum
            $table->decimal('quantity', $precision = 19, $scale = 4);
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
        Schema::dropIfExists('hp_reports_inventories');
    }
};
