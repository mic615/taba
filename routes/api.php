<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/token', 'ApiController@authenticate');
Route::get('/categories', 'ApiController@getCategories');
Route::get('/merchants', 'ApiController@getAllMerchants');
Route::get('/merchants/{latitude}/{longitude}', 'ApiController@getMerchantsByLocation');
Route::get('/ATMs/{latitude}/{longitude}/{radius?}', 'ApiController@getByLocation');
Route::get('/ATMs', 'ApiController@getAllATMs');
Route::get('/offers', 'ApiController@getAllOffers');
