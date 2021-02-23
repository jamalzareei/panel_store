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

    Route::get('categories/{parent_id?}', 'CategoriesController@categories')->name('admin.categories.list');
    Route::get('category/edit/{slug}', 'CategoriesController@categoryEdit')->name('admin.category.edit');
    Route::post('category/update/status/{id}', 'CategoriesController@categoryUpdateStatus')->name('admin.category.update.status');
    Route::post('category/add', 'CategoriesController@categoryInsert')->name('admin.category.add');
    Route::post('category/update/{id}', 'CategoriesController@categoryUpdate')->name('admin.category.update.post');
    Route::post('categories/update', 'CategoriesController@categoriesUpdate')->name('admin.categories.update');
    Route::delete('category/delete/{id}', 'CategoriesController@categoryDelete')->name('admin.category.delete');

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

    Route::get('sellers/{type?}', 'SellersController@sellers')->name('admin.sellers.list');
    Route::post('seller/update/status/{id}', 'SellersController@sellerUpdateStatus')->name('admin.seller.update.status');
    Route::get('seller/{slug}', 'SellersController@sellerShow')->name('admin.seller.show');
    Route::post('seller/status/{id}', 'SellersController@sellerActive')->name('admin.seller.active');


    Route::get('/products/{status?}', 'ProductsController@products')->name('admin.products.get');
    Route::get('/product/{slug?}', 'ProductsController@product')->name('admin.product.update');
    Route::post('products/update', 'ProductsController@productsUpdate')->name('admin.products.update');
    // Route::delete('product/delete/{id}', 'ProductsController@productDelete')->name('admin.product.delete');
    Route::post('product/status/{id}', 'ProductsController@productActive')->name('admin.product.active');

    Route::get('/pages', 'PagesController@pages')->name('admin.pages.get');
    Route::get('/page/{slug?}', 'PagesController@page')->name('admin.page.get');
    Route::post('/page/{id}', 'PagesController@pageUpdate')->name('admin.page.update');
    Route::post('/add-page', 'PagesController@addePage')->name('admin.page.add');
    Route::post('page/update/status/{id}', 'PagesController@pageUpdateStatus')->name('admin.page.update.status');
    Route::post('pages/update', 'PagesController@pagesUpdate')->name('admin.pages.update');

    
    Route::get('/socials-sellers', 'SocialsController@index')->name('admin.socials.seller');
    Route::post('/socials/update/{id}', 'SocialsController@update')->name('admin.social.seller.update');
    
    Route::post('/add-files-instagram-page', 'SocialsController@uploadPostsPage')->name('add.instagram.page.files');

    
    Route::get('/tickets/{ticket_id?}', 'TicketsController@index')->name('admin.tickets');
    Route::post('/ticket/add', 'TicketsController@ticketAdd')->name('admin.ticket.add');
    Route::post('/ticket/add-reply/{ticket_id}', 'TicketsController@ticketAddReply')->name('admin.ticket.add.reply');

});

Route::namespace('User')->middleware('auth')->prefix('user')->group(function() {
    Route::get('/u', 'UsersController@getUserData')->name('user.data');
    Route::post('/u', 'UsersController@postUserData')->name('user.data.post');

    Route::get('/u/email', 'UsersController@userMail')->name('user.data.email');
    Route::post('/u/email', 'UsersController@postUserMail')->name('user.data.email.post');

    Route::get('/u/phone', 'UsersController@userPhone')->name('user.data.phone');
    Route::post('/u/phone', 'UsersController@postUserPhone')->name('user.data.phone.post');

    Route::get('/u/change-password', 'UsersController@userChangePassword')->name('user.data.change.password');
    Route::post('/u/change-password', 'UsersController@postUserChangePassword')->name('user.data.change.password.post');

    Route::get('/u/chats', 'MessagesController@messages')->name('user.messages');
    Route::get('/u/load-chat/{user_id?}', 'MessagesController@loadChat')->name('user.load.chat');
    Route::post('/send-message/{user_id?}', 'MessagesController@sendMessage')->name('user.send.message');

    
    Route::get('/u/tickets/{ticket_id?}', 'TicketsController@index')->name('user.tickets');
    Route::post('/u/ticket/add', 'TicketsController@ticketAdd')->name('user.ticket.add');
    Route::post('/u/ticket/add-reply/{ticket_id}', 'TicketsController@ticketAddReply')->name('user.ticket.add.reply');

});

Route::get('/get-countries', 'Admin\LocationController@getCountries')->name('get.countries.location');
Route::get('/get-states/{country_id?}', 'Admin\LocationController@getStates')->name('get.states.location');
Route::get('/get-cities/{state_id?}', 'Admin\LocationController@getCities')->name('get.cities.location');
Route::get('/get-children-categories/{col}/{parent_id?}', 'CategoriesController@getSubCategories')->name('get.children.categories');

