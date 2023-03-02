<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;
use App\Http\Controllers\OtherFunc;
use App\Models\PaymentHistory;
use App\Models\Contract;
use App\Http\Controllers\InitConsts;
use App\Models\User;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Storage;
use App\Models\ContractDetail;
use App\Models\VisitHistory;
use App\Models\Branch;
use App\Models\TreatmentContent;

class StaffController extends Controller
{
    use WithPagination;
	public function __construct(){
		$this->middleware('auth:staff');
	}

	public function deleteTreatmentContent($TreatmentContentSerial){
		$deleTreatmentContent=TreatmentContent::where('serial_treatment_contents','=',$TreatmentContentSerial)->delete();
		$this::save_recorder("deleteTreatmentContent");
		return redirect('/workers/ShowTreatmentContents');
	}

	public function SaveTreatmentContent(Request $request){
		$targetData=[
			'created_at' => date('Y-m-d H:i:s'),
			'serial_treatment_contents' => $request->serial_TreatmentContent,
			'name_treatment_contents' => $request->TreatmentContent_name,
			'name_treatment_contents_kana' => $request->TreatmentContent_name_kana,
			'treatment_details' => $request->TreatmentContent_details,
			'memo' => $request->memo,
		];
		TreatmentContent::upsert($targetData,['serial_treatment_contents']);
		session()->flash('success', '登録しました。');
		$this::save_recorder("SaveTreatmentContent");
		return redirect('/workers/ShowTreatmentContents');
	}

	public function ShowSyuseiTreatmentContent($TreatmentContentSerial){
		//print "TreatmentContentSerial=".$TreatmentContentSerial;
		$header="";$slot="";
		$GoBackPlace="/workers/ShowTreatmentContents";$saveFlg="";
		if($TreatmentContentSerial=="new"){
			$maxSerial=DB::table('treatment_contents')->max('serial_treatment_contents');
			if($maxSerial==""){
				$targetTreatmentContentSerial="Tr_000001";
			}else{
				$targetTreatmentContentSerial=++$maxSerial;
			}
			$TreatmentContentInf=array();$btnDisp="新規登録";
			//$targetGoodSerial=$maxSerial;
			session(['TreatmentContentSerial' => $targetTreatmentContentSerial]);
			return view('staff.CreateTreatmentContents',compact("header","slot",'targetTreatmentContentSerial','TreatmentContentInf',"GoBackPlace","btnDisp","saveFlg"));
		}else{
			session(['TreatmentContentmanage' => 'new']);
			$TreatmentContentInf=TreatmentContent::where('serial_treatment_contents','=',$TreatmentContentSerial)->first();
			$btnDisp="修正";
			$targetTreatmentContentSerial=$TreatmentContentSerial;
			session(['targetGoodSerial' => $TreatmentContentSerial]);
			return view('staff.CreateTreatmentContents',compact("header","slot",'targetTreatmentContentSerial','TreatmentContentInf',"GoBackPlace","btnDisp","saveFlg"));
		}
	}
	
	public function ShowBranchRegistration($target_branch_serial){
		$target_branch_inf="";
		if($target_branch_serial<>"new"){
			$target_branch_inf=Branch::where('serial_branch','=',$target_branch_serial)->first();
		}
		return view('staff.CreateBranch',compact('target_branch_inf'));
	}
	
	function upsertBranch(Request $request){
		if($request->serial_branch=="new"){
			$serialMax=Branch::max('serial_branch');
			if($serialMax==""){
				$targetSerial="B_001";
			}else{
				$targetSerial=++$serialMax;
			}
		}else{
			$targetSerial=$request->serial_branch;
		}
		$targetData=[
			'serial_branch' => $targetSerial,
			'name_branch' => $request->name_branch,
			'postal'=> $request->zip01,
			'address_branch' => $request->addr01,
			'email' => $request->mail,
			'phone_branch' => $request->phone,
			'open_date' => $request->opened_date,
			'note' => $request->note,
		];
		$targetDataArray[]=$targetData;

		//$PaymentHistorySerial++;
		Branch::upsert($targetDataArray,['serial_branch']);
		return redirect('/workers/ShowBranchList');
	}

	public function ShowBranchList(){
		return view('staff.BranchList');
	}

	public function deleteContract($serial_contract,$serial_user){
		$header="";$slot="";
		$delContract=Contract::where('serial_keiyaku','=',$serial_contract)->delete();
		$delContractDetails=Contract::where('serial_keiyaku','=',$serial_contract)->delete();
		$delPaymentHistory=PaymentHistory::where('serial_keiyaku','=',$serial_contract)->delete();
		$delVisitHistory=VisitHistory::where('serial_keiyaku','=',$serial_contract)->delete();

		return redirect('/customers/ShowContractList/'.$serial_user);
	}

