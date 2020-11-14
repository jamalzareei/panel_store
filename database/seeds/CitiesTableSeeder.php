<?php

use Illuminate\Database\Seeder;
use Josh\Faker\Faker;

class CitiesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * the cities is large, we need to break it in parts
     * @return void
     */
    public function run()
    {
        //
        DB::table('cities')->delete();

        $jsonString = file_get_contents(config('shixeh.cdn_domain').'db/cities.json');

        $data = json_decode($jsonString, true);

        foreach($data as $d){
            \App\Models\City::create($d);
        }
    }
}
