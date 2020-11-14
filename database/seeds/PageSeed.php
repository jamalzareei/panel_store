<?php

use Illuminate\Database\Seeder;
use Josh\Faker\Faker;

class PageSeed extends Seeder
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

            \App\Models\Page::create([ //,
            // DB::table('pages')->insert([ //,
                'name' => Faker::fullname(),
                'path' => $faker->unique()->username,
                
            ]);

        }
    }
}
