<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
class CreateFieldsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fields', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->date('posted_date');
            $table->date('buy_date');
            $table->string('symbol', 100);
            $table->string('qty', 100);
            $table->date('expiration_date', 100);
            $table->string('call_put_strategy', 100);
            $table->string('strike', 100);
            $table->string('strike_price', 100);
            $table->string('in_price', 100);
            $table->string('out_price', 100);
            $table->string('net_difference', 100);
            $table->string('percentage', 100);
            $table->string('status');
            $table->integer('category');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('fields');
    }
}
