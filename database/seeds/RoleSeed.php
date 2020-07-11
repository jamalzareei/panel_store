<?php

use Illuminate\Database\Seeder;

class RoleSeed extends Seeder
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
        \App\Models\Role::create([
            'slug' => 'ADMIN',
            'code' => 'A',
            'name' => 'admin',
        ]);
        \App\Models\Role::create([
            'slug' => 'SELLER',
            'code' => 'B',
            'name' => 'seller',
        ]);
        \App\Models\Role::create([
            'slug' => 'USER',
            'code' => 'A',
            'name' => 'user',
        ]);

        
        DB::table('role_user')->insert([ //,
            'user_id' => 1,
            'role_id' => 1,
        ]);
        DB::table('role_user')->insert([ //,
            'user_id' => 1,
            'role_id' => 2,
        ]);
        DB::table('role_user')->insert([ //,
            'user_id' => 1,
            'role_id' => 3,
        ]);
    }
}
