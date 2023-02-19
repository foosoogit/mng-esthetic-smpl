<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PaymentHistory;
use App\Models\VisitHistory;
use DateTime;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\InitConsts;
use DateInterval;
use DatePeriod;
use App\Models\TreatmentContent;
use App\Models\Branch;
use Illuminate\Support\Facades\Auth;
use App\Models\Staff;
use App\Models\Contract;
use App\Models\User;
if(!isset($_SESSION)){session_start();}

class OtherFunc extends Controller
{
	static function get_uriage($targetDay,$HowToPay,$HowMany){
		//DB::enableQueryLog();
		if(session('target_branch_serial')===null){session(['target_branch_serial'=>'all']);}
		if($HowToPay=='cash'){
			$hwtpay='現金';
		}else if($HowToPay=='card'){
			$hwtpay='Credit Card';
		}
		//$TargetQuery=DB::table('payment_histories');
		$TargetQuery=PaymentHistory::leftJoin('contracts', 'payment_histories.serial_keiyaku', '=', 'contracts.serial_keiyaku')
			->where('payment_histories.how_to_pay','=',$HowToPay)
			->where('payment_histories.date_payment','=',$targetDay);
		if(session('target_branch_serial')<>'all'){
			$TargetQuery=$TargetQuery->whereIn('payment_histories.serial_user', User::select('serial_user')->where('serial_branch','=', session('target_branch_serial')));
		}
		//dd(DB::getQueryLog());	
		//dd($TargetQuery->toSql(), $TargetQuery->getBindings());
		if(trim($HowToPay)=='cash'){
			if($HowMany=='bunkatu'){
				$TargetQuery=$TargetQuery->where(function($query) {
					$query->where('contracts.how_many_pay_genkin','>',1)->orWhere('contracts.how_many_pay_card','>',1);
				});
				/*
				if($targetDay=='2022-07-29'){
					dd($TargetQuery->toSql(), $TargetQuery->getBindings());
				//->orwhere('keiyakus.how_many_pay_card','=','1');
				}
				*/
			}else{
				//$TargetQuery=$TargetQuery->where('keiyakus.how_many_pay_genkin','=','1');
				$TargetQuery=$TargetQuery->where(function($query) {
					$query->where('contracts.how_many_pay_genkin','=',1)->orWhere('contracts.how_many_pay_card','=',1);
				});
				/*
				if($targetDay=='2022-07-29'){
					//dd($TargetQuery->toSql(), $TargetQuery->getBindings());
				//->orwhere('keiyakus.how_many_pay_card','=','1');
				}
				*/
			}
		}
		/*
		$TargetQuery=DB::table('payment_histories');
		$TargetQuery=$TargetQuery->leftJoin('contracts', 'payment_histories.serial_keiyaku', '=', 'contracts.serial_keiyaku')
			->where('payment_histories.deleted_at','=',NULL)
			->where('payment_histories.how_to_pay','=',$HowToPay)
			->where('payment_histories.date_payment','=',$targetDay);
		if($HowToPay=='cash'){
			if($HowMany=='bunkatu'){
				$TargetQuery=$TargetQuery->where(function($query) {
					$query->where('contracts.how_many_pay_genkin','>','1')->orWhere('contracts.how_many_pay_card','>','1');
				});
			}else{
				//$TargetQuery=$TargetQuery->where('keiyakus.how_many_pay_genkin','=','1');
				$TargetQuery=$TargetQuery->where(function($query) {
					$query->where('contracts.how_many_pay_genkin','=','1')->orWhere('contracts.how_many_pay_card','=','1');
				});
				//->orwhere('keiyakus.how_many_pay_card','=','1');
			}
		}
		*/
		$TargetQuery=$TargetQuery->selectRaw('SUM(amount_payment) as total');
		
		if($HowToPay=='cash' && $targetDay=='2022-07-29' && $HowMany<>'bunkatu'){
			//dd(preg_replace_array('/\?/', $TargetQuery->getBindings(), $TargetQuery->toSql()));
			//dd($TargetQuery->toSql(), $TargetQuery->getBindings());
		}
		
		$TotalAmount=$TargetQuery->first(['total']);
		$total=$TotalAmount->total+session('TotalSales');
		session(['TotalSales' =>$total]);
		session(['TotalSalesRuikei' =>session('TotalSalesRuikei')+$TotalAmount->total]);
		//$TotalSales=$TotalSales+$TotalAmount->total;
		return $TotalAmount->total;
	}

