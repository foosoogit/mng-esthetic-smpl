<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\StaffController;

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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::view('/staff/login', 'staff/login');
Route::post('/staff/login', [App\Http\Controllers\Staff\LoginController::class,'login']);
Route::post('staff/logout', [App\Http\Controllers\Staff\LoginController::class,'logout']);
Route::view('/staff/register', 'staff/register');
Route::post('/staff/register', [App\Http\Controllers\Staff\RegisterController::class, 'register']);
//Route::get('/staff/home', [\App\Http\Controllers\StaffController::class,'ShowMenuCustomerManagement']);
//Route::prefix('staff')->group(['middleware' => 'auth:staff'], function(){
//Route::prefix('staff')->group(['middleware' => ['auth:staff'], function(){
Route::group(['middleware' => ['auth:staff']], function(){
    Route::get('/staff/menu', [\App\Http\Controllers\StaffController::class,'ShowMenuCustomerManagement'])->name('staff.menu');
});
//Route::view('/staff/home', 'staff/home')->middleware('auth:staff');
//->middleware(['auth:teacher'])->name('password.email');