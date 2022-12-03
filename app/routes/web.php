<?php

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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::view('/staff/login', 'staff/login');
Route::post('/staff/login', [App\Http\Controllers\staff\LoginController::class, 'login']);
Route::post('staff/logout', [App\Http\Controllers\staff\LoginController::class,'logout']);
Route::view('/staff/register', 'staff/register');
Route::post('/staff/register', [App\Http\Controllers\staff\RegisterController::class, 'register']);
Route::view('/staff/home', 'staff/home')->middleware('auth:staff');