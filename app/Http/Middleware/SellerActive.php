<?php

namespace App\Http\Middleware;

use Closure;

class SellerActive
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
        $user = auth()->user();
        if (!auth()->check()) {
            session()->put('noty', [
                'title' => '',
                'message' => 'شما اجازه دسترسی به این بخش را ندارید.',
                'status' => 'error',
                'data' => '',
            ]);
    
            return back();
        }
        $seller = $user->seller;

        // return $seller;
        if(!$seller){
            return response()->view('components.not-perrmission', [
                'title' => 'تکمیل اطلاعات فروشنده',
                'message' => '<br>
                شما اجازه دسترسی به این بخش را ندارید.
                <br>
                <br>
                لطفا ابتدا نسبت به تکمیل اطلاعات فروشگاه خود اقدام نمایید.',
                'linkRedirect' => route('seller.data.get'),
                'textRedirect' => 'تکمیل اطلاعات فروشنده',
            ]);
        }
        if(!$seller->admin_actived_at){
            return response()->view('components.not-perrmission', [
                'title' => 'فعال سازی فروشنده',
                'message' => '<br>
                شما اجازه دسترسی به این بخش را ندارید.
                <br>
                <br>
                لطفا اطلاعات فروشگاه را تایید و سپس برای تایید مدیریت ارسال نمایید..',
                'linkRedirect' => route('seller.data.get'),
                'textRedirect' => 'تکمیل اطلاعات و ارسال برای مدیریت',
            ]);
        }

        return $next($request);
    }
}
