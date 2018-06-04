<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStorageFileTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('media_storage_file', function (Blueprint $table) {

            $table->engine = 'InnoDB';

            $table->increments('id');
            $table->string('user', 36)->comment('User');
            $table->string('file', 32)->comment('Файл');
            $table->string('ext', 4)->nullable()->default('')->comment('Расширение');
            $table->string('email', 50)->nullable()->default(null)->comment('Email');
            $table->string('description', 250)->nullable()->default(null)->comment('Описание');
            $table->timestamps();

            });

        Schema::table('media_storage_file', function($table){
            $table->index('user');
            });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('media_storage_file');
    }
}
