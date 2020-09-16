<?php

use Illuminate\Database\Seeder;
use Josh\Faker\Faker;

class CurrencySeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $faker = \Faker\Factory::create();
        DB::table('currencies')->insert([ //,
            'name' => 'ریال',
            'slug' => 'ریال',
            'price_one_unit' => 1,
            
        ]);
        DB::table('currencies')->insert([ //,
            'name' => 'تومان',
            'slug' => 'تومان',
            'price_one_unit' => 10,
            
        ]);
    }
}
