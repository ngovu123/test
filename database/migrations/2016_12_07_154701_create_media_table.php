<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMediaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('media', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('title');
            $table->string('slug');
            $table->text('description');
            $table->string('file');
            $table->string('typeFile');
            $table->string('style');
            $table->string('platform');
            $table->string('render');
            $table->float('price');
            $table->text('tags');
            $table->integer('status');
            $table->integer('active');
            $table->integer('count_like');
            $table->integer('count_download');
            $table->integer('category_id');
            $table->integer('user_id');
            $table->timestamp('time_download');
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
        Schema::dropIfExists('media');
    }
}
