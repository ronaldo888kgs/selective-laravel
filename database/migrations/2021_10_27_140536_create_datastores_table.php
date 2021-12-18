<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDatastoresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('datastores', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('email', 100)->nullable();
            $table->string('discord', 100)->nullable();
            $table->string('twitter', 100)->nullable();
            $table->string('slack', 100)->nullable();
            $table->string('telegram', 100)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('datastores');
    }
}
