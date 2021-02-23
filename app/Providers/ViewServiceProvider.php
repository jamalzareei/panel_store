<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class ViewServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
        View::composer('*', function ($view) {
            dd(\App\Models\Message::where('user_receiver_id', auth()->id)->whereDoesntHave('read')->get());
            $view->with('messagesnotread',  \App\Models\Message::where('user_receiver_id', auth()->id)->whereDoesntHave('read')->get());
        });
    }
}
