<?php

use App\Http\Controllers\Calendar\HolidaySettingController;
use App\Http\Controllers\CalendarController;
use Illuminate\Support\Facades\Route;

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

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', [CalendarController::class, 'show']);

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// 祝日設定
Route::get('/holiday_setting', [HolidaySettingController::class, 'form'])
    ->name('holiday_setting');
Route::post('/holiday_setting', [HolidaySettingController::class, 'update'])
    ->name('update_holiday_setting');
