<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFieldDataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('field_data', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->date('posted_date');
            $table->date('buy_date');
            $table->string('symbol', 100)->nullable();
            $table->string('qty', 100)->nullable();
            $table->date('expiration_date', 100);
            $table->date('sell_date', 100);
            $table->string('call_put_strategy', 100)->nullable();
            $table->string('strike', 100)->nullable();
            $table->string('strike_price', 100)->nullable();
            $table->string('in_price', 100)->nullable();
            $table->string('out_price', 100)->nullable();
            $table->string('net_difference', 100)->nullable();
            $table->integer('high_price')->nullable();
            $table->string('percentage', 100)->nullable();
            $table->integer('status')->nullable();
            $table->integer('category')->nullable();
            $table->integer('activated')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('field_data');
    }
}

