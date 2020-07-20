<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlertUserTables20200614 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            // $table->enum('type', ['customer', 'seller'])->after('password')->default('customer');
            $table->tinyInteger('type')->after('password')->default('1');
            // $table->string('stripe_connect_id')->after('stripe_customer_id')->nullable();
            $table->string('card_token')->after('stripe_customer_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            //
        });
    }
}
