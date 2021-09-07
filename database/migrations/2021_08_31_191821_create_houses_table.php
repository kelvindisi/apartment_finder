<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHousesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('houses', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("apartment_id");
            $table->integer("room_no");
            $table->integer("bedrooms");
            $table->integer("bathrooms");
            $table->enum("status", ["occupied", "vacant"])->default('vacant');
            $table->text("description");
            $table->unique(["apartment_id", "room_no"]);
            $table->foreign("apartment_id")->references("id")
                ->on("apartments")->onDelete("CASCADE");
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
        Schema::dropIfExists('houses');
    }
}
