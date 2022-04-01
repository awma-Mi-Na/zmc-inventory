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
        Schema::create('bed_occupancy_reports', function (Blueprint $table) {
            $table->id();
            $table->integer('item_id');
            $table->timestamp('entry_date');
            $table->integer('total');
            $table->integer('patients');
            $table->integer('attendants');
            $table->integer('positive_attendants');
            $table->integer('empty');
            $table->integer('on_oxygen');
            $table->integer('on_ventilator_invasive');
            $table->integer('on_ventilator_niv');
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
        Schema::dropIfExists('bed_occupancy_reports');
    }
};
