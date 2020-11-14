<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\Country;
use App\Models\State;
use Illuminate\Http\Request;

class LocationController extends Controller
{
    //
    public function getCountries(Request $request)
    {
        # code...
        $countries = Country::select('id','native as name')->where('id', 103)->get();

        $str = '';
        foreach ($countries as $key => $country) {
            # code...
            $str .= '<option value="'.$country->id.'">'.$country->name.'</option>';
        }
        return $str;
    }

    public function getStates(Request $request, $country_id = null)
    {
        # code...
        $country_id = ($request->country_id) ? $request->country_id : $country_id;
        $states = State::whereNotNull('id')
        ->when($country_id, function($query) use ($country_id) {
            $query->where('country_id', $country_id);
        })
        ->get();

        // return $country_id;
        
        $str = '<option value="">استان</option>';
        foreach ($states as $key => $state) {
            # code...
            $str .= '<option value="'.$state->id.'">'.$state->name.'</option>';
        }
        return $str;
    }

    public function getCities(Request $request, $state_id = null)
    {
        # code...
        $state_id = ($request->state_id) ? $request->state_id : $state_id;
        $cities = City::whereNotNull('id')
        ->when($state_id, function($query) use ($state_id) {
            $query->where('state_id', $state_id);
        })
        ->get();

        // return $cities;
        
        $str = '<option value="">شهر</option>';
        foreach ($cities as $key => $city) {
            # code...
            $str .= '<option value="'.$city->id.'">'.$city->name.'</option>';
        }
        return $str;
    }
}
