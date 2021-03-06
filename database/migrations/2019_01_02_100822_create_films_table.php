<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFilmsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('films', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->longText('description');
            $table->string('slug');
            $table->date('release_date');
            $table->unsignedInteger('rating');
            $table->float('ticket_price', 8, 2);
            $table->string('country');
            $table->string('genre');
            //$table->string('film_photo')->nullable();
            $table->string('film_photo')->nullable()->default('no-image.svg');
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
        Schema::dropIfExists('films');
    }
}
