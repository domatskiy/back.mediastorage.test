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
            $table->unsignedInteger('storage_user_id')->comment('Пользователь');
            $table->string('file', 32)->comment('Файл');
            $table->string('description', 250)->nullable()->default(null)->comment('Описание');
            $table->timestamps();

            });

        Schema::table('media_storage_file', function($table){

            $table->index('storage_user_id');

            $table->foreign('storage_user_id')
                ->references('id')->on('media_storage_user')
                ->onDelete('cascade');

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
