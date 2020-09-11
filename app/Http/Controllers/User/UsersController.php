<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Mail\ResetEmail;
use App\Models\Country;
use App\Models\Image;
use App\Services\kavenegarService;
use App\Services\UploadService;
use App\User;
use Carbon\Carbon;
use Hekmatinasser\Verta\Verta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

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

        return view('user.edit-user', [
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


        if ($request->image_file) {
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

    public function userMail(Request $request)
    {
        # code...
        $user = User::where('id', Auth::id())->first();

        // return $user;

        return view('user.edit-email', [
            'title' => 'تغییر ایمیل',
            'user' => $user,
        ]);
    }

    public function postUserMail(Request $request)
    {
        # code...
        $request->validate([
            'email' => 'required|unique:users,email'
        ]);

        $user = Auth::user();

        if($request->code_new){
            // return $request->all();
            if($user->email_confirm_code != $request->code_new){
                return response()->json([
                    'status' => 'error',
                    'errors' => ['code_old' => ['کد وارد شده معتبر نیست.']],
                ], 422);
            }
            // if(session('codeNew') && session('codeNew') != $request->code_new){
            //     return response()->json([
            //         'status' => 'error',
            //         'errors' => ['code_new' => ['کد وارد شده معتبر نیست.']],
            //     ], 422);
            // }

            $user->email = $request->email;
            $user->email_verified_at = Carbon::now();
            $user->save();

            
            return [
                'status' => 'success',
                'title' => '',
                'message' => 'ایمیل با موفقیت تغییر پیدا کرد.',
                'data' => '',
                'autoRedirect' => route('user.data.email')
            ];

        }else{

            // $codeOld = rand(1000,9999);
            // $dataOld = [
            //     'subject' => 'کد تاییدیه ایمیل',
            //     'title' => 'کد تاییدیه ایمیل',
            //     'message' => $codeOld,
            // ];
            // // return $dataOld;
            // Mail::to($user->email)->send(new ResetEmail($dataOld));

            // $user->email_confirm_code = $codeOld;
            // $user->save();
            
            $codeNew = rand(1000,9999);
            $dataNew = [
                'subject' => 'کد تاییدیه ایمیل',
                'title' => 'کد تاییدیه ایمیل',
                'message' => $codeNew,
            ];
            // session()->put('codeNew', $codeNew);
            Mail::to($request->email)->send(new ResetEmail($dataNew, config('shixeh.mailNoReply')));
            
            $user->email_confirm_code = $codeNew;
            $user->save();

            return [
                'status' => 'success',
                'title' => '',
                'message' => 'لطفا کد تاییدیه دریافت شده را وارد نمایید. کد به ایمیل شما ارسال گردیده است.',
                'data' => '',
            ];
        }
    }

    public function userPhone(Request $request)
    {
        # code...
        $user = User::where('id', Auth::id())->first();

        // return $user;

        return view('user.edit-phone', [
            'title' => 'تغییر تلفن',
            'user' => $user,
        ]);
    }

    
    public function postUserPhone(Request $request)
    {
        # code...
        $request->validate([
            'phone' => 'required|unique:users,phone'
        ]);

        $user = Auth::user();

        if($request->code_new){
            // return $request->all();
            if($user->phone_confirm_code != $request->code_new){
                return response()->json([
                    'status' => 'error',
                    'errors' => ['code_old' => ['کد وارد شده معتبر نیست.']],
                ], 422);
            }

            $username = '0098' . ltrim($request->phone, '0');
            $user->phone = $request->phone;
            $user->username = $username;
            $user->phone_verified_at = Carbon::now();
            $user->save();

            
            return [
                'status' => 'success',
                'title' => '',
                'message' => 'شماره تلفن با موفقیت تغییر پیدا کرد.',
                'data' => '',
                'autoRedirect' => route('user.data.phone')
            ];

        }else{
            
            $codeNew = rand(1000,9999);
            $message = "کد تاییدیه: $codeNew 
            شیکسه";

            $user->phone_confirm_code = $codeNew;
            $user->save();

            kavenegarService::sendCode($request->phone, $codeNew, 'verify');//send($request->phone, $message);
            

            return [
                'status' => 'success',
                'title' => '',
                'message' => 'لطفا کد تاییدیه دریافت شده را وارد نمایید. کد به شماره همراه شما ارسال گردیده است.',
                'data' => '',
            ];
        }
    }


    public function userChangePassword(Request $request)
    {
        # code...
        $user = User::where('id', Auth::id())->first();

        // return $user;

        return view('user.edit-change-password', [
            'title' => 'تغییر رمز عبور',
            'user' => $user,
        ]);
    }

    public function postUserChangePassword(Request $request)
    {
        # code...
        $request->validate([
            'password' => ['required', 'string', 'min:6', 'confirmed'],
        ]);

        $user = User::where('id', Auth::id())->first();

        // password_old
        if (!Hash::check($request->password_old, $user->password) && $user->password) {
            // Success
            return [
                'status' => 'error',
                'title' => '',
                'message' => 'کلمه عبور خود را اشتباه وارد کرده اید',
                'data' => '',
            ];
        }


        $user->password = Hash::make($request->password);
        $user->save();

        return [
            'status' => 'success',
            'title' => '',
            'message' => 'رمز عبور با موفقیت تغییر پیدا کرد.',
            'data' => '',
        ];
    }
}
