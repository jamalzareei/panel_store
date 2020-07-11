<?php

use Illuminate\Database\Seeder;
use Josh\Faker\Faker;

class SupplierSeed extends Seeder
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

            \App\Models\Producer::create([ //,
            // DB::table('sellers')->insert([ //,
                'name' => Faker::firstname(),
                'slug' => $faker->unique()->slug,
                'user_id' => $i,
                'manager' => Faker::lastname(),
                'phones' => Faker::mobile(),
                'country_id' => 1,
                'state_id' => 1,
                'city_id' => 1,
                'address' => Faker::address(),
                
            ]);

        }
    }
}
