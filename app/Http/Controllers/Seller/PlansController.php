<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PlansController extends Controller
{
    //
    function pricing(Request $request)
    {
        # code...
        return view('seller.plans.pricing');
    }
}
