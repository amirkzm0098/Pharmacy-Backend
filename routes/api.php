<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Patient;
use App\Models\PrescContent;
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
    $user = $request->user();
    $referred = null;
    if ($user->type == 'patient') $referred = Patient::find($user->ref_id);
    else $referred = Employee::find($user->ref_id);
    return response()->json([
        'status' => true,
        'message' => [],
        'result' => [['type' => $user->type, 'referred' => $referred]]
    ]);
});

Route::group(['middleware' => 'auth:sanctum'], function () {

    //All secure URL's

    Route::get("users", [UserController::class, 'index']);

    Route::resource('meds', MedController::class);

    Route::get('meds/allInfo/{id}', [MedController::class, 'showAllInfo']);

    Route::post('meds/search', [MedController::class, 'search']);

    Route::get('meds/topSell/nd', [MedController::class, 'topSellND']);

    Route::get('meds/topSell/dnd', [MedController::class, 'topSellDND']);

    Route::resource('pharms', PharmController::class);

    Route::resource('comps', CompController::class);

    Route::resource('ins', InsController::class);

    Route::resource('patients', PatientController::class);

    Route::resource('employee', EmployeeController::class);

    Route::resource('presc', PrescController::class);

    Route::get('presc/updatePrice/{id}', [PrescController::class, 'calculateTotalPrice']);

    Route::post('presc/payment', [PrescController::class, 'setPaymentState']);

    Route::post('presc/deliver', [PrescController::class, 'setDeliverState']);

    Route::get('orders', [PrescController::class, 'getOrders']);

    Route::resource('presc/content', PrescContentController::class);

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
