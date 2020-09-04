<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SellersController extends Controller
{
    //
    public function getUserData(Request $request)
    {
        # code...
        $user = Auth::user();

        return $user;
    }
}
