<?php

use App\Models\Appointment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\AppointmentController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group([

    'middleware' => 'api',
    'prefix' => 'auth'

], function ($router) {
    Route::post('Adminregister', [AdminController::class, 'Adminregister'])->name('Adminregister');
    Route::post('adminlogin', [AdminController::class, 'adminlogin'])->name('adminlogin');
    Route::get('profileAdmin', [AdminController::class, 'profileAdmin'])->name('profileAdmin');
    Route::post('logoutAdmin', [AdminController::class, 'logoutAdmin'])->name('logoutAdmin');
    Route::post('refreshAdmin', [AdminController::class, 'refreshAdmin'])->name('refreshAdmin');


    // crude for department
    // api to create  department
    Route::post('createDepartment', [DepartmentController::class, 'createDepartment'])->name('createDepartment');

    // get all departments
    Route::get('getAllDepartments', [DepartmentController::class, 'getAllDepartments'])->name('getAllDepartments');

    // get single department
    Route::get('getSingleDepartment/{id}', [DepartmentController::class, 'getSingleDepartment'])->name('getSingleDepartment');

    // update  a department
    Route::patch('updateDepartment/{id}', [DepartmentController::class, 'updateDepartment'])->name('updateDepartment');

    // delete single department
    Route::delete('deleteDepartment/{id}', [DepartmentController::class, 'deleteDepartment'])->name('deleteDepartment');



    // Route appointment
    //  route for create appointment
    Route::post('createAppointment', [AppointmentController::class, 'createAppointment'])->name('createAppointment');

        //  get single user

    Route::get('getSingleAppointment/{id}', [AppointmentController::class, 'getSingleAppointment'])->name('getSingleAppointment');

    // get all appoints

    Route::get('getAllAppointments', [AppointmentController::class, 'getAllAppointments'])->name('getAllAppointments');

// get appoints by the user id
Route::get('getAppointmentsbyStuff/{id}', [AppointmentController::class, 'getAppointmentsbyStuff'])->name('getAppointmentsbyStuff');


    //route to update the apis

    Route::patch('updateAppointment/{id}', [AppointmentController::class, 'updateAppointment'])->name('updateAppointment');



    // Route appointment
    //  route for create appointment
    Route::post('createAttendance', [AttendanceController::class, 'createAttendance'])->name('createAttendance');

     //  route for update appointment
     Route::patch('updateAttendance/{id}', [AttendanceController::class, 'updateAttendance'])->name('updateAttendance');

        //  route for get attendances
        Route::get('getSingleAttendance/{id}', [AttendanceController::class, 'getSingleAttendance'])->name('getSingleAttendance');

        // route to get attendances by the staff
        Route::get('getAttendancesbyStuff/{id}', [AttendanceController::class, 'getAttendancesbyStuff'])->name('getAttendancesbyStuff');



          //  route for update appointment
          Route::get('getAllAppointments', [AttendanceController::class, 'getAllAppointments'])->name('getAllAppointments');




    // Route appointment
    //  route for create appointment
    Route::post('createAppointment', [AppointmentController::class, 'createAppointment'])->name('createAppointment');


    // loginStaff
    // login user
    Route::post('loginStaff', [StaffController::class, 'loginStaff'])->name('loginStaff');


    // create the staff


    Route::post('registerUser', [UserController::class, 'registerUser'])->name('registerUser');
    Route::post('loginUser', [UserController::class, 'loginUser'])->name('loginUser');

    Route::get('profileUser', [UserController::class, 'profileUser'])->name('profileUser');

    Route::post('logoutUser', [UserController::class, 'logoutUser'])->name('logoutUser');
});