	public function ShowSyuseiContract($ContractSerial,$UserSerial){
		session(['ContractManage' => 'syusei']);
		session(['fromPage' => 'SyuseiContract']);
		if(isset($_SERVER['HTTP_REFERER'])){
			OtherFunc::set_access_history($_SERVER['HTTP_REFERER']);
		}
		$header="";$slot="";$selectedManth=array();$selectedManth=array();
		$newKeiyakuSerial=$ContractSerial;
		$targetContract=Contract::where('serial_keiyaku','=', $ContractSerial)->first();
		$targetContractdetails=ContractDetail::where('serial_keiyaku','=', $ContractSerial)->get();
		$targetUser=User::where('serial_user','=', $UserSerial)->first();
		$HowToPay=array();$HowToPay['card']="";$HowToPay['cash']="";
		$CardCompany="";$HowManyPay=array();
		
		$HowManyPay['CashSlct']=OtherFunc::make_html_how_many_slct($targetContract->how_many_pay_genkin,20,1);	
		$HowManyPay['CardSlct']=OtherFunc::make_html_how_many_slct("",20,2);
		if($targetContract->how_to_pay=="Credit Card"){
			$HowToPay['card']='checked';
			$CardCompany=$targetContract->card_company;
			$HowManyPay['one']="";$HowManyPay['bunkatu']="";
			if($targetContract->how_many_pay_card==1){
				$HowManyPay['one']="Checked";
			}else{
				$HowManyPay['bunkatu']="Checked";
				$HowManyPay['CardSlct']=OtherFunc::make_html_how_many_slct($targetContract->how_many_pay_card,20,2);		
			}
		}else{
			$HowToPay['cash']='checked';
			$HowManyPay['CashSlct']=OtherFunc::make_html_how_many_slct($targetContract->how_many_pay_genkin,20,1);			
		}
		$CardCompanySelect=OtherFunc::make_html_card_company_slct($CardCompany);

		$KeiyakuNaiyouArray=array();$KeiyakuNumSlctArray=array();$KeiyakuTankaArray=array();$KeiyakuPriceArray=array();$KeiyakuNaiyouSelectArray=array();
		$num=0;
		foreach($targetContractdetails as $targetContractdetail){
			$KeiyakuNaiyouArray[]=$targetContractdetail->keiyaku_naiyo;
			$KeiyakuNaiyouSelectArray[]=OtherFunc::make_htm_get_treatment_slct($targetContractdetail->keiyaku_naiyo);
			$keiyakuCnt=$targetContractdetail->keiyaku_num;
			$KeiyakuNumSlctArray[]=OtherFunc::make_html_keiyaku_num_slct($targetContractdetail->keiyaku_num);
			$KeiyakuTankaArray[]=$targetContractdetail->unit_price;
			$KeiyakuPriceArray[]=$targetContractdetail->price;
			$num++;
		}
		for($i=$num;$i<=5;$i++){
			$KeiyakuNumSlctArray[]=OtherFunc::make_html_keiyaku_num_slct("");
			$KeiyakuTankaArray[]="";
			$KeiyakuPriceArray[]="";
		}
		/*
		$input = $request->all();
		print_r($input);
		if(isset($request->syusei_Btn)){
			$GoBackPlace="/customers/UserList";
		}else if(isset($request->fromMenu)){
			$GoBackPlace="../ShowMenuCustomerManagement";
		}else if(isset($request->contract_syusei_Btn)){
			$GoBackPlace="/customers/ShowContractList/".$UserSerial;
		}
		*/
		/*
		foreach($_SESSION['access_history'] as $targetHistory){
			if(strpos($targetHistory,"ContractList")){
				$GoBackPlace="/customers/ShowContractList";
				$GoBackPlaceName="戻る";
				break;
			}else if(strpos($targetHistory,"menuStaff")){
				$GoBackPlace="";
				$GoBackPlaceName="";
			}
		}
		*/
		$GoBackPlace="/customers/ShowContractList";
		$access_history=implode (",", $_SESSION['access_history']);
		$TreatmentsTimes_slct=OtherFunc::make_html_TreatmentsTimes_slct($targetContract->treatments_num);
		return view('customers.CreateContracts',compact("access_history","header","slot",'newKeiyakuSerial','targetContract',"targetContractdetails","targetUser","KeiyakuNaiyouArray","KeiyakuNumSlctArray","KeiyakuTankaArray","KeiyakuPriceArray","HowToPay","HowManyPay","CardCompanySelect","GoBackPlace","TreatmentsTimes_slct","KeiyakuNaiyouSelectArray"));
	}

