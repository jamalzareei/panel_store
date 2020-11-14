<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CountriesTableSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		DB::table('countries')->delete();

		$jsonString = file_get_contents(config('shixeh.cdn_domain').'db/countries.json');

        $data = json_decode($jsonString, true);

        foreach($data as $d){
            \App\Models\Country::create($d);
        }
	}
}