Route::namespace('Seller')->middleware('seller')->prefix('seller')->group(function() {
    Route::get('/', 'DashboardController@index')->name('seller.dashboard');

    Route::get('/edit-seller', 'SellersController@sellerDataGet')->name('seller.data.get');
    Route::post('/edit-seller', 'SellersController@sellerDataPost')->name('seller.data.post');

    Route::get('/send-to-admin', 'SellersController@sellerSendAdmin')->name('seller.send.admin');

    Route::get('/branches', 'BranchesController@branches')->name('seller.brancehs.get');
    Route::post('/add-branch', 'BranchesController@addeBranceh')->name('seller.branch.add');
    Route::get('/edit-branch/{id}', 'BranchesController@editBranch')->name('seller.branch.edit');
    Route::post('/update-branch/{id}', 'BranchesController@updateBranceh')->name('seller.branch.update');
    Route::post('branch/update/status/{id}', 'BranchesController@branchUpdateStatus')->name('seller.branch.update.status');
    Route::post('branches/update', 'BranchesController@branchesUpdate')->name('seller.branches.update');
    Route::delete('branches/delete/{id}', 'BranchesController@branchesDelete')->name('seller.branches.delete');


    Route::get('/setting', 'SellersController@setting')->name('seller.setting.get');
    Route::post('/setting', 'SellersController@settingPost')->name('seller.setting.post');
    Route::post('/setting-ship', 'SellersController@settingShipPost')->name('seller.setting.ship.post');

    Route::get('/socials', 'SocialsController@socials')->name('seller.socials.get');
    Route::post('/add-social', 'SocialsController@socialsAddPost')->name('seller.social.add.post');
    Route::post('/update-social/{id}', 'SocialsController@socialUpdate')->name('seller.social.update.post');
    Route::delete('social/delete/{id}', 'SocialsController@socialDelete')->name('seller.social.delete');

    Route::get('/finances', 'FinancesControler@finances')->name('seller.finances.get');
    Route::post('/add-finance', 'FinancesControler@financesAddPost')->name('seller.finance.add.post');
    Route::post('/update-finance/{id}', 'FinancesControler@financeUpdate')->name('seller.finance.update.post');
    Route::post('finances/update', 'FinancesControler@financesUpdate')->name('admin.finances.update');
    Route::delete('finance/delete/{id}', 'FinancesControler@financeDelete')->name('seller.finance.delete');


    Route::middleware('selleractive')->group(function() {
        Route::get('/products', 'ProductsController@products')->name('seller.products.get');
        Route::get('/product/{slug?}', 'ProductsController@product')->name('seller.product.updateorcreate');
        Route::post('/add-product', 'ProductsController@productsAddPost')->name('seller.product.add.post');
        Route::post('/update-product/{id}/{type}', 'ProductsController@productUpdate')->name('seller.product.update.post');
        // Route::post('products/update', 'ProductsController@productsUpdate')->name('admin.products.update');
        Route::post('product/update/status/{id}', 'ProductsController@productUpdateStatus')->name('seller.product.update.status');
        Route::post('products/update', 'ProductsController@productsUpdate')->name('seller.products.update');
        Route::delete('product/delete/{id}', 'ProductsController@productDelete')->name('seller.product.delete');

        Route::get('/prices/{product_id}', 'ProductsController@getPrice')->name('seller.prices.product.get');
        Route::post('price/update/status/{id}', 'ProductsController@priceUpdateStatus')->name('seller.price.update.status');

        Route::get('/images/{product_id}', 'ProductsController@getImages')->name('seller.image.product.get');
        Route::post('image/update/status/{id}', 'ProductsController@imageUpdateStatus')->name('seller.image.update.status');
        Route::delete('image/product/delete/{id}', 'ProductsController@imageProductDelete')->name('seller.image.product.delete');

        Route::get('/product-send-to-admin/{id}', 'ProductsController@productSendAdmin')->name('product.send.admin');

        Route::get('/connet-to-instagram', 'ApiController@connectToInstagram')->name('seller.connect.instragram');
        Route::get('/connet-to-instagram-v2', 'ApiController@connectToInstagramV2')->name('seller.connect.instragram.v2');

        Route::get('/product-read-instagram/{username?}', 'ApiController@readInstagram')->name('seller.read.instragram');
        Route::post('/product-post-instagram/save', 'ApiController@postInstagramSave')->name('seller.post.instragram.save');

        Route::get('/product-read-instagram-username', 'ApiController@readInstagramUsername')->name('seller.read.instragram.username');

        Route::get('/product-read-instagram-username-v2/{username?}', 'ApiController@readInstagramUsernameV2')->name('seller.read.instragram.username.v2');

        Route::get('/redirect-to-read-instagram', 'ApiController@redirectToReadInstagram')->name('redirect.to.read.instagram');
        
        Route::get('/instagram-package', 'ApiController@package')->name('seller.read.instragram.package');

        Route::get('/orders', function(){
            return view('seller.table');
        })->name('seller.orders');

        
        Route::get('/orders/سفارش-های-در-انتظار', function(){
            return view('seller.table');
        })->name('seller.orders.await');

        
        Route::get('/u/پیام-های-کاربران-محصولات', function(){
            return view('seller.table');
        })->name('seller.reviews.products');
        
        Route::get('/u/پیام-های-کاربران-فروشنده', function(){
            return view('seller.table');
        })->name('seller.reviews.seller');
        
    });
});
