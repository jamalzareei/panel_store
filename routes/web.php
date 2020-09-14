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
Route::get('/login', 'HomeController@index')->name('login');
Route::get('/auth', 'HomeController@index')->name('auth.login.get');

Route::post('/auth-login', 'HomeController@login')->name('auth.login.post');

// Auth::routes();

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
    
    Route::get('properties/{category_id?}', 'PropertiesController@properties')->name('admin.properties.list');
    Route::get('property/edit/{slug}', 'PropertiesController@propertyEdit')->name('admin.property.edit');
    Route::post('property/update/status/{id}', 'PropertiesController@propertyUpdateStatus')->name('admin.property.update.status');
    Route::post('property/add', 'PropertiesController@propertyInsert')->name('admin.property.add');
    Route::post('property/update/{id}', 'PropertiesController@propertyUpdate')->name('admin.property.update.post');
    Route::post('properties/update', 'PropertiesController@propertiesUpdate')->name('admin.properties.update');
    Route::delete('property/delete/{id}', 'PropertiesController@propertyDelete')->name('admin.property.delete');

    
    Route::get('tags/{category_id?}', 'TagsController@tags')->name('admin.tags.list');
    Route::get('tag/edit/{slug}', 'TagsController@tagEdit')->name('admin.tag.edit');
    Route::post('tag/update/status/{id}', 'TagsController@tagUpdateStatus')->name('admin.tag.update.status');
    Route::post('tag/add', 'TagsController@tagInsert')->name('admin.tag.add');
    Route::post('tag/update/{id}', 'TagsController@tagUpdate')->name('admin.tag.update.post');
    Route::post('tags/update', 'TagsController@tagsUpdate')->name('admin.tags.update');
    Route::delete('tag/delete/{id}', 'TagsController@tagDelete')->name('admin.tag.delete');

});

Route::namespace('User')->middleware('auth')->prefix('user')->group(function() {
    Route::get('/user', 'UsersController@getUserData')->name('user.data');
    Route::post('/user', 'UsersController@postUserData')->name('user.data.post');

    Route::get('/user/email', 'UsersController@userMail')->name('user.data.email');
    Route::post('/user/email', 'UsersController@postUserMail')->name('user.data.email.post');
    
    Route::get('/user/phone', 'UsersController@userPhone')->name('user.data.phone');
    Route::post('/user/phone', 'UsersController@postUserPhone')->name('user.data.phone.post');
    
    Route::get('/user/change-password', 'UsersController@userChangePassword')->name('user.data.change.password');
    Route::post('/user/change-password', 'UsersController@postUserChangePassword')->name('user.data.change.password.post');

});

Route::get('/get-countries', 'Admin\LocationController@getCountries')->name('get.countries.location');
Route::get('/get-states/{country_id?}', 'Admin\LocationController@getStates')->name('get.states.location');
Route::get('/get-cities/{state_id?}', 'Admin\LocationController@getCities')->name('get.cities.location');

Route::namespace('Seller')->middleware('seller')->prefix('seller')->group(function() {
    Route::get('/', 'DashboardController@index')->name('seller.dashboard');

    // Route::get('/user', 'UsersController@getUserData')->name('seller.user.data');
    // Route::post('/user', 'UsersController@postUserData')->name('seller.user.data.post');

    // Route::get('/user/email', 'UsersController@userMail')->name('seller.user.data.email');
    // Route::post('/user/email', 'UsersController@postUserMail')->name('seller.user.data.email.post');
    
    // Route::get('/user/phone', 'UsersController@userPhone')->name('seller.user.data.phone');
    // Route::post('/user/phone', 'UsersController@postUserPhone')->name('seller.user.data.phone.post');
    
    // Route::get('/user/change-password', 'UsersController@userChangePassword')->name('seller.user.data.change.password');
    // Route::post('/user/change-password', 'UsersController@postUserChangePassword')->name('seller.user.data.change.password.post');

    Route::get('/edit-seller', 'SellersController@sellerDataGet')->name('seller.data.get');
    Route::post('/edit-seller', 'SellersController@sellerDataPost')->name('seller.data.post');

    Route::get('/branches', 'BranchesController@branches')->name('seller.brancehs.get');
    Route::post('/add-branch', 'BranchesController@addeBranceh')->name('seller.branch.add');
    Route::get('/edit-branch/{id}', 'BranchesController@editBranch')->name('seller.branch.edit');
    Route::post('/update-branch/{id}', 'BranchesController@updateBranceh')->name('seller.branch.update');
    Route::post('branch/update/status/{id}', 'BranchesController@branchUpdateStatus')->name('seller.branch.update.status');
    Route::post('branches/update', 'BranchesController@branchesUpdate')->name('seller.branches.update');
    Route::delete('branches/delete/{id}', 'BranchesController@branchesDelete')->name('seller.branches.delete');
});