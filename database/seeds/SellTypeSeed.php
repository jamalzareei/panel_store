<?php

use Illuminate\Database\Seeder;

class SellTypeSeed extends Seeder
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
        DB::table('sell_types')->insert([ //,
            'name' => 'حضوری',
        ]);
        DB::table('sell_types')->insert([ //,
            'name' => 'اینترنتی از سایت شیکسه',
        ]);
        DB::table('sell_types')->insert([ //,
            'name' => 'اینترنتی از سایت (سایت، اینستاگرام، ) خودم',
        ]);
    }
}
