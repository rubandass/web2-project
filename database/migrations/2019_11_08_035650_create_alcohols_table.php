<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAlcoholsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('alcohols', function (Blueprint $table) {
            $table->increments('id');
            $table->date('date');
            $table->integer('standard_drink');
            $table->double('calories')->nullable();
            $table->double('kj')->nullable();
            $table->integer('item_id')->unsigned();
            $table->foreign('item_id')->references('id')->on('items');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('alcohols');
    }
}