	static function day_of_the_week_dtcls($w){
		$aWeek = array(
			'日',//0
			'月',//1
			'火',//2
			'水',//3
			'木',//4
			'金',//5
			'土'//6
		);
		return $aWeek["$w"];
	}

	static function get_contract_cnt($targetDay){
		if(session('target_branch_serial')===null){session(['target_branch_serial'=>'all']);}
		if(session('target_branch_serial')=='all'){
			$contract_cnt=Contract::where('deleted_at','=',NULL)
				->where('keiyaku_bi','=',$targetDay)
				->count();
		}else{
			$contract_cnt=Contract::where('keiyaku_bi','=',$targetDay)
				->whereIn('contracts.serial_user', User::select('serial_user')->where('serial_branch','=', session('target_branch_serial')))
				->count();
		}
		/*
		$contract_cnt=DB::table('contracts')
			->where('deleted_at','=',NULL)
			->where('keiyaku_bi','=',$targetDay)
			->count();
		*/
		return $contract_cnt; 
	}

	public static function get_raijyosyasu_cnt($targetDay){
		if(session('target_branch_serial')===null){ 
			session(['target_branch_serial'=>'all']);
		}
		if(session('target_branch_serial')=='all'){
			$visiters_inf_array=VisitHistory::where('date_visit','=',$targetDay)->get();
		}else{
			$visiters_inf_array=VisitHistory::where('date_visit','=',$targetDay)
			->whereIn('visit_histories.serial_user', User::select('serial_user')->where('serial_branch','=', session('target_branch_serial')))
			->get();
		}
		$new_visiters_cnt=0;$all_visiters_cnt=0;$member_visiters_cnt=0;
		foreach($visiters_inf_array as $visiters_inf){
			$get_min_visit=DB::table('visit_histories')
				->where('serial_user','=',$visiters_inf->serial_user)
				->min('date_visit');
			if($get_min_visit==$targetDay){
				$new_visiters_cnt++;
			}else{
				$member_visiters_cnt++;
			}
			$all_visiters_cnt++;
		}
		/*
		$visiters_inf_array=DB::table('visit_histories')
			->where('deleted_at','=',NULL)
			->where('date_visit','=',$targetDay)
			->get();
		$new_visiters_cnt=0;$all_visiters_cnt=0;$member_visiters_cnt=0;
		foreach($visiters_inf_array as $visiters_inf){
			$get_min_visit=DB::table('visit_histories')
				->where('serial_user','=',$visiters_inf->serial_user)
				->min('date_visit');
			if($get_min_visit==$targetDay){
				$new_visiters_cnt++;
			}else{
				$member_visiters_cnt++;
			}
			$all_visiters_cnt++;
		}
		*/
		session(['new_visiters_cnt' =>$new_visiters_cnt]);
		session(['member_visiters_cnt' =>$new_visiters_cnt]);
		session(['all_visiters_cnt' =>$all_visiters_cnt]);
		return array($new_visiters_cnt, $member_visiters_cnt,$all_visiters_cnt); 
	}

