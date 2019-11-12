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
Route::fallback(function () {
    return response()->json([
        'message' => 'Route not found'
    ],404);
})->name('api.fallback.404');

//Patient Routes
Route::post('/patient/register','PatientsController@store');

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


Route::post('/patient/register','PatientsController@store');
Route::get('/doctors','PatientsController@list_all_doctors');
Route::post('/book-appointment','PatientsController@book_appointment');
Route::get('/patient/appointments','PatientsController@appointments');
Route::delete('/patient/cancel-appointment/{appointment}','PatientsController@cancel_appointment');
Route::post('/patient/request-ambulance','PatientsController@request_ambulance');


Route::group(['prefix' => 'doctor'], function () {

    Route::post('/register', 'DoctorsControllers\Auth\RegisterController@register');
});

Route::group(['prefix' => 'admin'], function () {

    Route::post('/register', 'AdminsControllers\Auth\RegisterController@register');    
    
}); 