	public function ShowContractList($UserSerial,Request $request){
		session(['fromPage' => 'ContractList']);
		session(['targetUserSerial' => $UserSerial]);
		//print 'targetUserSerial='.session('targetUserSerial')."<br>";
		if(isset($_SERVER['HTTP_REFERER'])){
			OtherFunc::set_access_history($_SERVER['HTTP_REFERER']);
		}
		if(isset($request->page_num)){
			session(['target_page_for_pager'=>$request->page_num]);
		}
		$header="";$slot="";
		$key="";
		//$Contracts="";
		//$htm_branch_rdo=OtherFunc::make_html_branch_rdo();
		if(session('targetUserSerial')=="all"){
			//$userinf="";
			//$Contracts=Contract::leftjoin('users', 'contracts.serial_user', '=', 'users.serial_user')->paginate(initConsts::DdisplayLineNumContractList());
			$GoBackPlace="/ShowMenuCustomerManagement/";
		}else{
			$GoBackPlace="/customers/UserList";
			//$userinf=User::where('serial_user','=',$UserSerial)->first();
			/*
			$Contracts=Contract::where('contracts.serial_user','=',$UserSerial)
				->leftjoin('users', 'contracts.serial_user', '=', 'users.serial_user')
				->select('contracts.*', 'users.*')
				->paginate(initConsts::DdisplayLineNumContractList());
			*/
		}
		//return view('customers.ListContract',compact("Contracts","UserSerial","userinf","GoBackPlace","header","slot"));
		return view('customers.ListContract',compact("GoBackPlace","header","slot"));
	}

	public function ShowSyuseiCustomer(Request $request){
		session(['fromPage' => 'SyuseiCustomer']);
		session(['CustomerManage' => 'syusei']);
		$header="";$slot="";$selectedManth=array();$selectedManth=array();
		$target_user=User::where('serial_user','=', $request->input('syusei_Btn'))->first();
		$html_birth_year_slct=OtherFunc::make_html_slct_birth_year_list($target_user->birth_year);
		$selectedManth[(int)$target_user->birth_month]="Selected";
		$selectedDay[(int)$target_user->birth_day]="Selected";
		$selectedRegion[$target_user->address_region]="Selected";
		$GenderRdo=array();
		$GenderRdo[$target_user->gender]="checked";
		setcookie('TorokuMessageFlg','false',time()+60);
		$saveFlg="false,".session('CustomerManage');$btnDisp="　修　正　";
		$html_reason_coming="";
		if(isset($request->syusei_Btn)){
			$GoBackPlace="/customers/UserList";
			$html_reason_coming=OtherFunc::make_html_reason_coming_cbox($target_user->reason_coming);

		}else if(isset($request->fromMenu)){
			$html_reason_coming=OtherFunc::make_html_reason_coming_cbox("");
			$GoBackPlace="../ShowMenuCustomerManagement";
		}
		$html_branch_rdo=OtherFunc::make_html_branch_rdo_for_inp_customer($target_user->serial_branch);
		return view('customers.CreateCustomer',compact("header","slot",'html_birth_year_slct',"target_user","selectedManth","selectedDay","selectedRegion","GoBackPlace","saveFlg","btnDisp","GenderRdo","html_reason_coming","html_branch_rdo"));
	}

	public function ShowInputCustomer(Request $request){
		session(['fromPage' => 'InputCustomer']);
		session(['CustomerManage' => 'new']);
		$header="";$slot="";
		$html_birth_year_slct=OtherFunc::make_html_slct_birth_year_list("");
		$html_birth_year_slct=trim($html_birth_year_slct);
		$GoBackPlace="../ShowMenuCustomerManagement";
		if(isset($request->CustomerListCreateBtn)){
			$GoBackPlace="/customers/UserList";
		}
		setcookie('TorokuMessageFlg','false',time()+60);
		$html_branch_rdo=OtherFunc::make_html_branch_rdo_for_inp_customer(null);
		$GenderRdo=array();
		$target_user="";$selectedManth=null;$selectedDay=null;$selectedRegion=null;
		$saveFlg="false,".session('CustomerManage');$btnDisp="　登　録　";
		$html_reason_coming="";
		$html_reason_coming=OtherFunc::make_html_reason_coming_cbox("");
		return view('customers.CreateCustomer',compact('header',"slot",'html_birth_year_slct',"target_user","selectedManth","selectedDay","selectedRegion","GoBackPlace","saveFlg","btnDisp","GenderRdo","html_reason_coming","html_branch_rdo"));
	}

	public function deleteCustomer($serial_user){
		$header="";$slot="";
		$deleUser=User::where('serial_user','=',$serial_user)->delete();
		$deleKeiyaku=Contract::where('serial_user','=',$serial_user)->delete();
		$deleContractDetail=ContractDetail::where('serial_user','=',$serial_user)->delete();
		$deleContractDetail=PaymentHistory::where('serial_user','=',$serial_user)->delete();
		$deleVisitHistory=VisitHistory::where('serial_user','=',$serial_user)->delete();
		return redirect('/customers/UserList');
	}
	
	private function save_recorder($location){
		DB::table('recorders')->insert([
			'id_recorder' => Auth::user()->serial_staff,
			'name_recorder' => Auth::user()->last_name_kanji.' '.Auth::user()->first_name_kanji,
			'location_url' => $_SERVER['REQUEST_URI'],
			'location' =>$location,
			'created_at' => date('Y-m-d H:i:s'),
		]);
		return;
	}

