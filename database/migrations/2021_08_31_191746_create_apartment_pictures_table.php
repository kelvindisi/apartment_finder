<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateApartmentPicturesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('apartment_pictures', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("apartment_id");
            $table->string("picture_file");
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
        Schema::dropIfExists('apartment_pictures');
    }
}