	public static function make_html_monthly_report_table($targetYear,$targetMonth){
		$sbj_array=array();
		$htm_month_table="";
		$sbj_array=['日','ｸﾚｼﾞｯﾄ・ﾛｰﾝ','月額','現金','合計売上','累計売上','新規<br>来店数','会員<br>来店数','来店<br>合計','累計<br>来店数','契約<br>人数','累計<br>契約数','契約率'];
		$htm_month_table='<table class="table-auto" border-solid>';
		//$htm_month_table.='<table class="table-auto" border-solid><thead><tr>';
		foreach($sbj_array as $value){
			$htm_month_table.='<th class="border px-4 py-2">'.$value.
			'<!--<button type="button" wire:click="sort(\'serial_user-ASC\')"><img src="{{ asset(\'storage/images/sort_A_Z.png\') }}" width="15px" /></button>
			<button type="button" wire:click="sort(\'serial_user-Desc\')"><img src="{{ asset(\'storage/images/sort_Z_A.png\') }}" width="15px" /></button>-->
			</th>';
		}
		$date = $targetYear.'-'.$targetMonth;
		$begin = new DateTime(date('Y-m-d', strtotime('first day of '. $date)));
		$end = new Datetime(date('Y-m-d', strtotime('first day of next month '. $date)));
		$interval = new DateInterval('P1D');
		$daterange = new DatePeriod($begin, $interval, $end);
		$htm_month_table.='<tbody>';
		$ruikei_visiters_cnt=0;$ruikei_contract_cnt=0;
		$amount_card=0;$total_amount_card=0;$amount_cash_bunkatu=0;$total_mount_cash_bunkatu=0;
		$amount_cash_uriage=0;$total_amount_cash_uriage=0;$total_new_visiters_cnt=0;$total_member_visiters_cnt=0;

		session(['TotalSalesRuikei' =>0]);
		foreach($daterange as $date){
			session(['TotalSales' => 0]);
			list($new_visiters_cnt, $member_visiters_cnt,$all_visiters_cnt) = self::get_raijyosyasu_cnt($date->format("Y-m-d"));
			
			$total_new_visiters_cnt=$total_new_visiters_cnt+$new_visiters_cnt;
			$total_member_visiters_cnt=$total_member_visiters_cnt+$member_visiters_cnt;
			$contract_cnt=self::get_contract_cnt($date->format("Y-m-d"));
			$ruikei_visiters_cnt=$ruikei_visiters_cnt+$all_visiters_cnt;
			$ruikei_contract_cnt=$ruikei_contract_cnt+$contract_cnt;
			$yobi= self::day_of_the_week_dtcls($date->format('w'));
			
			$amount_card=self::get_uriage($date->format("Y-m-d"),'card','');
			$total_amount_card=$total_amount_card+$amount_card;
			
			$amount_cash_bunkatu=self::get_uriage($date->format("Y-m-d"),'cash','bunkatu');
			$total_mount_cash_bunkatu=$total_mount_cash_bunkatu+$amount_cash_bunkatu;
			
			$amount_cash_uriage=self::get_uriage($date->format("Y-m-d"),'cash','');
			
			//print "amount_cash_uriage=".$amount_cash_uriage."<br>";
			$total_amount_cash_uriage=$total_amount_cash_uriage+$amount_cash_uriage;
			
			$colorRed="";
			if($yobi=='日'){
				$colorRed='style="color:red"';
			}else if($yobi=='土'){
				$colorRed='style="color:blue"';
			}
			$keiyakuritu="--";
			if($all_visiters_cnt>0){
				$keiyakuritu=number_format(round($new_visiters_cnt/$all_visiters_cnt*100,1), 1);
			}
			$htm_month_table.='
				<tr>
					<td class="border px-4 py-2" style="text-align: middle;"><button type="submit" name="target_date_from_monthly_rep" value="'.$date->format("Y-m-d").'"><span '.$colorRed.'>'.$date->format("Y-m-d").'('.$yobi.')</span></button>
</td>
					<td class="border px-4 py-2" style="text-align: right;">'.number_format($amount_card).'</td>
					<td class="border px-4 py-2" style="text-align: right;">'.number_format($amount_cash_bunkatu).'</td>
					<td class="border px-4 py-2" style="text-align: right;">'.number_format($amount_cash_uriage).'</td>
					<td class="border px-4 py-2" style="text-align: right;">'.number_format(session('TotalSales')).'</td>
					<td class="border px-4 py-2" style="text-align: right;">'.number_format(session('TotalSalesRuikei')).'</td>
					<td class="border px-4 py-2" style="text-align: right;">'.number_format($new_visiters_cnt).'</td>
					<td class="border px-4 py-2" style="text-align: right;">'.number_format($member_visiters_cnt).'</td>
					<td class="border px-4 py-2" style="text-align: right;">'.number_format($all_visiters_cnt).'</td>
					<td class="border px-4 py-2" style="text-align: right;">'.number_format($ruikei_visiters_cnt).'</td>
					<td class="border px-4 py-2" style="text-align: right;">'.number_format($contract_cnt).'</td>
					<td class="border px-4 py-2" style="text-align: right;">'.number_format($ruikei_contract_cnt).'</td>
					<td class="border px-4 py-2" style="text-align: right;">'.$keiyakuritu.'</td>
				</tr>';
		}
		$htm_month_table.='
				<tr>
					<td class="border px-4 py-2" style="text-align: middle;">合計</td>
					<td class="border px-4 py-2" style="text-align: right;">'.number_format($total_amount_card).'</td>
					<td class="border px-4 py-2" style="text-align: right;">'.number_format($total_mount_cash_bunkatu).'</td>
					<td class="border px-4 py-2" style="text-align: right;">'.number_format($total_amount_cash_uriage).'</td>
					<td class="border px-4 py-2" style="text-align: right;">'.number_format(session('TotalSalesRuikei')).'</td>
					<td class="border px-4 py-2" style="text-align: right;">'.number_format(session('TotalSalesRuikei')).'</td>
					<td class="border px-4 py-2" style="text-align: right;">'.number_format($total_new_visiters_cnt).'</td>
					<td class="border px-4 py-2" style="text-align: right;">'.number_format($total_member_visiters_cnt).'</td>
					<td class="border px-4 py-2" style="text-align: right;">'.number_format($ruikei_visiters_cnt).'</td>
					<td class="border px-4 py-2" style="text-align: right;">'.number_format($ruikei_visiters_cnt).'</td>
					<td class="border px-4 py-2" style="text-align: right;">'.number_format($ruikei_contract_cnt).'</td>
					<td class="border px-4 py-2" style="text-align: right;">'.number_format($ruikei_contract_cnt).'</td>
					<td class="border px-4 py-2">&nbsp;</td>
				</tr>';
		$htm_month_table.='</tbody>';
		$htm_month_table.='</tr></thead></table>';
		return $htm_month_table;
	}

