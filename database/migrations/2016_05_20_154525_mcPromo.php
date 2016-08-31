<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class McPromo extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mcMessages', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('vk_id')->unique();
            $table->integer('from_id');
            $table->integer('date');
            $table->text('text');
            $table->timestamps();
        });

        Schema::create( 'mcConfig', function ( Blueprint $table ) {
            $table->increments('id');
            $table->string('vk_client_id');
            $table->string('vk_client_secret');
            $table->string('vk_token');
            $table->integer('scan_depth');
            $table->integer('scan_interval');

        });

        Schema::create( 'mcKeywords', function ( Blueprint $table ) {
            $table->increments('id');
            $table->string();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('messages');
    }
}
