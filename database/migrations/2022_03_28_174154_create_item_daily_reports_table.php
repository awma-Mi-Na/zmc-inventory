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
        Schema::create('item_daily_reports', function (Blueprint $table) {
            $table->id();
            $table->timestamp('entry_date');
            $table->integer('item_id');
            $table->integer('opening_balance');
            $table->integer('received')->default(0);
            $table->integer('issued')->default(0);
            $table->integer('total');
            $table->integer('closing_balance');
            $table->bigInteger('cumulative_stock');
            $table->softDeletes();
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
        Schema::dropIfExists('item_daily_reports');
    }
};
