<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;

class StaffController extends Controller
{
    
	public function __construct(){
		$this->middleware('auth:staff');
	}
	
	public function ShowMenuCustomerManagement(){
		print "ShowMenuCustomerManagement<br>";
        session(['fromPage' => 'MenuCustomerManagement']);
		session(['fromMenu' => 'MenuCustomerManagement']);
		$header="";$slot="";
		session(['fromMenu' => 'MenuCustomerManagement']);
		session(['targetYear' => date('Y')]);
		$targetYear=session('targetYear');
		//OtherFunc::set_access_history('');
		if(isset($_SERVER['HTTP_REFERER'])){
			OtherFunc::set_access_history($_SERVER['HTTP_REFERER']);
		}

		$DefaultUsersInf=PaymentHistory::leftJoin('users', 'payment_histories.serial_user', '=', 'users.serial_user')
			->where('payment_histories.how_to_pay','=', 'default')
			->whereIn('users.serial_user', function ($query) {
				$query->select('keiyakus.serial_user')->from('keiyakus')->where('keiyakus.cancel','=', null);
			})
			->distinct()->select('name_sei','name_mei')->get();
		$html_year_slct=OtherFunc::make_html_year_slct(date('Y'));
		$html_month_slct=OtherFunc::make_html_month_slct(date('n'));
		$default_customers=OtherFunc::make_htm_get_default_user();
		$not_coming_customers=OtherFunc::make_htm_get_not_coming_customer();
		$htm_kesanMonth=OtherFunc::make_html_month_slct(initConsts::KesanMonth());
		//list($targetNameHtmFront, $targetNameHtmBack) =OtherFunc::make_htm_get_not_coming_customer();
		$csrf="csrf";
		session(['GoBackPlace' => '../ShowMenuCustomerManagement']);
		return view('teacher.MenuCustomerManagement',compact("header","slot","html_year_slct","html_month_slct","DefaultUsersInf","not_coming_customers","default_customers",'htm_kesanMonth'));
	}

}