	function recordVisitPaymentHistory(Request $request){
		$PaymentHistorySerial=session('ContractSerial')."-01";
		$PaymentHistorySerial=str_replace('K','P',$PaymentHistorySerial);
		DB::table('payment_histories')->where('serial_keiyaku','=', session('ContractSerial'))->delete();
			for($i=0;$i<=11;$i++){
				if(!isset($request->PaymentDate[$i]) and !isset($request->PaymentAmount[$i]) and !isset($requestcontracts->HowToPay[$i])){break;}
				$PaymentDateArra[$i]="";
				if(isset($request->PaymentDate[$i])){
					$PaymentDateArra[$i]=$request->PaymentDate[$i];
				}
				$PaymentAmountArra[$i]="";
				if(isset($request->PaymentAmount[$i])){
					$PaymentAmountArra[$i]=$request->PaymentAmount[$i];
				}
				$PaymentHowToPayArray[$i]="";
				if(isset($request->HowToPay[$i])){
					$PaymentHowToPayArray[$i]=$request->HowToPay[$i];
				}
				
				$targetlData=[
					'serial_keiyaku'=>session('ContractSerial'),
					'serial_user'=>session('UserSerial'),
					'payment_history_serial'=>$PaymentHistorySerial,
					'serial_staff'=>Auth::user()->serial_staff,
					'date_payment'=>$PaymentDateArra[$i],
					'amount_payment'=>str_replace(',','',$PaymentAmountArra[$i]),
					'how_to_pay'=>$PaymentHowToPayArray[$i]
				];
				$targetDataArray[]=$targetlData;
				$PaymentHistorySerial++;
				PaymentHistory::upsert($targetDataArray,['payment_history_serial']);
			}
		//}	
		
		VisitHistory::where('serial_keiyaku','=', session('ContractSerial'))->delete();
		
		$targetDataArray=array();
		$VisitHistorySerial=session('ContractSerial')."-01";
		$VisitHistorySerial=str_replace('K','V',$VisitHistorySerial);
		$date_latest_visit="";
		if(isset($request->visitDate)){
			$i=0;
			foreach($request->visitDate as $visitDateValue){
				if($visitDateValue<>""){$date_latest_visit=$visitDateValue;}
				if($visitDateValue==""){break;}
				$targetlData=array();
				$targetlData=[
					'serial_keiyaku'=>session('ContractSerial'),
					'serial_user'=>session('UserSerial'),
					'visit_history_serial'=>$VisitHistorySerial,
					'serial_Staff'=>Auth::user()->serial_Staff,
					'date_visit'=>$visitDateValue,
					'treatment_dtails'=>$request->TreatmentDetailsSelect[$i]
				];
				VisitHistory::where('visit_history_serial','=', $VisitHistorySerial)->restore();
				VisitHistory::upsert($targetlData,['visit_history_serial']);
				$targetDataArray[]=$targetlData;
				$VisitHistorySerial++;
				$i++;
			}
		}
		Contract::where('serial_keiyaku','=',session('ContractSerial'))->update(['date_latest_visit' =>$date_latest_visit]);
		session()->flash('success', '登録しました。');
		session(['InpRecordVisitPaymentFlg' => true]);
		$this::save_recorder("recordVisitPaymentHistory");
		return redirect('/customers/ShowInpRecordVisitPayment/'.session("ContractSerial").'/'.session("UserSerial"));
	}

