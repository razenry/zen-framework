<?php

use Database\Schema;
use Database\Blueprint;

class PostImagesTable
{
    public function up()
    {
        Schema::create('post_images', function (Blueprint $table) {
            $table->id();
            $table->foreignId('post_id')->constrained()->cascadeOnDelete();
            $table->string('image_path');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('post_images');
    }
}
