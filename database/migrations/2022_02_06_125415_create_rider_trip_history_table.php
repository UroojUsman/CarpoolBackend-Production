<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRiderTripHistoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rider_trip_history', function (Blueprint $table) {
            $table->id();
            $table->foreignId('rider_user_id')->constrained("users")->cascadeOnDelete();
            $table->string('driver_name');
            $table->string('source_address');
            $table->string('dest_address');
            $table->dateTime('start_datetime');
            $table->dateTime('end_datetime');
            $table->string('fare');
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
        Schema::dropIfExists('rider_trip_history');
    }
}
