<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRestaurantMenuOptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('restaurant_menu_options', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('restaurant_menu_id')->unsigned();
            $table->foreign('restaurant_menu_id')->on('restaurant_menu')->references('id')->onDelete('cascade');
            $table->string('name');
            $table->double('price', 10, 2);
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
        Schema::dropIfExists('restaurant_menu_options');
    }
}
