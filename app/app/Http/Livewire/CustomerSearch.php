<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\User;
use App\Models\Contract;
use App\Models\PaymentHistory;
use Livewire\WithPagination;
use App\Http\Controllers\InitConsts;
use Illuminate\Http\Request;
use App\Http\Controllers\OtherFunc;
use App\Models\Staff;
use Illuminate\Support\Facades\Auth;

if(!isset($_SESSION)){session_start();}

class CustomerSearch extends Component
{
	use WithPagination;
	public $sort_key_p = '',$asc_desc_p="",$serch_key_p="";
	public $kensakukey="";
	public $count = 0;
	public static $serial_branch = '';
	public static $key="";
	
	public function increment()
    {
        $this->count++;
    }

	public function select_branch($target_serial_branch){
        session(['target_branch_serial' => $target_serial_branch]);
        self::$serial_branch=$target_serial_branch;
        Staff::where('serial_staff', '=', Auth::user()->serial_staff)->update([
            'selected_branch' => session('target_branch_serial'),
        ]);
	}

	public function searchClear(){
		$this->serch_key_p="";
		$this->kensakukey="";
		//session(['target_branch_serial' => 'all']);
		session(['serchKey' => '']);
	}

	public function search_from_top_menu(Request $request){
		$this->serch_key_p=$request->input('user_serial');
		session(['serchKey' => $request->input('user_serial')]);
	}

	public function search(){
		$this->serch_key_p=$this->kensakukey;
		session(['serchKey' => $this->kensakukey]);
	}

    public function sort($sort_key){
		//print "sort_key=".$sort_key."<br>";
		$sort_key_array=array();
		$sort_key_array=explode("-", $sort_key);
		
		session(['sort_key' =>$sort_key_array[0]]);
		session(['asc_desc' =>$sort_key_array[1]]);
	}

	public function zankin_search(){
		$this->serch_key_p="zankin";
		session(['serchKey' => $this->kensakukey]);
	}