	public function ShowInpRecordVisitPayment($ContractSerial,$UserSerial){
		$fromURLArray=parse_url($_SERVER['HTTP_REFERER']);
		if(!session('InpRecordVisitPaymentFlg')){
			session(['ShowInpRecordVisitPaymentfromPage' => $fromURLArray['path']]);
			session(['InpRecordVisitPaymentFlg' => false]);
		}else{
			session(['InpRecordVisitPaymentFlg' => false]);
		}
		session(['fromPage' => parse_url($_SERVER['HTTP_REFERER'])]);
		session(['UserSerial' => $UserSerial]);
		session(['ContractSerial' => $ContractSerial]);
		$RecordUrl = route('recordVisitPaymentHistory.post');
		$header="";$slot="";$selectedManth=array();$selectedManth=array();
		$targetVisitHistoryArray=VisitHistory::where('serial_keiyaku','=', $ContractSerial)->get();
		$targetPaymentHistoryArray=PaymentHistory::where('serial_keiyaku','=', $ContractSerial)->get();
		//PaymentHistory::where('serial_keiyaku','=', $ContractSerial)->dump();
		$targetUser=User::where('serial_user','=', $UserSerial)->first();
		$targetContract=Contract::where('serial_keiyaku','=', $ContractSerial)->first();
		$targetContractDetails=ContractDetail::where('serial_keiyaku','=', $ContractSerial)->get();
		$KeiyakuNaiyouArray=array();$VisitDateArray=array();
		
		$KeiyakuNumMax = DB::table('configrations')->select('value1')->where('subject', '=', 'KeiyakuNumMax')->first();
		$sejyutukaisu=Contract::where('serial_keiyaku','=',$ContractSerial)->first('treatments_num');
		$visit_disabeled=array();$set_gray_array=array();
		for($i=0;$i<=$KeiyakuNumMax->value1;$i++){
			$visit_disabeled[$i]='disabled'; $set_gray_array[$i]='style="color:#DDDDDD"';
			if($i<$sejyutukaisu->treatments_num){
				$visit_disabeled[$i]="";
				$set_gray_array[$i]="";
			}		
		}
		$i=0;$TreatmentDetailsArray=array();$TreatmentDetailsSelectArray=array();$VisitSerialArray=array();
		foreach($targetVisitHistoryArray as $targetVisitHistory){
			$_SESSION['VisitSerialSessionArray'][]=$targetVisitHistory->visit_history_serial;
			$VisitDateArray[]=$targetVisitHistory->date_visit;
			$TreatmentDetailsArray[]=$targetVisitHistory->treatment_dtails;
			$TreatmentDetailsSelectArray[]=OtherFunc::make_htm_get_treatment_slct($targetVisitHistory->treatment_dtails);
			$set_gray_array[$i]='style="background-color:#e0ffff"';
			$i++;
		}
		for($k=$i;$k<24;$k++){
			$TreatmentDetailsSelectArray[$k]=OtherFunc::make_htm_get_treatment_slct('');
		}

		if($targetContract->how_to_pay=='現金'){
			$paymentCount=$targetContract->how_many_pay_genkin;
		}else{
			$paymentCount=$targetContract->how_many_pay_card;
		}
		for($i=0;$i<initConsts::PaymentNumMax();$i++){
			$payment_disabeled[$i]='disabled'; $set_gray_pay_array[$i]='color:#DDDDDD';$set_background_gray_pay_array[$i]='background-color:#EEEEEE';
			if($i<$paymentCount){
				$payment_disabeled[$i]="";$set_gray_pay_array[$i]="";$set_background_gray_pay_array[$i]='';
			}		
		}
		
		$payCnt=$targetContract->how_many_pay_genkin;
		if($targetContract->how_to_pay=="Credit Card"){
			$payCnt=$targetContract->how_many_pay_card;
		}

		$PaymentDateArray=array();$PaymentAmountArray=array();$HowToPayCheckedArray=array();
		
		for($i=0;$i<12;$i++){
			$HowToPayCheckedArray[$i][0]="";
			$HowToPayCheckedArray[$i][1]="";
		}
		$i=0;
		foreach($targetPaymentHistoryArray as $targetPaymentHistory){
			$HowToPayCheckedCard="";$HowToPayCheckedCash="";$HowToPayCheckedDefault="";
			if($targetPaymentHistory->how_to_pay=="card"){
				$HowToPayCheckedCard="checked";
				$HowToPayCheckedPaypay="";
				$HowToPayCheckedCash="";
				$HowToPayCheckedDefault="";
			}else if($targetPaymentHistory->how_to_pay=="paypay"){
				$HowToPayCheckedCard="";
				$HowToPayCheckedPaypay="checked";
				$HowToPayCheckedCash="";
				$HowToPayCheckedDefault="";
			}else if($targetPaymentHistory->how_to_pay=="cash"){
				$HowToPayCheckedCard="";
				$HowToPayCheckedPaypay="";
				$HowToPayCheckedCash="checked";
				$HowToPayCheckedDefault="";
			}else if($targetPaymentHistory->how_to_pay=="default"){
				$HowToPayCheckedCard="";
				$HowToPayCheckedPaypay="";
				$HowToPayCheckedCash="";
				$HowToPayCheckedDefault="checked";
			}
			$HowToPayCheckedArray[$i][0]=$HowToPayCheckedCard;
			$HowToPayCheckedArray[$i][1]=$HowToPayCheckedPaypay;
			$HowToPayCheckedArray[$i][2]=$HowToPayCheckedCash;
			$HowToPayCheckedArray[$i][3]=$HowToPayCheckedDefault;

			$PaymentDateArray[]=$targetPaymentHistory->date_payment;
			$PaymentAmountArray[]=$targetPaymentHistory->amount_payment;
			
			$set_background_gray_pay_array[$i]='background-color:#e0ffff';
			$set_gray_pay_array[$i]='background-color:#e0ffff';
			$i++;
		}

		foreach($targetContractDetails as $targetContractDetail){
			$KeiyakuNaiyouArray[]=$targetContractDetail->keiyaku_naiyo;
		}
		$KeiyakuNaiyou=implode("/", $KeiyakuNaiyouArray);
		$HowToPayChecked[0][0]="";$GoBackToPlace='';
		if(session('fromMenu')=='MenuCustomerManagement'){
			$GoBackToPlace="/ShowMenuCustomerManagement";
		}else if(session('fromMenu')=='CustomersList'){
			$GoBackToPlace="/customers/UserList";
			//$GoBackToPlace="/customers/ShowCustomersList_livewire";
		}
		$GoBackToPlace=session('ShowInpRecordVisitPaymentfromPage');
		//print_r($PaymentDateArray);
		return view('customers.PaymentRegistration',compact("GoBackToPlace","header","slot",'VisitDateArray','PaymentDateArray','targetUser','targetContract','KeiyakuNaiyou','PaymentAmountArray','HowToPayCheckedArray','visit_disabeled','sejyutukaisu','set_gray_array','payment_disabeled','set_gray_pay_array','set_background_gray_pay_array','paymentCount','TreatmentDetailsArray','TreatmentDetailsSelectArray'));
	}

