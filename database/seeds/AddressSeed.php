<?php

use Illuminate\Database\Seeder;
use Josh\Faker\Faker;

class AddressSeed extends Seeder
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
            for ($j = 1; $j < 10; $j++) {

                DB::table('addresses')->insert([
                    'user_id' => $i,
                    'name' => Faker::fullname(),
                    'country_id' => 1,
                    'state_id' => 1,
                    'city_id' => 1,
                    'address' => Faker::address(),
                ]);

            }
        }
    }
}
