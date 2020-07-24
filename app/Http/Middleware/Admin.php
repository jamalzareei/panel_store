<?php

namespace App\Http\Middleware;

use Closure;

class Admin
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
        // return $request->route()->getName();
        // $arryRoutes = ['admin.login', 'auth.login.post'];
        // if(in_array($request->route()->getName(), $arryRoutes)){
        //     return $next($request);
        // }
        if (auth()->check()) {
            $user = auth()->user()->roles;// Auth::user();
            // return $user;
            if(auth()->user()->roles->where('slug', 'ADMIN')->first()){
                return $next($request);
            }
        }

        session()->put('noty', [
            'title' => '',
            'message' => 'شما اجازه دسترسی به این بخش را ندارید.',
            'status' => 'error',
            'data' => '',
        ]);
        return back();
        // return $next($request);
    }
}
