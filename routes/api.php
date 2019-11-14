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


Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['prefix' => 'patient'], function () {

    Route::post('/register','PatientsController@store');
    Route::post('/book-appointment','PatientsController@book_appointment');
    Route::get('/appointments','PatientsController@appointments');
    Route::delete('/cancel-appointment/{appointment}','PatientsController@cancel_appointment');
    Route::post('/request-ambulance','PatientsController@request_ambulance');
   
});

Route::get('/doctors','PatientsController@list_all_doctors');


Route::group(['prefix' => 'doctor'], function () {

    Route::post('/{doctor}/reset-password', 'DoctorsControllers\Auth\RegisterController@resetDefaultPassword');

});

Route::group(['prefix' => 'admin'], function () {

    Route::get('/department/{department}/staff-list', 'AdminsControllers\DepartmentsController@staffList');

    Route::post('/register', 'AdminsControllers\Auth\RegisterController@register');

    Route::post('/registeradoctor', 'DoctorsControllers\Auth\RegisterController@register');
    
    Route::apiResource('event', 'AdminsControllers\HospitalEventsController');

    Route::apiResource('department', 'AdminsControllers\DepartmentsController');

    Route::post('/register/staff', 'AdminsControllers\StaffsController@store');

    Route::get('/staff/list', 'AdminsControllers\StaffsController@index');

    Route::patch('/department/{department}/assign-head', 'AdminsControllers\DepartmentsController@assignHead');
    
}); 



