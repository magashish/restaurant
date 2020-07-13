<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddAddressToRestaurants extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('restaurants', function (Blueprint $table) {
            $table->string('addr1')->after('description');
			$table->string('addr2')->after('description')->nullable();
			$table->string('city')->after('description');
			$table->string('state')->after('description');
			$table->string('postcode')->after('description');
			$table->string('country')->after('description');
            $table->string('phone')->after('description');
            $table->string('isfeatured')->after('description');
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
            $table->dropColumn('addr1');
			$table->dropColumn('addr2');
			$table->dropColumn('city');
			$table->dropColumn('state');
			$table->dropColumn('postcode');
			$table->dropColumn('country');
            $table->dropColumn('phone');
            $table->dropColumn('isfeatured');
        });
    }
}
