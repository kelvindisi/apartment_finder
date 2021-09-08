<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBookingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bookings', function (Blueprint $table) {
            $confirmed = ["pending", "rejected", "confirmed"];
            $table->id();
            $table->unsignedBigInteger("house_id");
            $table->unsignedBigInteger("user_id");
            $table->date("scheduled_date")->nullable();
            $table->enum("confirmed", $confirmed)->default("pending");
            $table->foreign("house_id")->references("id")
                ->on("houses")->onDelete("CASCADE");
            $table->foreign("user_id")->references("id")
                ->on("users")->onDelete("CASCADE");
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
        Schema::dropIfExists('bookings');
    }
}
