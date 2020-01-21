<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJumbotronImageTranslationsTable extends Migration
{
    public function up()
    {
        Schema::create('jumbotron_image_translations', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('jumbotron_image_id')->unsigned();

            $table->string('title')->nullable();
            $table->text('body')->nullable();
            $table->string('button_text')->nullable();

            $table->string('locale')->index();
            $table->unique(['jumbotron_image_id', 'locale']);
            $table->foreign('jumbotron_image_id')->references('id')->on('jumbotron_images')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('jumbotron_image_translations');
    }
}
