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
        if (auth()->check()) {
            $user = auth()->user()->roles;
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