	function insertContract(Request $request){
		$motourl = $_SERVER['HTTP_REFERER'];
		$kyo=date("Y/m/d H:i:s");
		Storage::append('errorCK.txt', $kyo." / ".$motourl);
		$targetData=array();
		$how_many_pay_card=1;$how_many_pay_card="";
		if($request->HowmanyCard=='一括'){
			$how_many_pay_card=1;
		}else{
			$how_many_pay_card=$request->HowManyPayCardSlct;
		}
		$how_many_pay_genkin=$request->HowManyPaySlct;
		if($request->HowPayRdio=='現金'){
			$how_many_pay_card=null;
		}else{
			$how_many_pay_genkin=null;
		}
		$targetData=[
			'serial_keiyaku' => $request->ContractSerial,
			'serial_user' => $request->serial_user,
			'keiyaku_kikan_start' => $request->ContractsDateStart,

			'keiyaku_kikan_end' => $request->ContractsDateEnd,
			'keiyaku_name' => $request->ContractName,

			'keiyaku_bi' => $request->ContractsDate,
			'keiyaku_kingaku' =>  str_replace(',','',$request->inpTotalAmount),
			'keiyaku_num' => $request->ContractSerial,

			'keiyaku_kingaku_total' => str_replace(',','',$request->TotalAmount),
			'how_to_pay' => $request->HowPayRdio,

			'how_many_pay_genkin' => $how_many_pay_genkin,

			'date_first_pay_genkin' => $request->DateFirstPay,
			'date_second_pay_genkin' => $request->DateSecondtPay,

			'amount_first_pay_cash' => str_replace(',','',$request->AmountPaidFirst),
			'amount_second_pay_cash' =>  str_replace(',','',$request->AmountPaidSecond),

			'card_company' => $request->CardCompanyNameSlct,
			'how_many_pay_card' => $how_many_pay_card,
			'date_pay_card' => $request->DatePayCardOneDay,

			'tantosya' => $request->tantosya,
			'remarks' => $request->memo,
			'treatments_num' => $request->TreatmentsTimes_slct,
			'deleted_at'=>null
		];
		if($request->ContractSerial<>""){
			Contract::upsert($targetData,['serial_Contract']);
			$targetDataArray=array();
			DB::table('contract_details')->where('serial_keiyaku','=',$request->ContractSerial)->delete();
			for($i=0;$i<=4;$i++){
				if($request->ContractNaiyo[$i]<>""){
					$contract_detail_serial=$request->ContractSerial."-".sprintf('%02d', $i+1);
					$targetDetailData=array();
					//$d_array=array();
					$targetDetailData=[
						'contract_detail_serial'=>$contract_detail_serial,
						'serial_keiyaku'=>$request->ContractSerial,
						'serial_user'=>$request->serial_user,
						'keiyaku_naiyo'=>$request->ContractNaiyo[$i],
						'keiyaku_num'=>$request->KeiyakuNumSlct[$i],
						'unit_price'=>str_replace(',','',$request->AmountPerNum[$i]),
						'price'=>$request->subTotalAmount[$i]
					];
					$targetDataArray[]=$targetDetailData;
				}else{
					break;
				}
			}
			ContractDetail::upsert($targetDataArray,['contract_detail_serial']);
			Storage::append('errorCK.txt', $kyo." / ".$motourl." / ok");
			$header="";$slot="";
			$SerialUser=$request->serial_user;$SerialKeiyaku=$request->ContractSerial;
			session(['targetUserSerial' => $SerialUser]);
			if(Auth::user()->serial_Staff=="A_0001"){
				if(session('ContractManage')=='syusei'){
					//return redirect("/customers/ShowContractList_livewire/".session('targetUserSerial'));
					return redirect("/customers/ShowContractList/".$SerialUser);
				}else{
					$userInf=User::where('serial_user','=',$request->serial_user)->first();
					$keiyakuInf=Contract::where('serial_keiyaku','=',$request->ContractSerial)->first();
					$msg="氏名: ".$userInf->name_sei." ".$userInf->name_mei."さんの契約を新規登録しました。";
	
					if(session('fromMenu')=='MenuCustomerManagement'){
						$GoBackToPlace="../ShowMenuCustomerManagement";
					}else if(session('fromMenu')=='CustomersList'){
						$GoBackToPlace="/customers/UserList";
						//$GoBackToPlace="/customers/ShowCustomersList_livewire";
					}
			    		return view("layouts.DialogMsgKeiyaku", compact('msg','SerialUser','SerialKeiyaku','GoBackToPlace','header',"slot"));
		    		}
			}else{
				if(session('ContractManage')=='syusei'){
					return redirect("/customers/ShowContractList/".$SerialUser);
				}else{
					$userInf=User::where('serial_user','=',$request->serial_user)->first();
					$keiyakuInf=Contract::where('serial_keiyaku','=',$request->ContractSerial)->first();
					$msg="氏名: ".$userInf->name_sei." ".$userInf->name_mei."さんの契約を新規登録しました。";
	
					if(session('fromMenu')=='MenuCustomerManagement'){
						$GoBackToPlace="../ShowMenuCustomerManagement";
					}else if(session('fromMenu')=='CustomersList'){
						$GoBackToPlace="/customers/UserList";
						//$GoBackToPlace="/customers/ShowCustomersList_livewire";
					}
			    		return view("layouts.DialogMsgKeiyaku", compact('msg','SerialUser','SerialKeiyaku','GoBackToPlace','header',"slot"));
		    		}
				/*
				session()->flash('success', '登録しました。');
				return redirect('/customers/ShowSyuseiContract/'.$request->ContractSerial.'/'.$request->serial_user);
				*/
			}
		}
	}

