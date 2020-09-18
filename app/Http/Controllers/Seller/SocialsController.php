<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\Seller;
use App\Models\SellerSocial;
use App\Models\Social;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SocialsController extends Controller
{
    //
    public function socials(Request $request)
    {
        # code...
        $socials = Social::whereNull('deleted_at')->get();

        // $user = Auth::user();

        // $seller = Seller::where('user_id', $user->id)->with('socials')->first();
        // return $this->loadSocials();
        return view('seller.socials.add-social', [
            'title' => 'لیست شبکه های اجتماعی',
            'socials' => $socials,
            'listSocials' => $this->loadSocials(),
            'data' => '',
        ]);
    }

    public function loadSocials()
    {
        # code...
        
        $user = Auth::user();
        
        $seller = Seller::where('user_id', $user->id)->first();

        if(!$seller){
            return view('seller.seller-not-exists', [
                'title' => 'تکمیل اطلاعات فروشنده',
            ]);
        }
        $socials = SellerSocial::whereNull('deleted_at')
            ->where('seller_id', $seller->id)
            ->with('social')
            ->get();
        // return $socials;
        return view('seller.socials.list-socials', [
            'title' => 'لیست شبکه های اجتماعی',
            'seller' => $seller,
            'socials' => $socials,
            'data' => '',
        ]); 
    }
    
    public function socialsAddPost(Request $request)
    {
        # code...
        // return $request->all();

        $request->validate([
            'social_id' =>"required|exists:socials,id",
            'url' =>"required|url",
            'username' =>"required"
        ]);

        $user = Auth::user();

        $seller = Seller::where('user_id', $user->id)->with('socials')->first();

        if(!$user && !$seller){
            return [
                'status' => 'error',
                'title' => '',
                'message' => 'ابتدا اطلاعات فروشگاه خود را تکمیل نمایید.',
            ];
        }

        DB::table('seller_social')->insert([ //,
            'user_id' => $user->id, 
            'seller_id' => $seller->id, 
            'social_id' => $request->social_id, 
            'url' => $request->url, 
            'username' => $request->username,         
        ]);
        /*
        social_id: "2"
        url: "sdcdsc"
        username: "dsc"
        */
        return [
            'status' => 'success',
            'title' => '',
            'message' => 'با موفقیت ثبت گردید.',
            'dataLoad' => $this->loadSocials()->render(),
        ];

    }
    
    public function socialUpdate(Request $request)
    {
        # code...
    }
    
    public function socialDelete(Request $request, $id)
    {
        # code...
        $socialDelete = SellerSocial::where('id',$id)->first();
        if ($socialDelete) {
            $socialDelete->deleted_at = Carbon::now()->format('Y-m-d H:i:s');
            $socialDelete->save();
            return response()->json([
                'status' => 'success',
                'title' => '',
                'message' => 'با موفقیت حذف گردید.'
            ]);
        } else {
            return response()->json([
                'status' => 'error',
                'title' => '',
                'message' => 'دوباره تلاش نمایید.'
            ]);
        }
    }
}
