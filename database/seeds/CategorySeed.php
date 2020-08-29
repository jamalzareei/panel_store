<?php

use Illuminate\Database\Seeder;
use Josh\Faker\Faker;

class CategorySeed extends Seeder
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
        for ($i = 1; $i < 10; $i++) {

            DB::table('categories')->insert([ //,
                'name' => Faker::fullname(),
                'slug' => $faker->unique()->slug,
                'parent_id' => 0,
                
            ]);

            for ($k = 1; $k < 10; $k++) {

                DB::table('categories')->insert([ //,
                    'name' => Faker::fullname(),
                    'slug' => $faker->unique()->slug,
                    'parent_id' => $i,
                    
                ]);

                for ($j = 1; $j < 10; $j++) {

                    DB::table('categories')->insert([ //,
                        'name' => Faker::fullname(),
                        'slug' => $faker->unique()->slug,
                        'parent_id' => $k,
                        
                    ]);
    
                }
            }
        }

    }
}
