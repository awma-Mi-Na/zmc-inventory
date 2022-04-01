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
        Schema::create('oxygen_tank_reports', function (Blueprint $table) {
            $table->id();
            $table->timestamp('entry_date');
            $table->integer('item_id');
            $table->integer('full');
            $table->integer('empty');
            $table->integer('in_use');
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
        Schema::dropIfExists('oxygen_tank_reports');
    }
};
