<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\StaffController;
use App\Http\Livewire\CustomerSearch;
use App\Http\Livewire\Counter;
use App\Http\Livewire\TreatmentContents;

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
    //return view('livewire.livewire-test');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::view('/staff/login', 'staff.login');
Route::post('/staff/login', [App\Http\Controllers\Staff\LoginController::class,'login']);
//Route::post('/staff/login', [App\Http\Controllers\Staff\LoginController::class,'showStaffLoginForm']);
Route::get('/staff/login', [App\Http\Controllers\Staff\LoginController::class,'showStaffLoginForm']);
/*
Route::post('/staff/login',function () {
    return view('staff.login');
});
*/

Route::post('/menuStaff', [App\Http\Controllers\Staff\LoginController::class,'login']);
//Route::get('/menuStaff', [App\Http\Controllers\Staff\LoginController::class,'showStaffLoginForm']);
//Route::view('/staff/register', 'staff/register');

Route::post('/staff/register', [App\Http\Controllers\Staff\RegisterController::class, 'register']);
Route::group(['middleware' => ['auth:staff']], function(){
    //Route::post('/workers/ShowYearlyReport', YearlyReport::class,function(Request $request){});
    Route::post('/workers/ShowYearlyReport', function () {
        return view('staff.appYearlyRep');
    });
    Route::post('/workers/ShowContractsReport', function () {
        return view('staff.appContractsRep');
    });
    //Route::post('/workers/ShowContractsReport', ContractsReport::class);
    Route::get('/workers/deleteTreatmentContent/{serial_TreatmentContent}',[\App\Http\Controllers\StaffController::class,'deleteTreatmentContent'],function($serial_TreatmentContent){});
    Route::post('/workers/saveTreatmentContent', [\App\Http\Controllers\StaffController::class,'SaveTreatmentContent']);

    Route::get('/workers/ShowSyuseiTreatmentContent/{TreatmentContentSerial}', [\App\Http\Controllers\StaffController::class,'ShowSyuseiTreatmentContent',function($TreatmentContentSerial){}]);

    Route::get('/workers/ShowTreatmentContents', function () {
        return view('staff.TreatmentList');
    });
    
    Route::post('/workers/ShowDailyReport_from_monthly_report', function () {
        return view('staff.DailyRep');
    });

    Route::post('/staff/MonthlyRep', function () {
        return view('staff.MonthlyRep');
    });
    Route::post('/workers/upsertBranch', [\App\Http\Controllers\StaffController::class,'upsertBranch'],function(Request $request){});
    Route::get('/workers/ShowBranchRegistration/{serial_branch}', [\App\Http\Controllers\StaffController::class,'ShowBranchRegistration'],function($serial_branch){});
    Route::post('/workers/ShowBranchRegistration/{serial_branch}', [\App\Http\Controllers\StaffController::class,'ShowBranchRegistration'],function($serial_branch){});
    Route::get('/workers/ShowBranchList', [\App\Http\Controllers\StaffController::class,'ShowBranchList']);

    Route::get('/workers/ShowDailyReport', function () {
        return view('staff.DailyRep');
    });
    Route::post('/workers/ShowDailyReport', function () {
        return view('staff.DailyRep');
    });
    
    Route::get('/customers/ShowCustomersList_livewire_from_top_menu/{target_user_serial}', [\App\Http\Livewire\CustomerSearch::class,'search_from_top_menu'],function($target_user_serial){});
	Route::post('/customers/ShowCustomersList_livewire_from_top_menu', CustomerSearch::class,function(Request $request){});

    Route::get('/customers/UserList', function () {
        return view('staff.UserList');
    });
    Route::post('/customers/UserList', function () {
        return view('staff.UserList');
    });

    Route::get('/customers/deleteContract/{serial_contract}/{serial_user}',[\App\Http\Controllers\StaffController::class,'deleteContract'],function($serial_contract,$serial_user){});
    Route::get('/customers/ShowSyuseiContract/{ContractSerial}/{UserSerial}', [\App\Http\Controllers\StaffController::class,'ShowSyuseiContract',function($ContractSerial,$UserSerial){session(['ContractSerial' => $ContractSerial,'UserSerial'=>$UserSerial]);}]);
	Route::post('/customers/ShowSyuseiContract/{ContractSerial}/{UserSerial}', [\App\Http\Controllers\StaffController::class,'ShowSyuseiContract',function($ContractSerial,$UserSerial){}]);
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
    Route::get('/customers/ShowCustomersList', [\App\Http\Controllers\StaffController::class,'ShowCustomersList']);
    Route::get('/ShowUserList', [\App\Http\Controllers\StaffController::class,'ShowUserList'])->name('ShowUserList');
    Route::get('/customers/ShowInputCustomer', [\App\Http\Controllers\StaffController::class,'ShowInputCustomer']);
    Route::post('/staff/logout', [App\Http\Controllers\Staff\LoginController::class,'logout'])->name('staff.logout');
});