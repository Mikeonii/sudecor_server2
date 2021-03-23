<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\HolidaysController;
use App\Http\Controllers\ClientsController;
// use App\Htpp\Controllers\AttendanceSummaryController;
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
// update attendance
Route::put('/insert_attendance',[AttendanceController::class,'insert_attendance']);
// insert client
Route::post('/insert_client',[ClientsController::class,'insert_client']);
// update client
Route::put('/insert_client',[ClientsController::class,'insert_client']);
// get attendance
Route::get('/attendance/{year}/{month}/{half}',[ClientsController::class,'get_client']);
// get all clients
Route::get('/clients',[ClientsController::class,'clients']);
// get all attendance
Route::get('/attendances', [AttendanceController::class,'attendances']);
// get client
Route::get('/client/{id}',[ClientsController::class,'get_single_client']);
Route::get('/attendance/{id}',[ClientsController::class,'get_attendance_from_client']);
// calculate summary
// Route::post('/summary',[AttendanceSummaryController::class,'calculate_summary']);

// HOLIDAYS
// get holidays
Route::get('/holidays',[HolidaysController::class,'index']);
// insert holiday
Route::post('/add_holiday',[HolidaysController::class,'add_holiday']);
// update holiday
Route::put('/edit_holiday',[HolidaysController::class,'add_holiday']);