	public function ShowInpKeiyaku($serial_user){
		session(['fromPage' => 'InpKeiyaku']);
		$header="";$slot="";$HowToPay=array();
		//$KeiyakuNumSlct=OtherFunc::make_html_keiyaku_num_slct("");
		$KeiyakuNumSlctArray=array();$KeiyakuTankaArray=array();$KeiyakuPriceArray=array();
		for($i=0;$i<=4;$i++){
			$KeiyakuNumSlctArray[]=OtherFunc::make_html_keiyaku_num_slct("");
			$KeiyakuTankaArray[]="";
			$KeiyakuPriceArray[]="";
		}

		$targetUser=User::where('serial_user','=',$serial_user)->first();
		$serial_max=Contract::where('serial_user','=',$serial_user)->max('serial_keiyaku');
		$newKeiyakuSerial=++$serial_max;

		if($newKeiyakuSerial==1){
			$newKeiyakuSerial='K_'.str_replace('U_', '',$serial_user).'-0001';
		};
		$thisYear=date('Y');
		$thisMonth=date('m');
		$thisDay=date('d');
		$tday=date('Y-m-d');
		$endDay=date("Y-m-d",strtotime("-1 day,+1 year"));
		$HowManyPay['CardSlct']=OtherFunc::make_html_how_many_slct("",20,2);
		$HowToPay['cash']="";
		if(isset($request->serial_user)){
			$targetSerial=$request->serial_user;
			//$redirectPlace='/customers/ShowCustomersList';
			//$redirectPlace='/customers/ShowCustomersList_livewire';
			$GoBackToPlace="/customers/UserList";
		}else{
			$max = User::max('serial_user');
			$targetSerial=++$max;
			if($targetSerial==1){$targetSerial="001001";}
			$redirectPlace='/customers/ShowInputCustomer';
		}
		$KeiyakuNaiyouSelectArray=array();
		for($i=0;$i<=5;$i++){
			$KeiyakuNaiyouSelectArray[]=OtherFunc::make_htm_get_treatment_slct('');
		}
		$TreatmentsTimes_slct=OtherFunc::make_html_TreatmentsTimes_slct("");
		//$targetContract="";
		$targetContract=array();
		$KeiyakuNaiyouArray=array();
		$CardCompanySelect=OtherFunc::make_html_card_company_slct("");
		$HowManyPay['CashSlct']=OtherFunc::make_html_how_many_slct("",20,1);
		return view('customers.CreateContracts',compact("targetUser","header","slot","tday","endDay","newKeiyakuSerial","targetContract","KeiyakuNaiyouArray","KeiyakuNumSlctArray","KeiyakuTankaArray","KeiyakuPriceArray","HowToPay","CardCompanySelect","HowManyPay",'TreatmentsTimes_slct','KeiyakuNaiyouSelectArray'));
	}

