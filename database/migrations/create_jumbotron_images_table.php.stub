<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateJumbotronImagesTable extends Migration
{
    public function up()
    {
        Schema::create('jumbotron_images', function (Blueprint $table) {
            $table->increments('id');
            $table->string('image_file_name')->nullable();
            $table->string('button_url')->nullable();
            $table->string('button_color')->nullable();
            $table->string('jumbotron_height')->nullable();
            $table->string('cover_opacity')->nullable();
            $table->string('background_color')->nullable();
            $table->boolean('scroll_down_arrow')->default(0)->nullable();
            $table->boolean('parallax')->default(0)->nullable();
            $table->boolean('white_moon')->default(0)->nullable();
            $table->string('text_width')->nullable();
            $table->string('text_vertical_alignment')->nullable();
            $table->string('text_horizontal_alignment')->nullable();
            $table->integer('text_shadow')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('jumbotron_images');
    }
}