    public function render()
    {
		if(isset($_SERVER['HTTP_REFERER'])){
			OtherFunc::set_access_history($_SERVER['HTTP_REFERER']);
		}

	    if(!isset($sort_key_p) and session('sort_key')==null){
			session(['sort_key' =>'']);
		}
		$this->sort_key_p=session('sort_key');

		if(!isset($asc_desc_p) and session('asc_desc')==null){
			session(['asc_desc' =>'ASC']);
		}
		$this->asc_desc_p=session('asc_desc');

        $userQuery = User::query();

        $from_place="";$target_day="";$backdayly=false;

		foreach($_SESSION['access_history'] as $targeturl){
			if(strpos( $targeturl, 'ShowDailyReport') !== false){
				$backdayly=true;
				break;
			}else if (strpos( $targeturl, 'ShowMenuCustomerManagement') !== false){
				$backdayly=false;
				break;
			}
		}

		if(isset($_POST['btn_serial'])){
			session(['serchKey' => $_POST['btn_serial']]);
			
		}else if(session('serchKey')==""){
			session(['serchKey' => $this->serch_key_p]);
		}

		if((isset($_POST['target_day']) and $_POST['target_day']<>"") or $backdayly==true){
			$from_place="dayly_rep";
			if(isset($_POST['target_day'])){
			$target_day= $_POST['target_day'];
			}else{
				$target_day=$_SESSION['backmonthday'];
			}
		}

		if(session('serchKey')=='zankin'){
			$userQuery =$userQuery->where('zankin','>','0');
		}else{
			self::$key="%".session('serchKey')."%";
			//$key="%".session('serchKey')."%";
			if(session('target_branch_serial')=='all'){
				$userQuery =$userQuery->where('serial_user','like',self::$key)
				->orwhere('name_sei','like',self::$key)
				->orwhere('name_mei','like',self::$key)
				->orwhere('name_sei_kana','like',self::$key)
				->orwhere('name_mei_kana','like',self::$key)
				->orwhere('birth_year','like',self::$key)
				->orwhere('birth_month','like',self::$key)
				->orwhere('birth_day','like',self::$key)
				->orwhere('address_region','like',self::$key)
				->orwhere('address_locality','like',self::$key)
				->orwhere('email','like',self::$key)
				->orwhere('phone','like',self::$key);
			}else{
				$key=$userQuery->where('serial_branch','=',session('target_branch_serial'))
					->Where(function($query) {
					$query->orwhere('name_sei','like',self::$key)
					->orwhere('name_mei','like',self::$key)
					->orwhere('name_sei_kana','like',self::$key)
					->orwhere('name_mei_kana','like',self::$key)
					->orwhere('birth_year','like',self::$key)
					->orwhere('birth_month','like',self::$key)
					->orwhere('birth_day','like',self::$key)
					->orwhere('address_region','like',self::$key)
					->orwhere('address_locality','like',self::$key)
					->orwhere('email','like',self::$key)
					->orwhere('phone','like',self::$key);
				});
			}
		}
			/*
			$userQuery =$userQuery->where('serial_user','like',$key)
				->orwhere('name_sei','like',$key)
				->orwhere('name_mei','like',$key)
				->orwhere('name_sei_kana','like',$key)
				->orwhere('name_mei_kana','like',$key)
				->orwhere('birth_year','like',$key)
				->orwhere('birth_month','like',$key)
				->orwhere('birth_day','like',$key)
				->orwhere('address_region','like',$key)
				->orwhere('address_locality','like',$key)
				->orwhere('email','like',$key)
				->orwhere('phone','like',$key);
			*/
		
		//if(session('target_branch_serial')<>'all'){
			//$userQuery =$userQuery->where('serial_branch','=',session('target_branch_serial'));
			//$userQuery =$userQuery->where('serial_branch','=','B_001');
		//}
		$targetSortKey="";
		if(session('sort_key')<>""){
			$targetSortKey=session('sort_key');
		}else{
			$targetSortKey=$this->sort_key_p;
		}

		if($this->sort_key_p<>''){
			if($this->sort_key_p=="name_sei"){
				if($this->asc_desc_p=="ASC"){
					$userQuery =$userQuery->orderBy('name_sei', 'asc');
					$userQuery =$userQuery->orderBy('name_mei', 'asc');
				}else{
					$userQuery =$userQuery->orderBy('name_sei', 'desc');
					$userQuery =$userQuery->orderBy('name_mei', 'desc');
				}
			}else if($this->sort_key_p=="name_sei_kana"){
				if($this->asc_desc_p=="ASC"){
					$userQuery =$userQuery->orderBy('name_sei_kana', 'asc');
					$userQuery =$userQuery->orderBy('name_mei_kana', 'asc');
				}else{
					$userQuery =$userQuery->orderBy('name_sei_kana', 'desc');
					$userQuery =$userQuery->orderBy('name_mei_kana', 'desc');
				}
			}else if($this->sort_key_p=="birth_year"){
				if($this->asc_desc_p=="ASC"){
					$userQuery =$userQuery->orderBy('birth_year', 'asc');
					$userQuery =$userQuery->orderBy('birth_month', 'asc');
					$userQuery =$userQuery->orderBy('birth_day', 'asc');
				}else{
					$userQuery =$userQuery->orderBy('birth_year', 'desc');
					$userQuery =$userQuery->orderBy('birth_month', 'desc');
					$userQuery =$userQuery->orderBy('birth_day', 'desc');
				}
				
			}else if($this->sort_key_p=="zankin"){
				if($this->asc_desc_p=="ASC"){
					$userQuery =$userQuery->orderBy('zankin');
				}else{
					$userQuery =$userQuery->orderBy('zankin', 'desc');
				}
			}else{
				if($this->asc_desc_p=="ASC"){
					$userQuery =$userQuery->orderBy($this->sort_key_p, 'asc');
				}else{
					$userQuery =$userQuery->orderBy($this->sort_key_p, 'desc');
				}
			}
		}
		/*
		if(session('target_page_for_pager')!==null){
			$targetPage=session('target_page_for_pager');
			session(['target_page_for_pager'=>null]);
		}else{
			$targetPage=null;
		}
		*/
		//$userQuery = User::query();
        $userQuery =$userQuery->orderBy('name_sei_kana', 'asc');
		//dd($userQuery);
        $targetPage=null;
		//dd($userQuery);
        $users=$userQuery->paginate($perPage = initConsts::DdisplayLineNumCustomerList(),['*'], 'page',$targetPage);
		$totalZankin=Contract::sum('keiyaku_kingaku')-PaymentHistory::sum('amount_payment');
       // $users=User::paginate($perPage = initConsts::DdisplayLineNumCustomerList(),['*'], 'page',$targetPage);
        $header="";$slot="";
		$htm_branch_cbox=OtherFunc::make_html_branch_rdo();
        //return view('livewire.livewire-test2',compact('users','header','slot','totalZankin','from_place','target_day','from_place'));
		return view('livewire.customer-search',compact('users','header','slot','totalZankin','from_place','target_day','from_place','htm_branch_cbox'));
    }
    /*
	use WithPagination;
	public $sort_key_p = '',$asc_desc_p="",$serch_key_p="";
	public $kensakukey="";
	public $count = 0;
    public function searchClear(){
		$this->serch_key_p="";
		$this->kensakukey="";
		session(['serchKey' => '']);
	}

	public $title="title100";
	
	public function ct(){
		$this->title="New Title";
		//print "title=".$this->title."<br>";
	}
	public function search_from_top_menu(Request $request){
		$this->serch_key_p=$request->input('user_serial');
		session(['serchKey' => $request->input('user_serial')]);
	}
	
	public function search(){
		$this->serch_key_p=$this->kensakukey;
		session(['serchKey' => $this->kensakukey]);
	}

	public function zankin_search(){
		$this->serch_key_p="zankin";
		session(['serchKey' => $this->kensakukey]);
	}

	public function sort($sort_key){
		//print "sort_key=".$sort_key."<br>";
		$sort_key_array=array();
		$sort_key_array=explode("-", $sort_key);
		
		session(['sort_key' =>$sort_key_array[0]]);
		session(['asc_desc' =>$sort_key_array[1]]);
	}

    public function render()
    {
		//print 'sort_key1='.session('sort_key').'<br>';
		if(isset($_SERVER['HTTP_REFERER'])){
			OtherFunc::set_access_history($_SERVER['HTTP_REFERER']);
		}
		
		if(!isset($sort_key_p) and session('sort_key')==null){
			session(['sort_key' =>'']);
		}
		$this->sort_key_p=session('sort_key');

		if(!isset($asc_desc_p) and session('asc_desc')==null){
			session(['asc_desc' =>'ASC']);
		}
		$this->asc_desc_p=session('asc_desc');
		$userQuery = User::query();
		$from_place="";$target_day="";$backdayly=false;
		foreach($_SESSION['access_history'] as $targeturl){
			if(strpos( $targeturl, 'ShowDailyReport') !== false){
				$backdayly=true;
				break;
			}else if (strpos( $targeturl, 'ShowMenuCustomerManagement') !== false){
				$backdayly=false;
				break;
			}
		}
		if(isset($_POST['btn_serial'])){
			session(['serchKey' => $_POST['btn_serial']]);
			
		}else if(session('serchKey')==""){
			session(['serchKey' => $this->serch_key_p]);
		}
		if((isset($_POST['target_day']) and $_POST['target_day']<>"") or $backdayly==true){
			$from_place="dayly_rep";
			if(isset($_POST['target_day'])){
			$target_day= $_POST['target_day'];
			}else{
				$target_day=$_SESSION['backmonthday'];
			}
		}
		
		if(session('serchKey')=='zankin'){
			$userQuery =$userQuery->where('zankin','>','0');
		}else{
			$key="%".session('serchKey')."%";
			$userQuery =$userQuery->where('serial_user','like',$key)
				->orwhere('name_sei','like',$key)
				->orwhere('name_mei','like',$key)
				->orwhere('name_sei_kana','like',$key)
				->orwhere('name_mei_kana','like',$key)
				->orwhere('birth_year','like',$key)
				->orwhere('birth_month','like',$key)
				->orwhere('birth_day','like',$key)
				->orwhere('address_region','like',$key)
				->orwhere('address_locality','like',$key)
				->orwhere('email','like',$key)
				->orwhere('phone','like',$key);
		}
		$targetSortKey="";
		if(session('sort_key')<>""){
			$targetSortKey=session('sort_key');
		}else{
			$targetSortKey=$this->sort_key_p;
		}

		if($this->sort_key_p<>''){
			if($this->sort_key_p=="name_sei"){
				if($this->asc_desc_p=="ASC"){
					$userQuery =$userQuery->orderBy('name_sei', 'asc');
					$userQuery =$userQuery->orderBy('name_mei', 'asc');
				}else{
					$userQuery =$userQuery->orderBy('name_sei', 'desc');
					$userQuery =$userQuery->orderBy('name_mei', 'desc');
				}
			}else if($this->sort_key_p=="name_sei_kana"){
				if($this->asc_desc_p=="ASC"){
					$userQuery =$userQuery->orderBy('name_sei_kana', 'asc');
					$userQuery =$userQuery->orderBy('name_mei_kana', 'asc');
				}else{
					$userQuery =$userQuery->orderBy('name_sei_kana', 'desc');
					$userQuery =$userQuery->orderBy('name_mei_kana', 'desc');
				}
			}else if($this->sort_key_p=="birth_year"){
				if($this->asc_desc_p=="ASC"){
					$userQuery =$userQuery->orderBy('birth_year', 'asc');
					$userQuery =$userQuery->orderBy('birth_month', 'asc');
					$userQuery =$userQuery->orderBy('birth_day', 'asc');
				}else{
					$userQuery =$userQuery->orderBy('birth_year', 'desc');
					$userQuery =$userQuery->orderBy('birth_month', 'desc');
					$userQuery =$userQuery->orderBy('birth_day', 'desc');
				}
				
			}else if($this->sort_key_p=="zankin"){
				if($this->asc_desc_p=="ASC"){
					$userQuery =$userQuery->orderBy('zankin');
				}else{
					$userQuery =$userQuery->orderBy('zankin', 'desc');
				}
			}else{
				if($this->asc_desc_p=="ASC"){
					$userQuery =$userQuery->orderBy($this->sort_key_p, 'asc');
				}else{
					$userQuery =$userQuery->orderBy($this->sort_key_p, 'desc');
				}
			}
		}else{
		}
		if(session('target_page_for_pager')!==null){
			$targetPage=session('target_page_for_pager');
			session(['target_page_for_pager'=>null]);
		}else{
			$targetPage=null;
		}
		$userQuery = User::query();
		$userQuery =$userQuery->orderBy('name_sei_kana', 'asc');
		$users=$userQuery->paginate($perPage = initConsts::DdisplayLineNumCustomerList(),['*'], 'page',$targetPage);
		$totalZankin=Contract::sum('keiyaku_kingaku')-PaymentHistory::sum('amount_payment');
		$header="";
		$slot="";
		return view('livewire.customer-search',compact('users','header','slot','totalZankin','from_place','target_day','from_place'));
    }
	*/
}