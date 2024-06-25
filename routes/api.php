<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\DepartmentController;

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
    Route::post('createDepartment', [DepartmentController::class,'createDepartment'])->name('createDepartment');

    // get all departments
    Route::get('getAllDepartments', [DepartmentController::class,'getAllDepartments'])->name('getAllDepartments');

    // get single department
    Route::get('getSingleDepartment/{id}', [DepartmentController::class,'getSingleDepartment'])->name('getSingleDepartment');

    // update  a department
    Route::patch('updateDepartment/{id}', [DepartmentController::class,'updateDepartment'])->name('updateDepartment');

        // delete single department
        Route::delete('deleteDepartment/{id}', [DepartmentController::class,'deleteDepartment'])->name('deleteDepartment');










});
