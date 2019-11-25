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
    Route::get('/prescriptions', 'PatientsController@prescriptions');
    Route::get('/prescription/{prescription}', 'PatientsController@prescription');
    Route::put('/prescription/{prescription}/submit','PatientsController@submitPrescription');

    Route::post('/{user}/doctor/message', 'MessagesController@patient_doctor');

    Route::get('/{user}/doctor/message', 'MessagesController@getPatientDoctorChat');

    Route::get('/pay/{prescription}','PaymentController@pay');
    Route::get('/check-payment-status/{prescription}','PaymentController@checkPaymentStatus');
    Route::post('create', 'PasswordResetController@create');
    Route::get('password/find/{token}', 'PasswordResetController@find');
    Route::post('password-reset', 'PasswordResetController@reset');
    Route::get('/get-records', 'PatientsController@getRecords');
});

Route::get('/doctors','PatientsController@list_all_doctors');

Route::post('/{staffAttendance}/checkin', 'StaffAttendanceController@checkin');

Route::post('/{staffAttendance}/checkout', 'StaffAttendanceController@checkout');

Route::get('department/{department}/message', 'MessagesController@getDepartmentChat');

Route::post('department/{department}/message', 'MessagesController@storeDepartmentChat');

Route::get('/{conversation}/conversation', 'MessagesController@chatWith');

Route::get('/message-attachment/{message}/download', 'MessagesController@download');



Route::group(['prefix' => 'doctor'], function () {

    Route::get('/', function(){

        return auth()->guard('doctor')->user();
    })->middleware(['multiauth:doctor,api']);

    Route::post('/register', 'DoctorsControllers\Auth\RegisterController@register');
    Route::get('/appointment-list', 'DoctorsController@list_appointment');
    Route::get('/appointment/approve/{appointment}', 'DoctorsController@approve_appointment');
    Route::post('/prescription/make', 'DoctorsController@make_prescription');
    Route::post('/{doctor}/reset-password', 'DoctorsControllers\Auth\RegisterController@resetDefaultPassword');
    Route::post('/patientrecord/write','DoctorsController@write_patient_record');
    Route::get('/{user}/get-record','DoctorsController@get_patient_record');


    Route::get('/{doctor}/request-code', 'StaffAttendanceController@requestCodeForDoctor');

    Route::post('{doctor}/message', 'MessagesController@doctorChat');

    Route::get('/{doctor}/chats', 'MessagesController@getdoctorChats'); #return list of other doctors a doctor chats with

    Route::post('/{doctor}/patient/message', 'MessagesController@doctor_patient');

    Route::get('/{doctor}/patient/message', 'MessagesController@getDoctorPatientChat');

});

Route::group(['prefix' => 'admin'], function () {

    Route::get('/', function(){

        return auth()->guard('admin')->user();
    })->middleware(['multiauth:admin,api']);

    Route::get('/department/{department}/staff-list', 'AdminsControllers\DepartmentsController@staffList');

    Route::post('/register', 'AdminsControllers\Auth\RegisterController@register');

    Route::post('/registeradoctor', 'DoctorsControllers\Auth\RegisterController@register');
    
    Route::apiResource('event', 'AdminsControllers\HospitalEventsController');

    Route::apiResource('department', 'AdminsControllers\DepartmentsController');

    Route::post('/register/staff', 'AdminsControllers\StaffsController@store');

    Route::get('/staff/list', 'AdminsControllers\StaffsController@index'); #list of all staff

    Route::post('register/pharmacist', 'AdminsControllers\PharmacistsController@register');

    Route::patch('pharmacist/{pharmacist}/edit', 'AdminsControllers\PharmacistsController@update');

    Route::delete('/delete/{id}/pharmacist', 'AdminsControllers\PharmacistsController@destroy');

    Route::patch('/department/{department}/assign-head', 'AdminsControllers\DepartmentsController@assignHead');

    Route::get('/doctors-registration-requirement', 'DoctorsControllers\Auth\RegistrationRequirement@getRequirement');

    Route::get('/staff-registration-requirement', 'AdminsControllers\StaffsController@getStaffRegistrationRequirement');

    Route::get('/view/{employee}/staff', 'AdminsControllers\StaffsController@show');

    Route::patch('/edit/{employee}/staff', 'AdminsControllers\StaffsController@update');

    Route::delete('/delete/{employee}/staff', 'AdminsControllers\StaffsController@destroy');

    Route::get('/{admin}/request-code', 'StaffAttendanceController@requestCodeForAdmin');
    
}); 

Route::group(['prefix' => 'pharmacy'], function () {
    
    Route::post('/add-drug','PharmacyController@addDrug');
    Route::put('/drug/{pharmacy}','PharmacyController@updateDrug');
    Route::get('/drugs','PharmacyController@index');
    Route::get('/prescriptions','PharmacyController@prescriptions');
    Route::get('/prescription/{prescription}','PharmacyController@prescription');
    Route::post('/{prescription}/issue_drugs','PharmacyController@issueDrugs');
});


Route::group(['prefix' => 'staff'], function () {

    Route::post('/{employee}/reset-password', 'EmployeesControllers\StaffController@resetDefaultPassword');

    Route::get('/{employee}/request-code', 'StaffAttendanceController@requestCodeForStaff');

    Route::post('/{employee}/message', 'MessagesController@staffChat');

    Route::get('/{employee}/message', 'MessagesController@getStaffChat');

});


Route::group(['prefix' => 'pharmacist'], function () {

    Route::post('/{pharmacist}/reset-password', 'EmployeesControllers\StaffController@resetDefaultPassword');

    Route::get('/{pharmacist}/request-code', 'StaffAttendanceController@requestCodeForPharmacist');

    Route::post('/{pharmacist}/message', 'MessagesController@pharmacistChat');

});
Route::group(['prefix' => 'payment'], function () {
    Route::get('/callback/{status}/{transac_id}/{cust_ref}/{pay_token}','PaymentController@callback');
});
