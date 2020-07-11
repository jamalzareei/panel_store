<?php

use Illuminate\Database\Seeder;
use Josh\Faker\Faker;

class ProductSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        // factory(App\Models\Product::class, 100)->create();
        $faker = \Faker\Factory::create();
        for ($i = 1; $i < 100; $i++) {
            for ($k = 1; $k < 20; $k++) {

                \App\Models\Product::create([ //,
                // DB::table('products')->insert([ //,
                    'name' => Faker::fullname(),
                    'code' => $faker->unique()->ean8,
                    'slug' => $faker->unique()->slug,
                    'user_id' => $i,
                    'seller_id' => $i,
                    
                ]);

            }
        }
        for ($i = 1; $i < 100; $i++) {
            for ($k = 1; $k < 3; $k++) {
                DB::table('category_product')->insert([ //,
                    'category_id' => rand(1,100),
                    'product_id' => $i,
                ]);
            }
            // for ($k = 1; $k < 30; $k++) {
            //     DB::table('extra_feild_product')->insert([ //,
            //         'extra_feild_id' => rand(1,100),
            //         'product_id' => $i,
            //         'value' => Faker::lastname(),
            //     ]);
            // }
        }

    }
}
