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

Route::get('/', function () {
    return view('welcome');
})->name('index');

Auth::routes();
Auth::routes(['verify' => true]);

Route::get('/get-estimate', function(){
    return view('parcel.get_estimate');
})->name('get_estimate');

Route::get('/contact-us', function(){
    return view('page.contact');
})->name('contact');

Route::get('/careers', function(){
    return view('page.careers');
})->name('careers');

Route::get('/privacy-policy', function(){
    return view('page.privacy');
})->name('privacy');

Route::get('/service-areas', function(){
    return view('page.service-areas');
})->name('service_areas');

Route::get('/track-parcel', function(){
    return view('page.track');
})->name('track_parcel');

Route::get('/about-us', function(){
    return view('page.about');
})->name('about');

// Request pickup
Route::match(['get', 'post'], '/request-pickup', 'ParcelController@requestPickup')->name('request_pickup');
Route::post('/request-pickup/{parcel}/payment', 'ParcelController@payment');
Route::get('/thank-you/{parcel}', 'ParcelController@thank_you')->name('thank_you');

Route::group(['prefix'=>'app'], function(){

    Route::get('/', 'HomeController@index')->name('home');
    Route::get('/logout', 'HomeController@logout')->name('logout');
    Route::get('/{user}/profile', 'HomeController@profile');

    Route::group(['prefix'=>'parcel'], function(){
        Route::get('/', 'ParcelController@parcel')->name('parcel');
        Route::post('/', 'ParcelController@submit')->name('submit_parcel');
        Route::get('/{parcel}/details', 'ParcelController@details')->name('parcel_details');
        Route::match(['get', 'post', 'put'], '/{parcel}/checkout', 'ParcelController@checkout')->name('parcel_checkout');
        Route::match(['get'], '/paystack/callback', 'ParcelController@paystackCallback');
    });

    Route::group([ 'prefix' => 'riders', 'middleware' => ['auth', 'is_admin'] ], function(){
        Route::get('/', 'BikerController@index')->name('bikers');
        Route::post('/add', 'BikerController@add')->name('add_rider');
    });

    Route::group([ 'prefix' => 'bike', 'middleware' => ['auth', 'is_admin'] ], function(){
        Route::get('/', 'BikeController@index')->name('bikes');
        Route::post('/add', 'BikeController@add');
        Route::get('/get-bikes', 'BikeController@getBikes');
    });
});
