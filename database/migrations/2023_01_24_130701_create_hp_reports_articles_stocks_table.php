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
        Schema::create('hp_reports_articles_stocks', function (Blueprint $table) {
            $table->id();
            $table->integer('readout_id')->default('0'); // id odczytu stoków
            $table->integer('article_id')->default('0'); // id artikla w Altum
            $table->integer('warehouse_id')->default('0');
            $table->decimal('quantity', $precision = 19, $scale = 4);
            $table->decimal('reservations', $precision = 19, $scale = 4);
            $table->decimal('orders', $precision = 19, $scale = 4);
            $table->decimal('purchase_value', $precision = 19, $scale = 4);
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
        Schema::dropIfExists('hp_reports_articles_stocks');
    }
};
