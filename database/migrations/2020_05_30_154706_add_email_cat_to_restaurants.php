<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddEmailCatToRestaurants extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('restaurants', function (Blueprint $table) {
             $table->text('categories')->after('isfeatured');
			 $table->string('email')->after('isfeatured');
             $table->string('gmap')->after('isfeatured');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('restaurants', function (Blueprint $table) {
             $table->dropColumn('categories');
			 $table->dropColumn('email');
			 $table->dropColumn('gmap');
        });
    }
}
