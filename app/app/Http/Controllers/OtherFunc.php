<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PaymentHistory;
use DateTime;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\InitConsts;

class OtherFunc extends Controller
{
    public static function set_access_history($REFERER){
		//print isset($_SESSION['access_history']);
		if(isset($_SESSION['access_history'])){
			if(is_array($_SESSION['access_history'])){
				array_unshift($_SESSION['access_history'],$REFERER);
			}else{
				$_SESSION['access_history']=array();
				$_SESSION['access_history'][]=$REFERER;
			}
		}else{
			$_SESSION['access_history']=array();
			$_SESSION['access_history'][]=$REFERER;
		}
	}

	public static function make_html_year_slct($targetYear){
		$htm_year_slct='';

		//$cmp="";
		for($i = 2015; $i<= $targetYear; $i++){
			$sct='';
			if($i==$targetYear){$sct='Selected';}
			$htm_year_slct.='<option  value="'.$i.'" '.$sct.'>'.$i.'年</option>';
		}
		return $htm_year_slct;
	}

	public static function make_html_month_slct($targetMonth){
		$htm_month_slct='';
		for($i = 1; $i<= 12; $i++){
			$sct='';
			if($i==$targetMonth){$sct='Selected';}
			$htm_month_slct.='<option value="'.$i.'" '.$sct.'>'.$i.'月</option>';
		}
		return $htm_month_slct;
	}

	public static function make_htm_get_default_user(){
		$DefaultUsersInf=PaymentHistory::leftJoin('users', 'payment_histories.serial_user', '=', 'users.serial_user')
			->where('payment_histories.how_to_pay','=', 'default')
			->whereIn('users.serial_user', function ($query) {
				$query->select('contracts.serial_user')->from('contracts')->where('contracts.cancel','=', null);
			})
			->distinct()->select('name_sei','name_mei','payment_histories.serial_user')->get();
		$targetNameHtm="";
		foreach($DefaultUsersInf as $value){
			$targetNameHtm.='<button type="submit" name="btn_serial" value="'.$value->serial_user.'">・'.$value->name_sei.' '.$value->name_mei.'&nbsp;</button>';
		}
		return $targetNameHtm;
	}

	public static function make_htm_get_not_coming_customer(){
		$today = new DateTime('now');
		$keyakukaisu=DB::table('contracts')
			->where('cancel','=',null)
			->where('how_to_pay','=','現金')
			->get();
		$targetName=array();$targetNameHtmFront=array();$targetNameHtmBack=array();
		$targetNameHtm="";
		foreach($keyakukaisu as $value){
			$num_payed=DB::table('payment_histories')->where('serial_keiyaku','=',$value->serial_keiyaku)->count();
			if($num_payed<$value->how_many_pay_genkin){
				$payment_date_latest=DB::table('payment_histories')->where('serial_keiyaku','=',$value->serial_keiyaku)->max('date_payment');
				$payment_date_latest_dt = new DateTime($payment_date_latest);
				$diff = $today->diff($payment_date_latest_dt);
				$interval_day=$diff->format('%a');
				if($interval_day>30){
					$terget_user=DB::table('users')->where('serial_user','=', $value->serial_user)->first();
					$targetNameHtm.='・<input type="submit" formaction="/customers/ShowInpRecordVisitPayment/'.$value->serial_keiyaku.'/'.$value->serial_user.'" name="btn_serial" value="'.$terget_user->name_sei.' '.$terget_user->name_mei.'">&nbsp';
				}
			}
			
		}
		return $targetNameHtm;
	}


}
