<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\StaffController;
use App\Http\Livewire\CustomerSearch;

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
Route::view('/staff/register', 'staff/register');
Route::post('/staff/register', [App\Http\Controllers\Staff\RegisterController::class, 'register']);
//Route::get('/staff/home', [\App\Http\Controllers\StaffController::class,'ShowMenuCustomerManagement']);
//Route::prefix('staff')->group(['middleware' => 'auth:staff'], function(){
//Route::prefix('staff')->group(['middleware' => ['auth:staff'], function(){
//Route::get('/menuStaff', [\App\Http\Controllers\StaffController::class,'ShowMenuCustomerManagement'])->name('StaffMenu');
Route::group(['middleware' => ['auth:staff']], function(){
    Route::get('/customers/ShowContractList/{UserSerial}', [\App\Http\Controllers\StaffController::class,'ShowContractList',function($UserSerial){}]);
	Route::post('/customers/ShowContractList/{UserSerial}', [\App\Http\Controllers\StaffController::class,'ShowContractList',function($UserSerial){}]);

    Route::post('/customers/ShowSyuseiCustomer', [\App\Http\Controllers\StaffController::class,'ShowSyuseiCustomer',function(Request $request){}]);
    Route::get('/customers/deleteCustomer/{serial_user}',[\App\Http\Controllers\StaffController::class,'deleteCustomer'],function($serial_user){});
    Route::get('ShowMenuCustomerManagement',[\App\Http\Controllers\StaffController::class,'ShowMenuCustomerManagement']);
	Route::post('ShowMenuCustomerManagement',[\App\Http\Controllers\StaffController::class,'ShowMenuCustomerManagement'],function(Request $request){})->name("ShowMenuCustomerManagement.post");
    Route::post('recordVisitPaymentHistory/', [\App\Http\Controllers\StaffController::class,'recordVisitPaymentHistory',function(Request $request){}])->name("recordVisitPaymentHistory.post");
    Route::get('/customers/ShowInpRecordVisitPayment/{SerialKeiyaku}/{SerialUser}', [\App\Http\Controllers\StaffController::class,'ShowInpRecordVisitPayment',function($SerialKeiyaku,$SerialUser){}]);
	Route::post('/customers/ShowInpRecordVisitPayment', [\App\Http\Controllers\StaffController::class,'ShowInpRecordVisitPayment']);
    Route::get('/customers/insertContract', [\App\Http\Controllers\StaffController::class,'insertContract']);
	Route::post('/customers/insertContract', [\App\Http\Controllers\StaffController::class,'insertContract']);
    Route::get('/customers/ShowInpContract/{serial_user}', [\App\Http\Controllers\StaffController::class,'ShowInpKeiyaku'],function($serial_user){});
    Route::get('/customers/insertCustomer', [\App\Http\Controllers\StaffController::class,'insertCustomer']);
	Route::post('/customers/insertCustomer', [\App\Http\Controllers\StaffController::class,'insertCustomer'],function(Request $request){});
    Route::get('/menuStaff', [\App\Http\Controllers\StaffController::class,'ShowMenuCustomerManagement'])->name('staff.menu');
    Route::get('/customers/ShowCustomersList_livewire', CustomerSearch::class);
    Route::get('/ShowUserList', [\App\Http\Controllers\StaffController::class,'ShowUserList'])->name('ShowUserList');
    Route::get('/customers/ShowInputCustomer', [\App\Http\Controllers\StaffController::class,'ShowInputCustomer']);
    Route::post('staff/logout', [App\Http\Controllers\Staff\LoginController::class,'logout'])->name('staff.logout');
});