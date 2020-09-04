<?php

namespace App\Http\Middleware;

use Closure;

class Seller
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (auth()->check()) {
            $user = auth()->user()->roles;
            // return $user;
            if(auth()->user()->roles->where('slug', 'SELLER')->first()){
                return $next($request);
            }
        }else{
            
            session()->put('noty', [
                'title' => '',
                'message' => 'ابتدا وارد حساب کاربری خود شوید',
                'status' => 'error',
                'data' => '',
            ]);

            return redirect()->route('login.get');//back();
        }

        session()->put('noty', [
            'title' => '',
            'message' => 'شما اجازه دسترسی به این بخش را ندارید.',
            'status' => 'error',
            'data' => '',
        ]);

        return back();

        return $next($request);
    }
}
