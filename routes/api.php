<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\HolidaysController;
use App\Http\Controllers\ClientsController;
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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });
// insert attendance
Route::post('/insert_attendance',[AttendanceController::class,'insert_attendance']);
// insert holiday
Route::post('/insert_holiday',[HolidaysController::class,'insert_holiday']);
// update holiday
Route::put('/insert_holiday',[HolidaysController::class,'insert_holiday']);
// insert client
Route::post('/insert_client',[ClientsController::class,'insert_client']);
// update client
Route::put('/insert_client',[ClientsController::class,'insert_client']);