	public static function get_raitenReason($targetYear,$targetMonth){
		$key=$targetYear."-".sprintf('%02d', $targetMonth);
		//print "key=".$key;
		$reason_coming_array=explode(",", initConsts::ReasonsComing());
		$htm_raitenReason_array=array();
		foreach($reason_coming_array as $value){
			$reason_cnt=0;
			$reason_cnt=DB::table('users')
			->where('deleted_at','=',NULL)
			->where('admission_date','like',$key."%")
			->where('reason_coming','like',"%".$value."%")
			->count();
			//dd(\DB::getQueryLog());	
			//dd($reason_cnt->toSql(), $reason_cnt->getBindings());
			//dd($reason_cnt->getBindings());
			$htm_raitenReason_array[]=$value." : ".$reason_cnt;
		}
		$htm_raitenReason=implode("&nbsp;&nbsp;",$htm_raitenReason_array);
		return $htm_raitenReason; 
	}

	public static function make_html_branch_rdo_for_monthly_report(){
		$branches=Branch::all();
		if(session('target_branch_serial')==""){
			$selected_branch=Auth::user()->selected_branch;
		}else{
			$selected_branch=session('target_branch_serial');
		}
		$cked="";
		if($selected_branch=="all"){$cked="checked";}
		$htm_branch_cbox='<div class="form-group"><fieldset>';
		$branchSerial="'all'";
		//$htm_branch_cbox.='&nbsp;<input wire:click="select_branch_for_daily_report('.$branchSerial.')" name="branch_rdo" id="branch_rdo_all" type="radio" value="all" '.$cked.' /><label class="label" for="branch_rdo_all">&nbsp;全店舗</label></label>&nbsp&nbsp;';
		//$htm_branch_cbox.='&nbsp;<input onchange="ChangeTargetMonth();" name="branch_rdo" id="branch_rdo_all" type="radio" value="all" '.$cked.' /><label class="label" for="branch_rdo_all">&nbsp;全店舗</label></label>&nbsp&nbsp;';
		$htm_branch_cbox.='&nbsp;<input wire:click="select_branch('.$branchSerial.')" name="branch_rdo" id="branch_rdo_all" type="radio" value="all" '.$cked.' /><label class="label" for="branch_rdo_all">&nbsp;全店舗</label></label>&nbsp&nbsp;';
		foreach($branches as $branch){
			$cked="";$branchSerial="";
			if($selected_branch==$branch->serial_branch){$cked="checked";}
			$branchSerial="'".$branch->serial_branch."'";
			//$htm_branch_cbox.='&nbsp;<input wire:click="select_branch_for_daily_report('.$branchSerial.')"  name="branch_rdo" id="branch_rdo_'.$branch->serial_branch.'" type="radio" value="'.$branch->serial_branch.'" '.$cked.' />&nbsp;<label class="label" for="branch_rdo_'.$branch->serial_branch.'">'.$branch->name_branch.'</label>&nbsp&nbsp;';
			//$htm_branch_cbox.='&nbsp;<input onchange="ChangeTargetMonth(this);"  name="branch_rdo" id="branch_rdo_'.$branch->serial_branch.'" type="radio" value="'.$branch->serial_branch.'" '.$cked.' />&nbsp;<label class="label" for="branch_rdo_'.$branch->serial_branch.'">'.$branch->name_branch.'</label>&nbsp&nbsp;';
			$htm_branch_cbox.='&nbsp;<input wire:click="select_branch('.$branchSerial.')" name="branch_rdo" id="branch_rdo_'.$branch->serial_branch.'" type="radio" value="'.$branch->serial_branch.'" '.$cked.' />&nbsp;<label class="label" for="branch_rdo_'.$branch->serial_branch.'">'.$branch->name_branch.'</label>&nbsp&nbsp;';
		}
		$htm_branch_cbox.='</fieldset></div>';
		return $htm_branch_cbox;
	}

