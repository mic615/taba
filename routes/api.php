<?php
use App\Http\Resources\User as UserResource;
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
    return new UserResource($request->user());
});

Route::post('/token', 'ApiController@authenticate');
Route::get('/categories', 'ApiController@getCategories');
Route::get('/merchants', 'ApiController@getAllMerchants');
Route::get('/merchants/{city}/{category}', 'ApiController@getMerchants');
Route::get('/ATMs/{latitude}/{longitude}/{radius?}', 'ApiController@getATMsByLocation');
Route::get('/ATMs', 'ApiController@getAllATMs');
Route::get('/offers/{latitude}/{longitude}', 'ApiController@getoffersByLocation');
Route::get('/offers', 'ApiController@getAllOffers');
Route::get('/testYelp', 'ApiController@testYelp');
Route::resource('/trip','TripController')->middleware('auth:api');
