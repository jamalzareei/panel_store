<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Country;
use App\Models\Currency;
use App\Models\Message;
use App\Models\PayType;
use App\Models\Seller;
use App\Models\SellerSocial;
use App\Models\SellType;
use App\Models\State;
use App\Models\Ticket;
use App\Models\Website;
use App\Models\Websiteable;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SellersController extends Controller
{
    //
    public function sellers(Request $request, $type = null)
    {
        # code...
        $sellers = Seller::whereNull('deleted_at')
        ->when(($type == 'wait-active-admin'), function($query){
            $query->whereNull('admin_actived_at')->whereNotNull('actived_at');
        })
        ->when(($type == 'not-complete-data'), function($query){
            $query->whereNull('actived_at')->whereNull('admin_actived_at');
        })
        ->when(($type == 'comlpete-and-active-admin'), function($query){
            $query->whereNotNull('actived_at')->whereNotNull('admin_actived_at');
        })
        ->with(['city', 'user'])
        ->get();

        // return $sellers;

        return view('admin.sellers.list-sellers', [
            'title' => ' فروشندگان '. $type,
            'sellers' => $sellers,
        ]);
    }

    public function sellerShow(Request $request, $slug)
    {
        # code...
        // $seller = Seller::where('slug', $slug)->first();
        
        $seller = Seller::where('slug', $slug)
            ->with([
                'country', 'state', 'city',
                'image' => function ($query) {
                    // $query->select('path', 'id', 'imageable_id')->where('default_use', 'MAIN')->orderBy('id', 'desc')->first();
                },
                'branches' => function ($query) {
                    $query->with(['country', 'state', 'city'])->whereNull('deleted_at');
                },
                'user',
                'websites'
            ])
            ->first();

        $setting = [];
        if($seller){

            $setting = [
                'pay' => json_decode($seller->pay_type_id),
                'sell' => json_decode($seller->sell_type_id)
            ];
        }
        // $setting->pay = json_decode($seller->pay_type_id);
        // $setting->sell = json_decode($seller->sell_type_id);

        $currencies = Currency::all();
        $payTypes = PayType::all();
        $sellTypes = SellType::all();
        $states = State::with('country')
            ->whereHas('country', function($query) {
                $query->where('name', 'Iran');
            })
            ->with([
                'postsetting' =>  function($queryPost) use($seller){
                    $queryPost->where('seller_id', $seller->id);
                }
            ])
            ->get();
            
        $countries = Country::select('id','native as name')->where('id', 103)->get();

        $socials = SellerSocial::whereNull('deleted_at')
            ->where('seller_id', $seller->id)
            ->with('social')
            ->get();
        // return $seller;

        $websites = Website::all();
        return view('admin.sellers.seller', [
            'title' => $seller->name,
            'seller' => $seller,
            'countries' => $countries,
            'setting' => $setting,
            'currencies' => $currencies,
            'payTypes' => $payTypes,
            'sellTypes' => $sellTypes,
            'states' => $states,
            'socials' => $socials,
            'websites' => $websites,
        ]); 
    }

    public function sellerActive(Request $request, $id)
    {
        # code...
        // return $request->all();
        // active_admin: "on"
        // message-seller: ""
        // seller_id: "100"
        // tell_at: "on"

        $request->validate([
            'seller_id' => 'required|exists:sellers,id',
            'message_seller' => 'required'
        ]);

        $seller = Seller::where('id', $request->seller_id)->first();

        $seller->admin_actived_id = $request->admin_actived_at ? Auth::id() : null;
        $seller->admin_actived_at = $request->admin_actived_at ? Carbon::now() : null;
        $seller->call_admin_at = $request->call_admin_at ? Carbon::now() : null;
        
        if(!$request->admin_actived_at){
            $seller->actived_at = null;
        }


        if($request->websites){
            
            $seller->websites()->sync($request->websites);
        }

        $seller->save();
        Message::create([
            'user_sender_id'        => Auth::id(),
            'user_receiver_id'      => $seller->user_id,
            'user_receiver_type'    => 'seller',
            'status_id'             => '0',
            'title'                 => 'فعال سازی پنل کاربری',
            'message'               => $request->message_seller,
        ]);
        
        return response()->json([
            'status' => 'success',
            'title' => '',
            'message' => 'با موفقیت ثبت گردید.',
        ], 200);

    }
}
