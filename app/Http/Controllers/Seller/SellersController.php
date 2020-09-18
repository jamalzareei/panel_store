<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\Country;
use App\Models\Currency;
use App\Models\Image;
use App\Models\PayType;
use App\Models\PostSettings;
use App\Models\Seller;
use App\Models\SellerBranch;
use App\Models\SellType;
use App\Models\State;
use App\Services\UploadService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SellersController extends Controller
{
    //
    public function sellerDataGet(Request $request)
    {
        # code...
        $user = Auth::user();
        // $seller = $user->seller->with('image');

        $seller = Seller::where('user_id', $user->id)
            ->with(['country', 'state', 'city'])
            ->with(['image' => function ($query) {
                // $query->select('path', 'id', 'imageable_id')->where('default_use', 'MAIN')->orderBy('id', 'desc')->first();
            }])
            ->first();
            
        $countries = Country::all();

        // return $seller;

        return view('seller.info.edit-seller', [
            'title' => 'ویرایش اطلاعات فروشگاه',
            'seller' => $seller,
            'countries' => $countries,
        ]);
    }

    public function sellerDataPost(Request $request)
    {
        # code...
        // return $request->all();
        $request->validate([
            'city_id' => 'required|exists:cities,id',
            'country_id' => 'required|exists:countries,id',
            'state_id' => 'required|exists:states,id',
            
            'website' => 'nullable|url',
            'name' => 'required|string',
            'manager' => 'required|string',
            'image_file' => 'nullable|string',
        ]);
        
        $user = Auth::user();
        
        $seller = $user->seller;

        $seller = Seller::where('user_id', $user->id)->first();
        $newSeller = false;
        if(!$seller){
            $newSeller = true;
            $seller = new Seller();
        }
        $seller->user_id = $user->id;
        $seller->city_id = $request->city_id;
        $seller->country_id = $request->country_id;
        $seller->details = $request->details;
        $seller->head = $request->head;
        
        $seller->website = $request->website;
        $seller->manager = $request->manager;
        $seller->meta_description = $request->meta_description;
        $seller->meta_keywords = $request->meta_keywords;
        $seller->name = $request->name;
        $seller->state_id = $request->state_id;
        $seller->title = $request->title;

        $seller->save();

        if ($request->image_file) {
            $path_image = UploadService::convertBase64toPng('uploads/sellers/logo', $request->image_file);
            Image::insert([ //,
                'path' => $path_image,
                'imageable_id' => $seller->id,
                'imageable_type' => 'App\Models\Seller',
                'user_id' => $user->id
            ]);
        }

        
        return [
            'status' => 'success',
            'title' => '',
            'message' => 'با موفقیت ثبت گردید.',
            'data' => $seller,
            'autoRedirect' => ($newSeller) ? route('seller.data.get') : null
        ];
    }

    public function setting(Request $request)
    {
        # code...
        $user = Auth::user();

        $seller = Seller::where('user_id', $user->id)->first();
        $setting = [];
        if($seller){

            $setting = [
                'pay' => json_decode($seller->pay_type_id),
                'sell' => json_decode($seller->sell_type_id)
            ];
        }
        if(!$seller){
            return view('seller.seller-not-exists', [
                'title' => 'تکمیل اطلاعات فروشنده',
            ]);
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
            ->with(['postsetting' =>  function($queryPost) use($seller){
                $queryPost->where('seller_id', $seller->id);
            }])
            ->get();

        // $postSetting = PostSettings::where('seller_id', $seller->id)->get();
        // return $states[0]->postsetting;

        return view('seller.info.setting',[
            'title' => 'تنظیمات فروشگاه',
            'setting' => $setting,
            'currencies' => $currencies,
            'payTypes' => $payTypes,
            'sellTypes' => $sellTypes,
            'states' => $states,
        ]);
    }

    public function settingPost(Request $request)
    {
        # code...
        // return json_encode($request->pay);//$request->pay;//
        // return $request->all();

        $user = Auth::user();
        // $seller = $user->seller->with('image');

        $seller = Seller::where('user_id', $user->id)->first();

        $seller->pay_type_id = json_encode($request->pay);
        $seller->sell_type_id = json_encode($request->sell);

        $seller->save();

        return [
            'status' => 'success',
            'title' => '',
            'message' => 'با موفقیت ثبت گردید.',
            'data' => $seller,
        ];
    }

    public function settingShipPost(Request $request)
    {
        # code...
        // return $request->all();
        
        $user = Auth::user();

        $seller = Seller::where('user_id', $user->id)->first();
        if(!$user || !$seller){
            if(!$seller){
                return view('seller.seller-not-exists', [
                    'title' => 'تکمیل اطلاعات فروشنده',
                ]);
            }
        }

        foreach ($request->state_id as $key => $state) {
            # code...
            if(
                $request->state_id[$key] && 
                $request->country_id[$key] && 
                $request->shipping_cost[$key] && 
                $request->currency_id[$key] &&
                $request->shipping_time[$key] &&
                $request->unit_of_time[$key]
                ){

                PostSettings::updateOrCreate(
                    [
                        'user_id' => $user->id,
                        'seller_id' => $seller->id,
                        'state_id' => $request->state_id[$key],
                        'country_id' => $request->country_id[$key],
                    ],
                    [
                        'country_id'        => $request->country_id[$key],
                        'state_id'          => $request->state_id[$key],
                        'city_id'           => $request->city_id[$key],
                        'shipping_cost'     => $request->shipping_cost[$key],
                        'currency_id'       => $request->currency_id[$key],
                        'shipping_time'     => $request->shipping_time[$key],
                        'unit_of_time'      => $request->unit_of_time[$key],
                    ]
                );
            }
        }

        return response()->json([
            [
                'status' => 'success',
                'title' => '',
                'message' => 'با موفقیت ثبت گردید.',
            ]
        ], 200);
        // return [
        //     'status' => 'success',
        //     'title' => '',
        //     'message' => 'با موفقیت ثبت گردید.',
        // ];
    }

    public function sellerSendAdmin(Request $request)
    {
        # code...
        $user = Auth::user();

        $seller = Seller::where('user_id', $user->id)->first();
        if(!$user || !$seller){
            if(!$seller){
                return view('seller.seller-not-exists', [
                    'title' => 'تکمیل اطلاعات فروشنده',
                ]);
            }
        }

        $seller->actived_at = Carbon::now();
        $seller->save();

        session()->put('noty', [
            'title' => '',
            'message' => 'با موفقیت ارسال گردید. لطفا دقت نمایید پس از ویرایش اطلاعات فروشگاه برای تایید مجدد مدیریت ارسال میگردد.',
            'status' => 'success',
            'data' => '',
        ]);

        return back();
    }
}
