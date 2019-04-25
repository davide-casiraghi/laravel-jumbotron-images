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
            $table->string('image_name')->nullable();
            $table->string('button_url')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('jumbotron_images');
    }
}
