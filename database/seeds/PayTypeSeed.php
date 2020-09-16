<?php

use Illuminate\Database\Seeder;

class PayTypeSeed extends Seeder
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
        DB::table('pay_types')->insert([ //,
            'name' => 'کارت به کارت',
        ]);
        DB::table('pay_types')->insert([ //,
            'name' => 'پرداخت درب منزل',
        ]);
        DB::table('pay_types')->insert([ //,
            'name' => 'پرداخت اینترنتی (درگاه اینترنتی)',
        ]);
    }
}
