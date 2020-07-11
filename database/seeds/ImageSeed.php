<?php

use Illuminate\Database\Seeder;
use Josh\Faker\Faker;

class ImageSeed extends Seeder
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

            DB::table('images')->insert([ //,
                'path' => 'uploads/'.rand(1,10).'.jpg',
                'imageable_id' => $i,
                'imageable_type' => 'App\User',
                
            ]);
        }
        
        for ($i = 1; $i < 100; $i++) {

            DB::table('images')->insert([ //,
                'path' => 'uploads/'.rand(1,10).'.jpg',
                'imageable_id' => $i,
                'imageable_type' => 'App\Models\Product',
                
            ]);
            for ($k = 1; $k < 10; $k++) {

                DB::table('images')->insert([ //,
                    'path' => 'uploads/'.$k.'.jpg',
                    'imageable_id' => $i,
                    'imageable_type' => 'App\Models\Product',
                    'default_use' => 'GALLERY'
                ]);
    
            }
        }
        
        for ($i = 1; $i < 100; $i++) {

            DB::table('images')->insert([ //,
                'path' => 'uploads/'.rand(1,10).'.jpg',
                'imageable_id' => $i,
                'imageable_type' => 'App\Models\Seller',
                
            ]);
            for ($k = 1; $k < 10; $k++) {

                DB::table('images')->insert([ //,
                    'path' => 'uploads/'.$k.'.jpg',
                    'imageable_id' => $i,
                    'imageable_type' => 'App\Models\Seller',
                    'default_use' => 'GALLERY'
                ]);
    
            }
        }
    }
}
