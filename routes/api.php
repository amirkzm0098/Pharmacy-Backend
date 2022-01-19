<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['middleware' => 'auth:sanctum'], function () {

    //All secure URL's

    Route::get("users", [UserController::class, 'index']);

    Route::resource('meds', MedController::class);

    Route::get('meds/allInfo/{id}', [MedController::class, 'showAllInfo']);

    Route::resource('pharms', PharmController::class);

    Route::resource('comps', CompController::class);

    Route::resource('ins', InsController::class);

    Route::resource('patients', PatientController::class);

    Route::resource('employee', EmployeeController::class);

    Route::post('register/employee' , [EmployeeController::class, 'store']);

    Route::resource('categories', CategoryController::class);

    Route::get('categories/meds/{id}', [CategoryController::class, 'showMeds']);

});

Route::post("login/patient", [UserController::class, 'loginPatient']);

Route::post("login/employee", [UserController::class, 'loginEmployee']);

Route::post("register", [UserController::class, 'register']);

Route::post('register/patient' , [PatientController::class, 'store']);

Route::post('user/findPatient' , [UserController::class, 'showPatient']);

Route::post('user/findEmployee' , [UserController::class, 'showEmployee']);

Route::post('user/reset' , [UserController::class, 'resetPassword']);
