<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\Country;
use App\Models\Image;
use App\Models\Seller;
use App\Services\UploadService;
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
        // $seller->details = $request->details;
        $seller->head = $request->head;
        
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
}
