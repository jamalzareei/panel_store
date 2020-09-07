<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\Country;
use App\Models\Image;
use App\Services\UploadService;
use App\User;
use Hekmatinasser\Verta\Verta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UsersController extends Controller
{
    //
    public function getUserData(Request $request)
    {
        # code...
        $user = User::where('id', Auth::id())
            ->with(['country', 'state', 'city'])
            ->with(['image' => function ($query) {
                $query->select('path', 'id', 'imageable_id')->where('default_use', 'MAIN')->orderBy('id', 'desc')->first();
            }])
            ->first();

        $countries = Country::all();

        // return $user;

        return view('seller.user.edite', [
            'title' => 'ویرایش اطلاعات کاربری',
            'user' => $user,
            'countries' => $countries,
        ]);
    }

    public function postUserData(Request $request)
    {
        # code...
        // return $request->all();

        $request->validate([
            'city_id' => 'required|exists:cities,id',
            'country_id' => 'required|exists:countries,id',
            'state_id' => 'required|exists:states,id',
            'day' => 'nullable|required_with_all:month,year|numeric',
            'month' => 'nullable|required_with_all:day,year|numeric',
            'year' => 'nullable|required_with_all:month,day|numeric',
            'firstname' => 'required|string',
            'lastname' => 'required|string',
            'image_file' => 'nullable|string',
        ]);
        // return Verta::getGregorian($request->year,$request->month,$request->day);// $request->all();

        if ($request->year && $request->month && $request->day) {
            $birthdayArray = Verta::getGregorian($request->year, $request->month, $request->day);
            $birthday = $birthdayArray[0] . '-' . $birthdayArray[1] . '-' . $birthdayArray[2] . " 00:00:00";
            //2020-08-30 18:28:38
        }
        // return $birthday;

        $user = Auth::user();

        $user->firstname = $request->firstname;
        $user->lastname = $request->lastname;
        $user->birthday = (isset($birthday)) ? $birthday : $user->birthday;
        $user->country_id = $request->country_id;
        $user->state_id = $request->state_id;
        $user->city_id = $request->city_id;

        $user->save();

        
        if($request->image_file){
            $path_image = UploadService::convertBase64toPng('uploads/users/avatar', $request->image_file);
            Image::insert([ //,
                'path' => $path_image,
                'imageable_id' => $user->id,
                'imageable_type' => 'App\User',
                'user_id' => $user->id
            ]);
        }

        return [
            'status' => 'success',
            'title' => '',
            'message' => 'با موفقیت ویرایش گردید.',
            'data' => $user,
        ];
    }
}
