<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('login');
    // return redirect()->route('admin.login');
});
Route::get('/auth', function () {
    return view('login');
});
Route::get('/logout-user', function () {
    Auth::logout();
    return redirect('auth');
})->name('logout.user');
Route::get('/', 'HomeController@index')->name('login.get');
Route::get('/auth', 'HomeController@index')->name('auth.login.get');

Route::post('/auth-login', 'HomeController@login')->name('auth.login.post');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::namespace('Admin')->middleware('admin')->prefix('admin')->group(function() {
    Route::get('dashboard', 'DashboardController@index')->name('admin.dashboard');

    Route::get('users', 'UsersController@users')->name('admin.users.list');
    Route::post('user/add', 'UsersController@userAdd')->name('admin.user.add');
    Route::post('user/update/{id}', 'UsersController@userUpdate')->name('admin.user.update');
    Route::post('users/update', 'UsersController@usersUpdate')->name('admin.users.update');
    Route::delete('user/delete/{id}', 'UsersController@userDelete')->name('admin.user.delete');

    

    Route::get('roles', 'UsersController@roles')->name('admin.roles.list');
    Route::get('permissions', 'UsersController@permissions')->name('admin.permissions.list');
});