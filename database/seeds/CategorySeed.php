<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
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
        // DB::table('categories')->insert([ 'id'=>1, 'name' => 'پوشاک', 'slug' => 'پوشاک', 'parent_id' => 0, ]);
        // DB::table('categories')->insert([ 'id'=>2, 'name' => 'پوشاک', 'slug' => 'پوشاک', 'parent_id' => 0, ]);
        // DB::table('categories')->insert([ 'id'=>3, 'name' => 'پوشاک', 'slug' => 'پوشاک', 'parent_id' => 0, ]);
        // DB::table('categories')->insert([ 'id'=>4, 'name' => 'پوشاک', 'slug' => 'پوشاک', 'parent_id' => 0, ]);
        // DB::table('categories')->insert([ 'id'=>5, 'name' => 'پوشاک', 'slug' => 'پوشاک', 'parent_id' => 0, ]);
        // DB::table('categories')->insert([ 'id'=>6, 'name' => 'پوشاک', 'slug' => 'پوشاک', 'parent_id' => 0, ]);
        // DB::table('categories')->insert([ 'id'=>7, 'name' => 'پوشاک', 'slug' => 'پوشاک', 'parent_id' => 0, ]);
        // DB::table('categories')->insert([ 'id'=>8, 'name' => 'پوشاک', 'slug' => 'پوشاک', 'parent_id' => 0, ]);
        // DB::table('categories')->insert([ 'id'=>9, 'name' => 'پوشاک', 'slug' => 'پوشاک', 'parent_id' => 0, ]);
        // DB::table('categories')->insert([ 'id'=>10, 'name' => 'پوشاک', 'slug' => 'پوشاک', 'parent_id' => 0, ]);
        // DB::table('categories')->insert([ 'id'=>11, 'name' => 'پوشاک', 'slug' => 'پوشاک', 'parent_id' => 0, ]);
        // DB::table('categories')->insert([ 'id'=>12, 'name' => 'پوشاک', 'slug' => 'پوشاک', 'parent_id' => 0, ]);
        // DB::table('categories')->insert([ 'id'=>13, 'name' => 'پوشاک', 'slug' => 'پوشاک', 'parent_id' => 0, ]);
        // DB::table('categories')->insert([ 'id'=>14, 'name' => 'پوشاک', 'slug' => 'پوشاک', 'parent_id' => 0, ]);
        // DB::table('categories')->insert([ 'id'=>15, 'name' => 'پوشاک', 'slug' => 'پوشاک', 'parent_id' => 0, ]);
        // DB::table('categories')->insert([ 'id'=>16, 'name' => 'پوشاک', 'slug' => 'پوشاک', 'parent_id' => 0, ]);
        // DB::table('categories')->insert([ 'id'=>17, 'name' => 'پوشاک', 'slug' => 'پوشاک', 'parent_id' => 0, ]);

        $faker = \Faker\Factory::create();
        for ($i = 1; $i < 10; $i++) {

            DB::table('categories')->insert([ //,
                'name' => Faker::fullname(),
                'slug' => $faker->unique()->slug,
                'parent_id' => 0,
                'actived_at' => Carbon::now(),
                
            ]);

        }

        for ($i = 1; $i < 10; $i++) {

            DB::table('categories')->insert([ //,
                'name' => Faker::fullname(),
                'slug' => $faker->unique()->slug,
                'parent_id' => 1,
                'actived_at' => Carbon::now(),
                
            ]);

        }

        for ($i = 1; $i < 10; $i++) {

            DB::table('categories')->insert([ //,
                'name' => Faker::fullname(),
                'slug' => $faker->unique()->slug,
                'parent_id' => 10,
                'actived_at' => Carbon::now(),
                
            ]);

        }

        for ($i = 1; $i < 10; $i++) {

            DB::table('categories')->insert([ //,
                'name' => Faker::fullname(),
                'slug' => $faker->unique()->slug,
                'parent_id' => 20,
                'actived_at' => Carbon::now(),
                
            ]);

        }

    }
}
