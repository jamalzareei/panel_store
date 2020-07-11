<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class UserSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        // $users = factory(App\User::class, 1000)->create();
        // factory(App\User::class, 50)->create()->each(function($u) {
        //     // $u->posts()->save(factory(App\Post::class)->make());
        // });

        \App\User::create([
            'uuid' => Str::random(12),
            'username' => '00989135368845',
            'email' => 'jzcs89@gmail.com',
            'phone' => '9135368845',
            'code_country' => '0098',
            'password' => bcrypt('1430548'),

        ]);

        $faker = Faker\Factory::create();
        for ($i = 0; $i < 100; $i++) {

            \App\User::create([
                // DB::table('users')->insert([ //,
                'uuid' => Str::random(12),
                'username' => $faker->unique()->username,
                'email' => $faker->unique()->email,
                'phone' => $faker->unique()->phoneNumber,
                'password' => bcrypt('secret'),

            ]);

        }
    }
}
