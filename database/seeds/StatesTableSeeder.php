<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StatesTableSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		//
		DB::table('states')->delete();
		$jsonString = file_get_contents(config('shixeh.cdn_domain').'db/states.json');

        $data = json_decode($jsonString, true);

        foreach($data as $d){
            \App\Models\State::create($d);
        }
	}
}
