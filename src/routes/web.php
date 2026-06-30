<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AttendanceController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/attendance', [AttendanceController::class, 'index']);
Route::post('/attendance/clock-in', [AttendanceController::class, 'clockIn']);
Route::post('/attendance/break-in', [AttendanceController::class, 'breakIn']);
Route::post('/attendance/break-out', [AttendanceController::class, 'breakOut']);
Route::post('/attendance/clock-out', [AttendanceController::class, 'clockOut']);

Route::get('/attendance/list', [AttendanceController::class, 'list']);
Route::get('/attendance/{id}', [AttendanceController::class, 'show']);
Route::post('/attendance/{id}', [AttendanceController::class, 'update']);
Route::get('/stamp_correction_request/list', [AttendanceController::class, 'requestList']);
Route::get('/stamp_correction_request/{id}', [AttendanceController::class, 'requestDetail']);


Route::get('/', function () {
    return redirect('/login');
    });

    

   