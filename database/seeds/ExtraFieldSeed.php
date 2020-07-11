<?php

use Illuminate\Database\Seeder;
use Josh\Faker\Faker;

class ExtraFieldSeed extends Seeder
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
            for ($j = 1; $j < 20; $j++) {

                \App\Models\Property::create([ //,
                    'name' => Faker::fullname(),
                    'category_id' => $i,
                    
                ]);

            }
        }
    }
}
