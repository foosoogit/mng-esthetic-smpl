<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PaymentHistory;
use DateTime;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\InitConsts;
use DateInterval;
use DatePeriod;
use App\Models\TreatmentContent;
use App\Models\Branch;
use Illuminate\Support\Facades\Auth;

class OtherFunc extends Controller
{
	public static function make_html_branch_cbox(){
		$branches=Branch::all();
		$selected_branch=Auth::user()->selected_branch;
		$cked="";
		$htm_branch_cbox='<div class="form-group">';
		//if($selected_branch=="all"){$cked="checked"	;}
		//$htm_branch_cbox.='&nbsp;<input class="form-check-input" name="branch_cbx" id="branch_cbx_all" type="checkbox" value="all" onchange="branch_cbox_manage(this);" '.$cked.' /><label style="font-size: larger;vertical-align:middle;" for="branch_cbx_all">&nbsp;全店舗</label></label>&nbsp&nbsp;';
		foreach($branches as $branch){
			$cked="";
			if($selected_branch==$branch->serial_branch){$cked="checked";}
			$htm_branch_cbox.='&nbsp;<input class="form-check-input" name="branch_cbx" id="branch_cbx_'.$branch->serial_branch.'" type="checkbox" value="'.$branch->serial_branch.'" onchange="branch_cbox_manage(this);" '.$cked.' />&nbsp;<label style="font-size: larger;vertical-align:middle;" for="branch_cbx_'.$branch->serial_branch.'">'.$branch->name_branch.'</label>&nbsp&nbsp;';
		}
		$htm_branch_cbox.='</div>';
		return $htm_branch_cbox;
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

	public static function make_htm_get_default_user(){
		$DefaultUsersInf=PaymentHistory::leftJoin('users', 'payment_histories.serial_user', '=', 'users.serial_user')
			->where('payment_histories.how_to_pay','=', 'default')
			->whereIn('users.serial_user', function ($query) {
				$query->select('contracts.serial_user')->from('contracts')->where('contracts.cancel','=', null);
			})
			->distinct()->select('name_sei','name_mei','payment_histories.serial_user')->get();
		$targetNameHtm="";
		foreach($DefaultUsersInf as $value){
			$targetNameHtm.='<button type="submit" name="btn_serial" value="'.$value->serial_user.'">'.$value->name_sei.' '.$value->name_mei.'&nbsp;</button>';
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
					//DB::table('users')->where('serial_user','=', $value->serial_user)->dd();
					//print_r($terget_user);
					$targetNameHtm.='・<input type="submit" formaction="/customers/ShowInpRecordVisitPayment/'.$value->serial_keiyaku.'/'.$value->serial_user.'" name="btn_serial" value="'.$terget_user->name_sei.' '.$terget_user->name_mei.'">&nbsp';
				}
			}
		}
		return $targetNameHtm;
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
