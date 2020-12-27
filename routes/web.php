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

Route::group(['middleware' => 'auth', 'prefix' => ''], function () {
    Route::get('/', function () {
        return view('index', ['title' => 'Home']);
    });
    Route::get('/index', function () {
        return view('index', ['title' => 'Home']);
    });

    Route::get('/logout', 'SecurityController@logoutNow')->name('logout');
    Route::post('/activateDeactivate', 'API\CommonController@activateDeactivate')->name('activateDeactivate');


    Route::get('/test-page', 'TestController@testPage')->name('test-page');

});
