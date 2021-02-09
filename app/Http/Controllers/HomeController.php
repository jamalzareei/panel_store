<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        if(auth()->check()){
            $user = Auth::user()->roles;
            // return $user->where('slug', 'SELLER')->first();
            // if()
            if ($user->where('slug', 'ADMIN')->first()){
                return redirect()->route('admin.dashboard');
            }else if($user->where('slug', 'SELLER')->first()){
                return redirect()->route('seller.dashboard');
            }else{
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
            'status' => 'danger',
            'data' => '',
        ]);
    }
}
