<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TaxTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $state = array('93501' => 'California', '93504' => 'California', '90001' => 'Los Angeles');
        foreach ($state as $key => $value) {

            $randomFloat = rand(2, 10) / 10;
            DB::table('taxes')->insert([
                'tax' => $randomFloat,
                'city' => $value,
                'zip' => $key,
            ]);
        }
    }
}
