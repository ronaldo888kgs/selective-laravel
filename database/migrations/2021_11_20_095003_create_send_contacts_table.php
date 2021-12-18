<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSendContactsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('send_contacts', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('address', 256)->nullable();
            $table->integer('type')->nullable();//0 - email, 1 - telegram, 2 - discord, 3 - twitter, 4 - slack , 5 - mobile number
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('send_contacts');
    }
}