	public static function make_html_branch_rdo_for_daily_report(){
		$branches=Branch::all();
		if(session('target_branch_serial')==""){
			$selected_branch=Auth::user()->selected_branch;
		}else{
			$selected_branch=session('target_branch_serial');
		}
		$cked="";
		if($selected_branch=="all"){$cked="checked";}
		$htm_branch_cbox='<div class="form-group"><fieldset>';
		$branchSerial="'all'";
		//$htm_branch_cbox.='&nbsp;<input wire:click="select_branch_for_daily_report('.$branchSerial.')" name="branch_rdo" id="branch_rdo_all" type="radio" value="all" '.$cked.' /><label class="label" for="branch_rdo_all">&nbsp;全店舗</label></label>&nbsp&nbsp;';
		$htm_branch_cbox.='&nbsp;<input onchange="getTargetdata(this);" name="branch_rdo" id="branch_rdo_all" type="radio" value="all" '.$cked.' /><label class="label" for="branch_rdo_all">&nbsp;全店舗</label></label>&nbsp&nbsp;';
		foreach($branches as $branch){
			$cked="";$branchSerial="";
			if($selected_branch==$branch->serial_branch){$cked="checked";}
			$branchSerial="'".$branch->serial_branch."'";
			//$htm_branch_cbox.='&nbsp;<input wire:click="select_branch_for_daily_report('.$branchSerial.')"  name="branch_rdo" id="branch_rdo_'.$branch->serial_branch.'" type="radio" value="'.$branch->serial_branch.'" '.$cked.' />&nbsp;<label class="label" for="branch_rdo_'.$branch->serial_branch.'">'.$branch->name_branch.'</label>&nbsp&nbsp;';
			$htm_branch_cbox.='&nbsp;<input onchange="getTargetdata(this);"  name="branch_rdo" id="branch_rdo_'.$branch->serial_branch.'" type="radio" value="'.$branch->serial_branch.'" '.$cked.' />&nbsp;<label class="label" for="branch_rdo_'.$branch->serial_branch.'">'.$branch->name_branch.'</label>&nbsp&nbsp;';
		}
		$htm_branch_cbox.='</fieldset></div>';
		return $htm_branch_cbox;
	}

