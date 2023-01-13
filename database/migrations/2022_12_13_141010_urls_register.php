<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UrlsRegister extends Migration
{
    public function up()
    {
        Schema::create('images_register', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('foreign_id')->nullable(false);
            $table->tinyInteger('status')->nullable(false)->default(\App\Models\ImagesRegister::STATUS_AWAIT);
            $table->string('url', 1024)->nullable(true);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('images_register');
    }
}
