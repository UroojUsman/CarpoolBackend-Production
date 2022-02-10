<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRidersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('riders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained("users")->cascadeOnDelete();
            $table->foreignId('driver_id')->nullable()->constrained("drivers")->nullOnDelete();
            $table->string('R_source_Long');
            $table->string('R_source_Lat');
            $table->string('R_source_address');
            $table->string('R_dest_Long');
            $table->string('R_dest_Lat');
            $table->string('R_dest_address');
            $table->string('status')->default('Pending');
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
        Schema::dropIfExists('riders');
    }
}
