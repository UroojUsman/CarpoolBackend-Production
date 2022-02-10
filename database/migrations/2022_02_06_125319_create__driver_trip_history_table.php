<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDriverTripHistoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('_driver_trip_history', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained("users")->cascadeOnDelete();
            // $table->foreignId('driver_user_id')->constrained("users")->nullOnDelete();
            $table->string('source_address');
            $table->string('dest_address');
            $table->dateTime('start_datetime');
            $table->dateTime('end_datetime');
            $table->string('fare');
            $table->string('total_passengers');
            $table->string('status');

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
        Schema::dropIfExists('_driver_trip_history');
    }
}
