<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Seller;
use App\Models\Ticket;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    //
    public function index(Request $request)
    {
        $user = auth()->user();

        $seller = Seller::where('user_id', $user->id)->with(['image'])->withCount(['products','branches'])->first();

        $tickets = Ticket::where('user_id', $user->id)->take(7)->get();
        $products = Product::where('user_id', $user->id)->whereNull('deleted_at')->take(7)->get();
        // return $products;

        return view('seller.dashboard',[
            'title' => 'داشبورد فروشندگان',
            'seller' => $seller,
            'tickets' => $tickets,
            'products' => $products
        ]);
    }
}