	public static function make_html_branch_rdo_for_inp_customer($target_branch_serial){
		$branches=Branch::all();
		$htm_branch_cbox='<div class="form-group"><fieldset>';
		foreach($branches as $branch){
			$cked="";
			if($target_branch_serial==$branch->serial_branch){$cked="checked";}
			$branchSerial="'".$branch->serial_branch."'";
			$htm_branch_cbox.='&nbsp;<input name="branch_rdo" id="branch_rdo_'.$branch->serial_branch.'" type="radio" value="'.$branch->serial_branch.'" '.$cked.' />&nbsp;<label class="label" for="branch_rdo_'.$branch->serial_branch.'">'.$branch->name_branch.'</label>&nbsp&nbsp;';
		}
		$htm_branch_cbox.='</fieldset></div>';
		return $htm_branch_cbox;
	}
	public static function make_html_branch_rdo(){
		$branches=Branch::all();
		if(session('target_branch_serial')==""){
			$selected_branch=Auth::user()->selected_branch;
		}else{
			$selected_branch=session('target_branch_serial');
		}
		$cked="";
		if($selected_branch=="all"){$cked="checked";}
		$htm_branch_cbox='<div class="form-group"><fieldset>';
		$branchSerial="'all'";
		$htm_branch_cbox.='&nbsp;<input wire:click="select_branch('.$branchSerial.')" name="branch_rdo" id="branch_rdo_all" type="radio" value="all" '.$cked.' /><label class="label" for="branch_rdo_all">&nbsp;全店舗</label></label>&nbsp&nbsp;';
		foreach($branches as $branch){
			$cked="";$branchSerial="";
			if($selected_branch==$branch->serial_branch){$cked="checked";}
			$branchSerial="'".$branch->serial_branch."'";
			$htm_branch_cbox.='&nbsp;<input wire:click="select_branch('.$branchSerial.')"  name="branch_rdo" id="branch_rdo_'.$branch->serial_branch.'" type="radio" value="'.$branch->serial_branch.'" '.$cked.' />&nbsp;<label class="label" for="branch_rdo_'.$branch->serial_branch.'">'.$branch->name_branch.'</label>&nbsp&nbsp;';
		}
		$htm_branch_cbox.='</fieldset></div>';
		return $htm_branch_cbox;
	}

