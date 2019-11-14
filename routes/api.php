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

Route::middleware(['auth:api','cors'])->get('/user', function (Request $request) {
    return $request->user();
});


Route::post('/patient/register','PatientsController@store')->middleware('cors');
Route::get('/doctors','PatientsController@list_all_doctors');
Route::post('/book-appointment','PatientsController@book_appointment');
Route::get('/patient/appointments','PatientsController@appointments');
Route::delete('/patient/cancel-appointment/{appointment}','PatientsController@cancel_appointment');
Route::post('/patient/request-ambulance','PatientsController@request_ambulance');


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

    Route::get('/staff/list', 'AdminsControllers\StaffsController@index'); #list of all staff

    Route::patch('/department/{department}/assign-head', 'AdminsControllers\DepartmentsController@assignHead');

    Route::get('/registration/requirement', 'DoctorsControllers\Auth\RegistrationRequirement@getRequirement');
    
}); 



