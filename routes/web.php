<?php

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

Auth::routes();

Route::get('/signin', function () {
    return view('signin');
})->middleware('guest');

Route::post('/loginMy', 'SecurityController@signin')->name('loginMy');

//User Management
Route::post('/saveUser', 'UserController@save')->name('saveUser');
Route::get('/sign-up', function () {
    return view('sign-up', ['title' => 'Sign Up']);
});



Route::group(['middleware' => 'auth', 'prefix' => ''], function () {
    Route::get('/', function () {
        return view('index', ['title' => 'Home']);
    });
    Route::get('/index', function () {
        return view('index', ['title' => 'Home']);
    });

    Route::get('/logout', 'SecurityController@logoutNow')->name('logout');
    Route::post('/activateDeactivate', 'API\CommonController@activateDeactivate')->name('activateDeactivate');


    //categories
    Route::get('/categories', 'CategoryController@categories')->name('categories');
    Route::post('/saveCategory', 'CategoryController@save')->name('saveCategory');
    Route::post('/editCategory', 'CategoryController@edit')->name('editCategory');
    Route::post('/changeStatus', 'CategoryController@changeStatus')->name('changeStatus');

    //category prices
    Route::get('/category-prices', 'CategoryPriceController@categoryPrices')->name('category-prices');
    Route::post('/saveCategoryPrice', 'CategoryPriceController@store')->name('saveCategoryPrice');
    Route::post('/editCategoryPrice', 'CategoryPriceController@edit')->name('editCategoryPrice');
    
    //booking
    Route::get('/make-a-booking', 'CustomerBookingController@makeABooking')->name('make-a-booking');

    Route::get('/test-page', 'TestController@testPage')->name('test-page');

});
