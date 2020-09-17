<?php

use Illuminate\Database\Seeder;

class SosialSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        // $faker = Faker\Factory::create();
        $data = [
            [
                'icon' => '<i class="fab fa-facebook"></i>',
                'name' => 'فیس بوک',
                'website' => 'https://facebook.com/',
            ],
            [
                'icon' => '<i class="fab fa-instagram"></i>',
                'name' => 'اینستاگرام',
                'website' => 'https://www.instagram.com/',
            ],
            [
                'icon' => '<i class="fab fa-telegram"></i>',
                'name' => 'تلگرام',
                'website' => 'https://telegram.org/',
            ],
            [
                'icon' => '<i class="fab fa-twitter"></i>',
                'name' => 'توییتر',
                'website' => 'https://twitter.com/',
            ],
            [
                'icon' => '<i class="fab fa-linkedin"></i>',
                'name' => 'لینکدین',
                'website' => 'https://www.linkedin.com/',
            ],
            [
                'icon' => '<i class="fab fa-pinterest"></i>',
                'name' => 'پینترست',
                'website' => 'https://www.pinterest.com/',
            ],
        ];

        foreach ($data as $key => $value) {
            # code...
            DB::table('socials')->insert([ //,
                'icon' => $value['icon'], 
                'name' => $value['name'], 
                'website'  => $value['website']               
            ]);
        }
        // for ($i = 0; $i < 100; $i++) {

        //     DB::table('users')->insert([ //,
        //         'uuid' => Str::random(12),
        //         'username' => $faker->username,
        //         'email' => $faker->unique()->email,
        //         'phone' => $faker->phoneNumber,
        //         'password' => bcrypt('secret'),
                
        //     ]);

        // }
    }
}
