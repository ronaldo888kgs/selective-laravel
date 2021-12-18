<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateErDatasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('er_datas', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('stock_name', 256)->nullable();
            $table->string('stock_price', 100)->nullable();
            $table->date('er_date')->nullable();
            $table->integer('er_type')->nullable();
            $table->string('price_before', 100)->nullable();
            $table->string('price_after', 100)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('er_datas');
    }
}
