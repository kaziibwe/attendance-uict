<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;

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



    Route::post('registerUser', [UserController::class,'registerUser'])->name('registerUser');
    Route::post('loginUser', [UserController::class,'loginUser'])->name('loginUser');

    Route::get('profileUser', [UserController::class,'profileUser'])->name('profileUser');

    Route::post('logoutUser', [UserController::class,'logoutUser'])->name('logoutUser');

});