	function insertCustomer(Request $request){
		if(isset($request->serial_user)){
			session(['CustomerManage' => 'syusei']);
			$targetSerial=$request->serial_user;
			$redirectPlace='/customers/ShowCustomersList';
			$btnDisp="　修　正　";
		}else{
			$max = DB::table('users')->max('serial_user');
			$targetSerial=++$max;
			$targetSerial=sprintf('%06d', $targetSerial);
			if($targetSerial==1){$targetSerial="001001";}
			$redirectPlace='/customers/ShowInputCustomer';
			session(['CustomerManage' => 'new']);
			$btnDisp="　登　録　";
		}
		$reason_coming="";
		//print_r($request->reason_coming_cbx);
		if($request->reason_coming_cbx<>""){
			$reason_coming=implode(",",$request->reason_coming_cbx);
			if($request->reason_coming_txt<>""){
				$reason_coming.="(".$request->reason_coming_txt.")";
			}
		}
		
 		$targetData=[
			'serial_user' => $targetSerial,
			'admission_date' => $request->AdmissionDate,
			'name_sei' => $request->name_sei,

			'name_mei' => $request->name_mei,
			'name_sei_kana' => $request->name_sei_kana,
			'name_mei_kana' => $request->name_mei_kana,

			'gender'=> $request->GenderRdo,
			'birth_year' => $request->birt_year_slct,
			'birth_month' => $request->birth_month_slct,

			'birth_day' => $request->birth_day_slct,
			'postal' => $request->postal,
			'address_region' => $request->region,

			'address_locality' => $request->locality,
			'address_banti' => $request->address_banti_txt,
			'address_banti' => $request->address_banti_txt,

			'email' => $request->email,
			'phone' => $request->phone,
			'reason_coming'=>$reason_coming,

			'serial_branch'=>$request->branch_rdo
		];
		User::upsert($targetData,['serial_user']);
		setcookie('TorokuMessageFlg','true',time()+60);
		//if(session(['CustomerManage' => 'new'])){
		$header="";$slot="";
		$html_birth_year_slct=OtherFunc::make_html_slct_birth_year_list("");
		$html_birth_year_slct=trim($html_birth_year_slct);
		$GoBackPlace=session('GoBackPlace');
		$saveFlg="true,".session('CustomerManage');
		$target_user="";$selectedManth=null;$selectedDay=null;$selectedRegion=null;
		if(session('fromMenu')=='MenuCustomerManagement'){
			$GoToBackPlace="../ShowMenuCustomerManagement";
		}else if(session('fromMenu')=='CustomersList'){
			$GoBackToPlace="/customers/UserList";
		}
		if(Auth::user()->serial_Staff=="A_0001"){
			if(session('CustomerManage')=='syusei'){
				return redirect("/customers/UserList");
			}else{
				$userInf=User::where('serial_user','=',$targetSerial)->first();
				$msg="氏名: ".$userInf->name_sei." ".$userInf->name_mei."さんのデータを新規登録しました。";
	    		return view("layouts.DialogMsg", compact('userInf','msg','targetSerial','header',"slot","GoToBackPlace"));
    		}
    	}else{
			if(session('CustomerManage')=='syusei'){
				return redirect("/customers/UserList");
			}else{
				$userInf=User::where('serial_user','=',$targetSerial)->first();
				$msg="氏名: ".$userInf->name_sei." ".$userInf->name_mei."さんのデータを新規登録しました。";
	    		return view("layouts.DialogMsg", compact('userInf','msg','targetSerial','header',"slot","GoToBackPlace"));
    		}
		}
	}

	public function ShowMenuCustomerManagement(){
		OtherFunc::make_html_branch_rdo();
		session(['fromPage' => 'MenuCustomerManagement']);
		session(['fromMenu' => 'MenuCustomerManagement']);
		session(['fromMenu' => 'MenuCustomerManagement']);
		session(['targetYear' => date('Y')]);
		$targetYear=session('targetYear');
		if(isset($_SERVER['HTTP_REFERER'])){
			OtherFunc::set_access_history($_SERVER['HTTP_REFERER']);
		}

		$DefaultUsersInf=PaymentHistory::leftJoin('users', 'payment_histories.serial_user', '=', 'users.serial_user')
			->where('payment_histories.how_to_pay','=', 'default')
			->whereIn('users.serial_user', function ($query) {
				$query->select('contracts.serial_user')->from('contracts')->where('contracts.cancel','=', null);
			})
			->distinct()->select('name_sei','name_mei')->get();
		$html_year_slct=OtherFunc::make_html_year_slct(date('Y'));
		$html_month_slct=OtherFunc::make_html_month_slct(date('n'));
		$default_customers=OtherFunc::make_htm_get_default_user();
		$not_coming_customers=OtherFunc::make_htm_get_not_coming_customer();
		$htm_kesanMonth=OtherFunc::make_html_month_slct(initConsts::KesanMonth());
		$htm_branch_cbox=OtherFunc::make_html_branch_rdo();
		$csrf="csrf";$header="";$slot="";
		session(['GoBackPlace' => '../ShowMenuCustomerManagement']);
		return view('staff.MenuCustomerManagement',compact("header","slot","html_year_slct","html_month_slct","DefaultUsersInf","not_coming_customers","default_customers",'htm_kesanMonth','htm_branch_cbox'));
	}

	public function ShowTargetUser($serial_user){
		$users=User::where('created_at')->paginate(15);
		return view('staff.UserList',compact('users'));
	}

	public function ShowUserList(){
		if(isset($_SERVER['HTTP_REFERER'])){
			OtherFunc::set_access_history($_SERVER['HTTP_REFERER']);
		}
		$users=User::orderBy('created_at')->paginate(15);
		return view('staff.UserList',compact('users'));
	}
}