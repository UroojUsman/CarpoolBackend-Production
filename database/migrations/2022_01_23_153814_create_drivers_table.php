<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDriversTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('drivers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained("users")->cascadeOnDelete();
            // $table->date('start_date');
            // $table->time('start_time');
            $table->dateTime('start_datetime');
            $table->dateTime('end_datetime')->nullable();
            $table->string('D_source_Long');
            $table->string('D_source_Lat');
            $table->string('D_source_address');
            $table->string('D_dest_Long');
            $table->string('D_dest_Lat');
            $table->string('D_dest_address');
            $table->integer('total_fare');
            $table->integer('available_seats')->default(3);
            $table->integer('booked_seats')->default(0);
            $table->string('status')->default('Offered');
            // $table->bigInteger('rider_1')->nullable();
            // $table->bigInteger('rider_2')->nullable();
            // $table->bigInteger('rider_3')->nullable();
            // $table->foreignId('rider_1')->nullable()->constrained("riders")->nullOnDelete();
            // $table->foreignId('rider_2')->nullable()->constrained("riders")->nullOnDelete();
            // $table->foreignId('rider_3')->nullable()->constrained("riders")->nullOnDelete();

            // $table->foreign('rider_1')->references('id')->on('riders')->onDelete('set null');
            // $table->foreign('rider_2')->references('id')->on('riders')->onDelete('set null');
            // $table->foreign('rider_3')->references('id')->on('riders')->onDelete('set null');
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
        Schema::dropIfExists('drivers');
    }
}
