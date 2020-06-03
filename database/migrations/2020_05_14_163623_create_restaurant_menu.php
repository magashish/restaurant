<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRestaurantMenu extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */

    public function up()
    {
        Schema::create('restaurant_menu', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('dishname');
            $table->bigInteger('restaurant_id')->unsigned()->index();
            $table->bigInteger('category_id')->unsigned();
            $table->foreign('category_id')->on('categories')->references('id')->onDelete('cascade');
			$table->string('image');
			$table->string('status');
			$table->decimal('price', 5, 2);
            $table->text('itemoption');
            $table->timestamps();
			$table->foreign('restaurant_id')->references('id')->on('restaurants')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('restaurant_menu');
    }
}