	public static function make_htm_get_not_coming_customer(){
		$today = new DateTime('now');
		if(session('target_branch_serial')=="all"){
			$keyakukaisu=DB::table('contracts')
					->where('cancel','=',null)
					->where('how_to_pay','=','現金')
					->get();
		}else{
			$keyakukaisu=DB::table('contracts')->leftJoin('users', 'contracts.serial_user', '=', 'users.serial_user')
					->where('cancel','=',null)
					->where('how_to_pay','=','現金')
					->where('users.serial_branch','=',session('target_branch_serial'))
					->get();
		}
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
					$targetNameHtm.='<input type="submit" formaction="/customers/ShowInpRecordVisitPayment/'.$value->serial_keiyaku.'/'.$value->serial_user.'" name="btn_serial" value="'.$terget_user->name_sei.' '.$terget_user->name_mei.'">&nbsp';
				}
			}
		}
		return $targetNameHtm;
	}

	public static function make_htm_get_default_user(){
		if(session('target_branch_serial')=="all"){
			$DefaultUsersInf=PaymentHistory::leftJoin('users', 'payment_histories.serial_user', '=', 'users.serial_user')
			->where('payment_histories.how_to_pay','=', 'default')
			->whereIn('users.serial_user', function ($query) {
				$query->select('contracts.serial_user')->from('contracts')->where('contracts.cancel','=', null);
			})
			->distinct()->select('name_sei','name_mei','payment_histories.serial_user')->get();
		}else{
			$DefaultUsersInf=PaymentHistory::leftJoin('users', 'payment_histories.serial_user', '=', 'users.serial_user')
			->where('payment_histories.how_to_pay','=', 'default')
			->where('users.serial_branch','=', session('target_branch_serial'))
			->whereIn('users.serial_user', function ($query) {
				$query->select('contracts.serial_user')->from('contracts')->where('contracts.cancel','=', null);
			})
			->distinct()->select('name_sei','name_mei','payment_histories.serial_user')->get();
		}
		$targetNameHtm="";
		foreach($DefaultUsersInf as $value){
			$targetNameHtm.='<button type="submit" name="btn_serial" value="'.$value->serial_user.'">'.$value->name_sei.' '.$value->name_mei.'&nbsp;</button>';
		}
		return $targetNameHtm;
	}
		
	public static function make_html_card_company_slct($targetCompany){
		$cmp="";
		$cmps=DB::table('configrations')->select('value1')->where('subject', '=', 'Card Company')->get();
		foreach($cmps as $cmp){
			$cmp= $cmp->value1;
		}
		$companyArray=array();
		$companyArray=explode(",",$cmp);
		$htm_company_slct="";
		foreach ($companyArray as $company){
			$sct='';
			if($company==$targetCompany){$sct='Selected';}
			$htm_company_slct.='<option  value="'.$company.'" '.$sct.'>'.$company.'</option>';
		}
		return $htm_company_slct;
	}

	public static function make_html_TreatmentsTimes_slct($targetTimes){
		$htm_TreatmentsTimes_slct='';
		$htm_TreatmentsTimes_slct='<select name="TreatmentsTimes_slct" id="TreatmentsTimes_slct">';
		$htm_TreatmentsTimes_slct.='<option value=0>-- 選択してください --</option>';

		for($i = 1; $i<= initConsts::MaxTreatmentsTimes(); $i++){
			$sct='';
			if($i==$targetTimes){$sct='Selected';}
			$htm_TreatmentsTimes_slct.='<option value="'.$i.'" '.$sct.'>'.$i.'</option>';
		}
		$htm_TreatmentsTimes_slct.='</select>';
		return $htm_TreatmentsTimes_slct;
	}

	public static function make_htm_get_treatment_slct($TargetTreatmentName){
		$kana = array(
			"ア行" => "[ア-オあ-お]",
			"カ行" => "[カ-コガ-ゴか-こが-ご]",
			"サ行" => "[サ-ソザ-ゾさ-そざ-ぞ]",
			"タ行" => "[タ-トダ-ドた-とだ-ど]",
			"ナ行" => "[ナ-ノな-の]",
			"ハ行" => "[ハ-ホバ-ボパ-ポは-ほば-ぼぱ-ぽ]",
			"マ行" => "[マ-モま-も]",
			"ヤ行" => "[ヤ-ヨや-よ]",
			"ラ行" => "[ラ-ロら-ろ]",
			"ワ行" => "[ワ-ンわ-ん]",
			"その他" => ".*"
		);
		$treatmentInfArray=TreatmentContent::orderBy('name_treatment_contents_kana')->get();
		$htm_TreatmentsName_slct='<option value=0>-- 選択してください --</option>';
		$tgtGrp="";
		//$html_customer_list_slct.='<optgroup label="'.$tgtGrp.'>';
		foreach($treatmentInfArray as $value){
			$match = false;$flg=false;$cnt=0;$k=0;
			foreach ($kana as $index => $pattern) {
				//if($tgtGrp<>$index){$html_customer_list_slct.='<optgroup label="'.$index.'">';}
				if (preg_match("/^" . $pattern . "/u", $value->name_treatment_contents_kana)) {
					++$cnt;
					if($tgtGrp<>$index){
						$htm_TreatmentsName_slct.='<optgroup label="'.$index.'">';
						$tgtGrp=$index;

						if($cnt>1){$htm_TreatmentsName_slct.='</optgroup>';}
					};
					$sct='';
					if($TargetTreatmentName==$value->name_treatment_contents){
						//print "TargetTreatmentName=".$TargetTreatmentName."<br>";
						$sct='Selected';
						//print "sct=".$sct."<br>";
					}
					//$htm_TreatmentsName_slct.='<option value="'.$value->name_treatment_contents.'" '.$sct.'>'.$value->name_treatment_contents.'('.$value->treatment_details.')</option>';
					$htm_TreatmentsName_slct.='<option value="'.$value->name_treatment_contents.'" '.$sct.'>'.$value->name_treatment_contents.'</option>';
					break;
				}
				++$k;
			}
		}		
		return $htm_TreatmentsName_slct;
	}

	public static function make_html_how_many_slct($targetNum,$MaxNum,$MinmumNUm){
		$htm_num_slct="";
		for($i=$MinmumNUm;$i<=$MaxNum;$i++){
			$sct='';
			if($targetNum==$i){$sct='selected';}
			$htm_num_slct.='<option  value="'.$i.'" '.$sct.'>'.$i.'</option>';
		}
		return $htm_num_slct;
	}

	public static function make_html_keiyaku_num_slct($targetNum){
		$keiyaku_num = DB::table('configrations')->select('value1')->where('subject', '=', 'KeiyakuNumMax')->first();
		$htm_keiyaku_num_slct="";
		for ($num=1;$num<=$keiyaku_num->value1 ;$num++){
			$sct='';
			if($targetNum==$num){$sct='Selected';}
			$htm_keiyaku_num_slct.='<option  value="'.$num.'" '.$sct.'>'.$num.'</option>';
		}
		return $htm_keiyaku_num_slct;
	}

	public static function make_html_reason_coming_cbox($targetSbj){
		$reason_coming_array=explode(",", initConsts::ReasonsComing());
		$targetSbjArray=explode(",", $targetSbj);
		$htm_reason_coming_cbox='';$sonotaReason="";
		foreach($reason_coming_array as $reason){
			$cked="";
			if(strstr($targetSbj, $reason)<>false){	$cked='checked';}
			if($reason<>"その他"){
				$htm_reason_coming_cbox.='<label><input name="reason_coming_cbx[]" type="checkbox" value="'.$reason.'" '.$cked.' />'.$reason.'</label>';
			}else{
				$htm_reason_coming_cbox.='<label><input name="reason_coming_cbx[]" id="reason_coming_cbx_sonota" type="checkbox" value="その他" onchange="reason_coming_sonota_manage();" '.$cked.' />その他</label>';
				if($cked=='checked'){
					$sonotaArray=array();
					$sonotaArray=explode("(", $targetSbj);
					if(count($sonotaArray)>1){
						$sonotaReason=str_replace(')', '', $sonotaArray[1]);
					}
				}
			}
		}
		$htm_reason_coming_cbox.='<br><input name="reason_coming_txt" id="reason_coming_txt" type="text" value="'.$sonotaReason.'" />';
		return $htm_reason_coming_cbox;
	}

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

	public static function make_html_slct_birth_year_list($targetYear){
		$htm_birth_year_list="";
		$this_year=date("Y");
		
		for($i=$this_year-65;$i<=$this_year;$i++){
			$selected="";
			$gengou=self::wareki($i);
			if($targetYear=="" and $i==$this_year-30){
				$selected="selected";
			}else if($i==$targetYear){
				$selected="selected";
			}
			
			$htm_birth_year_list.='<option value="'.$i.'" '.$selected.' >'.$i.'('.$gengou.')</option>';
		}
		return $htm_birth_year_list;
	}
	public static function wareki($year) {
		$eras = [
			['year' => 2018, 'name' => '令和'],
			['year' => 1988, 'name' => '平成'],
			['year' => 1925, 'name' => '昭和'],
			['year' => 1911, 'name' => '大正'],
			['year' => 1867, 'name' => '明治']
		];
	
	    foreach($eras as $era) {
	        $base_year = $era['year'];
	        $era_name = $era['name'];
	        if($year > $base_year) {
	            $era_year = $year - $base_year;
	            if($era_year === 1) {
	                return $era_name .'元年';
	            }
	            return $era_name . $era_year;
	        }
	    }
	    return null;
	}
}