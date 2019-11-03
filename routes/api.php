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
Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});



Route::group(['prefix' => 'doctor'], function () {

   
    
    
});


Route::group(['prefix' => 'admin'], function () {

    Route::post('/register', 'AdminsControllers\Auth\RegisterController@register');

    Route::post('/registeradoctor', 'DoctorsControllers\Auth\RegisterController@register');
    
    Route::apiResource('event', 'AdminsControllers\HospitalEventsController');

    Route::apiResource('department', 'AdminsControllers\DepartmentsController');
    
});


Route::post('/patient/register','PatientsController@store');

