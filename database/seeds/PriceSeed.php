<?php

use Illuminate\Database\Seeder;
use Josh\Faker\Faker;

class PriceSeed extends Seeder
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
        for ($i = 1; $i < 100; $i++) {

            DB::table('prices')->insert([ //,
                'user_id' => $i,
                'product_id' => $i,
                'seller_id' => $i,
                'price' => rand(10000,1000000),
                
            ]);

        }
        for ($i = 1; $i < 100; $i++) {

            DB::table('prices')->insert([ //,
                'user_id' => $i,
                'product_id' => $i,
                'seller_id' => $i,
                'price' => rand(10000,1000000),
                
            ]);

        }
    }
}
