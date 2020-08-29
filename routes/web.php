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

// Route::get('/', function () {
//     return view('login');
//     // return redirect()->route('admin.login');
// });
// Route::get('/auth', function () {
//     return view('login');
// });
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
    Route::get('/', 'DashboardController@index')->name('admin.dashboard');
    Route::get('dashboard', 'DashboardController@index')->name('admin.dashboard');

    Route::get('users', 'UsersController@users')->name('admin.users.list');
    Route::post('user/add', 'UsersController@userAdd')->name('admin.user.add');
    Route::post('user/update/{id}', 'UsersController@userUpdate')->name('admin.user.update');
    Route::post('users/update', 'UsersController@usersUpdate')->name('admin.users.update');
    Route::delete('user/delete/{id}', 'UsersController@userDelete')->name('admin.user.delete');

    
    Route::get('roles', 'RolesController@roles')->name('admin.roles.list');
    Route::post('role/add', 'RolesController@roleAdd')->name('admin.role.add');
    Route::post('role/update/{id}', 'RolesController@roleUpdate')->name('admin.role.update');
    Route::post('roles/update', 'RolesController@rolesUpdate')->name('admin.roles.update');
    Route::delete('role/delete/{id}', 'RolesController@roleDelete')->name('admin.role.delete');

    Route::get('permissions', 'PermissionsController@permissions')->name('admin.permissions.list');
    Route::post('permission/add', 'PermissionsController@permissionAdd')->name('admin.permission.add');
    Route::post('permission/update/{id}', 'PermissionsController@permissionUpdate')->name('admin.permission.update');
    Route::post('permissions/update', 'PermissionsController@permissionsUpdate')->name('admin.permissions.update');
    Route::delete('permission/delete/{id}', 'PermissionsController@permissionDelete')->name('admin.permission.delete');
    
    Route::get('categories/{parent_id?}', 'categoriesController@categories')->name('admin.categories.list');
    Route::get('category/edit/{slug}', 'categoriesController@categoryEdit')->name('admin.category.edit');
    Route::post('category/update/status/{id}', 'categoriesController@categoryUpdateStatus')->name('admin.category.update.status');
    Route::post('category/add', 'categoriesController@categoryInsert')->name('admin.category.add');
    Route::post('category/update/{id}', 'categoriesController@categoryUpdate')->name('admin.category.update.post');
    Route::post('categories/update', 'categoriesController@categoriesUpdate')->name('admin.categories.update');
    Route::delete('category/delete/{id}', 'categoriesController@categoryDelete')->name('admin.category.delete');

});