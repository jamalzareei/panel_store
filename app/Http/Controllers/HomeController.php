<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\Seller;
use App\Models\Website;
use App\Services\kavenegarService;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        if (auth()->check()) {
            $user = Auth::user()->roles;
            // return $user->where('slug', 'SELLER')->first();
            // if()
            if ($user->where('slug', 'ADMIN')->first()) {
                return redirect()->route('admin.dashboard');
            } else if ($user->where('slug', 'SELLER')->first()) {
                return redirect()->route('seller.dashboard');
            } else {
                auth()->logout();
            }
            return redirect()->route('login');
        }
        return view('login');
    }

    public function login(Request $request)
    {
        # code...
        // return $request->all();
        $this->validate($request, [
            'username' => 'required',
            'password' => 'required',
        ]);
        $username = '0098' . ltrim($request->username, '0');
        if (is_numeric($request->username)) {
            $username = $request->username; // '0098'.ltrim
        } else {
            $username = $request->username; // ltrim($request->username, '0');
        }

        $remember = $request->remember ? true : false;

        $credentials = array(
            'code_country'  => '0098',
            'phone'         => $username,
            'password'      => $request->password
        );

        if (Auth::attempt($credentials, $remember)) {
            $user = Auth::user();
            // return auth()->user()->roles;//->where('slug', 'ADMIN')->first();
            if ($user->roles && $user->roles->where('slug', 'ADMIN')->first()) {
                // return $user;
                return redirect()->route('admin.dashboard');
            } else if ($user->roles && $user->roles->where('slug', 'SELLER')->first()) {
                // return $user;
                // return redirect()->route('admin.dashboard');
                return redirect()->route('seller.dashboard');
            } else {
                return back()->with('message', 'شما اجازه دسترسی به این پنل را ندارید..');
            }
            // return redirect()->route('admin.dashboard');

        }
        return back()->with('noty', [
            'title' => '',
            'message' => 'نام کاربری یا رمز عبور اشتباه میباشد.',
            'status' => 'error',
            'data' => '',
        ]);
    }

    public function LoginCode($role = 'SELLER')
    {
        $username = request()->username ?? null;
        if (auth()->check()) {
            $user = Auth::user()->roles;
            // return $user->where('slug', 'SELLER')->first();
            // if()
            if ($user->where('slug', 'ADMIN')->first()) {
                return redirect()->route('admin.dashboard');
            } else if ($user->where('slug', 'SELLER')->first()) {
                return redirect()->route('seller.dashboard');
            } else {
                auth()->logout();
            }
            return redirect()->route('login');
        }
        return view('login-code', [
            'username' => $username,
            'role' => $role
        ]);
    }

    public function LoginCodePost(Request $request)
    {
        # code...
        // return $request;
        $request->validate([
            'username' => 'required|regex:/(09)[0-9]{9}/|digits:11|numeric',
            'role' => 'required',
        ]);

        $username = $request->username;
        $code_country = $request->code_country ?? '0098';
        $rolesList =  [$request->role, 'USER'] ?? ['USER'];
        $phone = null;

        $codeConfirm = rand(1000, 9999);

        if (is_numeric($request->username)) {
            $username = '0098' . ltrim($request->username, '0');
            $phone = $request->username; // '0098'.ltrim
        }

        $data['user'] = $userExist = User::where('phone', $phone)->where('code_country', $code_country)->first();
        if ($userExist) {
            $userExist->phone_confirm_code = $codeConfirm;
            $userExist->save();

            kavenegarService::sendCode($username, $codeConfirm, config('shixeh.verifyKavenegar'));
            return redirect(route('login.code.get', ['role' => $request->role]) . "?username=$username")->with('noty', [
                'title' => '',
                'message' => 'کد تاییدیه برای شما ارسال گردید.',
                'status' => 'success',
                'data' => '',
            ]);
        }

        if (User::where('username', $username)->first()) {
            // return response()->json([
            //     'status' => 'error',
            //     'errors' => ['username' => 'شماره تلفن قبلا ثبت شده است.'],
            // ], 422);
        }

        // return $username;
        $user = $data['user'] = User::create([
            'uuid' => Str::random(12),
            'username' => $username,
            'phone' => $phone,
            'phone_confirm_code' => $codeConfirm,
            'code_country' => $code_country
        ]);


        $this->setRoles($rolesList, $user->id);


        kavenegarService::sendCode($username, $codeConfirm, config('shixeh.verifyKavenegar'));

        return redirect()->route('user.data.change.password')->with('noty', [
            'title' => '',
            'message' => 'نام کاربری یا رمز عبور اشتباه میباشد.',
            'status' => 'error',
            'data' => '',
        ]);
    }


    public function setRoles($rolesList, $user_id)
    {
        # code...
        if (($key = array_search('ADMIN', $rolesList)) !== false) {
            unset($rolesList[$key]);
        }


        $user = User::find($user_id);
        if (($key = array_search('SELLER', $rolesList)) !== false) {
            $seller = Seller::where('user_id', $user_id)->first();
            if (!$seller) {
                $sel = Seller::create([
                    'user_id' => $user_id,
                    'code' => $user_id,
                ]);

                $new_array = array_intersect_key(
                    config('shixeh.listWebsites'),  /* main array*/
                    array_flip( /* to be extracted */
                        array('0', '1')
                    )
                );
                $websites = Website::whereNull('deleted_at')->whereIn('url', $new_array)->pluck('id')->toArray();
                if ($websites) {

                    $sel->websites()->sync($websites);
                }
            }
        }
        if ($user) {
            $roles = null;
            if ($rolesList)
                $roles = Role::whereIn('slug', $rolesList)->pluck('id')->toArray();

            if (isset($roles)) {
                $user->roles()->sync($roles);
            }
        }
    }


    public function confirmCode(Request $request)
    {
        # code...
        // return $request->all();
        $validate = $this->validate($request, [
            'username' => 'required',
            'code' => 'required',
        ]);

        $username = $request->username;

        $credentials = array(
            'code_country'          => '0098',
            'username'              => $username,
            'phone_confirm_code'    => $request->code
        );

        $user = User::where($credentials)->first();
        if ($user) {
            Auth::login($user, true);
            return redirect()->route('user.data.change.password');
        } else {
            return back()->with('noty', [
                'title' => '',
                'message' => 'کد وارد شده اشتباه است.',
                'status' => 'error',
                'data' => '',
            ]);
        }
    }
}
