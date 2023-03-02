<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Http\Controllers\OtherFunc;
use App\Models\Contract;
use App\Http\Controllers\InitConsts;
use App\Models\Staff;
use Illuminate\Support\Facades\Auth;
use Livewire\WithPagination;
use App\Models\User;
use Illuminate\Support\Facades\DB;
if(!isset($_SESSION)){session_start();}

class ContractSearch extends Component
{
	use WithPagination;
	public static $serial_branch = '';
	public static $key="";
	public $sort_key_p = '',$asc_desc_p="",$serch_key_p="",$kensakukey;
	//public $title="title0";
	/*
	public function ct(){
		$this->title="New Title";
		//print "title=".$this->title."<br>";
	}
	*/
	public function select_branch($target_serial_branch){
		//print "target_serial_branch=".$target_serial_branch."<br>";
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

	public function search(){
		$this->serch_key_p=$this->kensakukey;
		session(['serchKey' => $this->kensakukey]);
	}

	public function render()
    {
        if(isset($_SERVER['HTTP_REFERER'])){
			OtherFunc::set_access_history($_SERVER['HTTP_REFERER']);
		}
		$UserSerial=session('targetUserSerial');
        $htm_branch_rdo=OtherFunc::make_html_branch_rdo_for_contract_list();
        $Contracts="";
		$contractQuery = Contract::query();
		//print 'target_branch_serial='.session('target_branch_serial')."<br>";
		//print 'targetUserSerial='.session('targetUserSerial')."<br>";
		self::$key="%".session('serchKey')."%";
		if(session('targetUserSerial')=="all"){
			$userinf="";
			if(session('target_branch_serial')=='all'){
				$contractQuery=$contractQuery->leftjoin('users', 'contracts.serial_user', '=', 'users.serial_user')
					->where('contracts.serial_keiyaku','like',self::$key)
					->orwhere('contracts.serial_user','like',self::$key)
					->orwhere('users.name_mei','like',self::$key)
					->orwhere('users.name_sei','like',self::$key)
					->orwhere('users.name_sei_kana','like',self::$key)
					->orwhere('users.name_mei_kana','like',self::$key)
					->orwhere('date_latest_visit','like',self::$key)
					->orwhere('keiyaku_bi','like',self::$key)
					->orwhere('keiyaku_kikan_start','like',self::$key)
					->orwhere('keiyaku_kikan_end','like',self::$key)
					->orwhere('keiyaku_kingaku','like',self::$key)
					->orwhere('how_to_pay','like',self::$key)
					->orwhere('how_many_pay_genkin','like',self::$key)
					->orwhere('how_many_pay_card','like',self::$key);
				//$Contracts=Contract::leftjoin('users', 'contracts.serial_user', '=', 'users.serial_user')->paginate(initConsts::DdisplayLineNumContractList());
			}else{
				$contractQuery=$contractQuery->leftjoin('users', 'contracts.serial_user', '=', 'users.serial_user')
					->where('users.serial_branch','=',session('target_branch_serial'))
					->Where(function($query) {
						$query->where('contracts.serial_keiyaku','like',self::$key)
							->orwhere('contracts.serial_user','like',self::$key)
							->orwhere('users.name_mei','like',self::$key)
							->orwhere('users.name_sei','like',self::$key)
							->orwhere('users.name_sei_kana','like',self::$key)
							->orwhere('users.name_mei_kana','like',self::$key)
							->orwhere('date_latest_visit','like',self::$key)
							->orwhere('keiyaku_bi','like',self::$key)
							->orwhere('keiyaku_kikan_start','like',self::$key)
							->orwhere('keiyaku_kikan_end','like',self::$key)
							->orwhere('keiyaku_kingaku','like',self::$key)
							->orwhere('how_to_pay','like',self::$key)
							->orwhere('how_many_pay_genkin','like',self::$key)
							->orwhere('how_many_pay_card','like',self::$key);
					});
					
				/*
				$contractQuery=$contractQuery->leftjoin('users', 'contracts.serial_user', '=', 'users.serial_user')
					->where('users.serial_branch','=',session('target_branch_serial'))
					->where('contracts.serial_keiyaku','like',self::$key)
					->orwhere('contracts.serial_user','like',self::$key)
					->orwhere('users.name_mei','like',self::$key)
					->orwhere('users.name_sei','like',self::$key)
					->orwhere('users.name_sei_kana','like',self::$key)
					->orwhere('users.name_mei_kana','like',self::$key)
					->orwhere('date_latest_visit','like',self::$key)
					->orwhere('keiyaku_bi','like',self::$key)
					->orwhere('keiyaku_kikan_start','like',self::$key)
					->orwhere('keiyaku_kikan_end','like',self::$key)
					->orwhere('keiyaku_kingaku','like',self::$key)
					->orwhere('how_to_pay','like',self::$key)
					->orwhere('how_many_pay_genkin','like',self::$key)
					->orwhere('how_many_pay_card','like',self::$key);
				*/
				/*
				$Contracts=Contract::leftjoin('users', 'contracts.serial_user', '=', 'users.serial_user')
					->where('users.serial_branch','=',session('target_branch_serial'))
					->paginate(initConsts::DdisplayLineNumContractList());
				*/
			}
			$GoBackPlace="/ShowMenuCustomerManagement/";
		}else{
			$GoBackPlace="/customers/UserList";
			//$userinf=User::where('serial_user','=',$UserSerial)->first();
			$userinf=User::where('serial_user','=',session('targetUserSerial'))->first();
			if(session('target_branch_serial')=='all'){
				$contractQuery=$contractQuery->leftjoin('users', 'contracts.serial_user', '=', 'users.serial_user')
					->select('contracts.*', 'users.*')	
					->where('contracts.serial_user','=',session('targetUserSerial'))
					->Where(function($query) {
						$query->where('contracts.serial_keiyaku','like',self::$key)
							->orwhere('contracts.serial_user','like',self::$key)
							->orwhere('users.name_mei','like',self::$key)
							->orwhere('users.name_sei','like',self::$key)
							->orwhere('users.name_sei_kana','like',self::$key)
							->orwhere('users.name_mei_kana','like',self::$key)
							->orwhere('date_latest_visit','like',self::$key)
							->orwhere('keiyaku_bi','like',self::$key)
							->orwhere('keiyaku_kikan_start','like',self::$key)
							->orwhere('keiyaku_kikan_end','like',self::$key)
							->orwhere('keiyaku_kingaku','like',self::$key)
							->orwhere('how_to_pay','like',self::$key)
							->orwhere('how_many_pay_genkin','like',self::$key)
							->orwhere('how_many_pay_card','like',self::$key);
					});
				/*
				$Contracts=Contract::where('contracts.serial_user','=',session('targetUserSerial'))
					->leftjoin('users', 'contracts.serial_user', '=', 'users.serial_user')
					->select('contracts.*', 'users.*')
					->paginate(initConsts::DdisplayLineNumContractList());
				*/
				/*
					$sqlck=Contract::where('contracts.serial_user','=',session('targetUserSerial'))
					->leftjoin('users', 'contracts.serial_user', '=', 'users.serial_user')
					->select('contracts.*', 'users.*');
					dd($sqlck->toSql(), $sqlck->getBindings());
				*/
			}else{
				$contractQuery=$contractQuery->where('contracts.serial_user','=',session('targetUserSerial'))
					->leftjoin('users', 'contracts.serial_user', '=', 'users.serial_user')
					->where('users.serial_branch','=',session('target_branch_serial'))
					->select('contracts.*', 'users.*')
					->Where(function($query) {
						$query->orwhere('contracts.serial_keiyaku','like',self::$key)
						->orwhere('contracts.serial_user','like',self::$key)
						->orwhere('users.name_mei','like',self::$key)
						->orwhere('users.name_sei','like',self::$key)
						->orwhere('users.name_sei_kana','like',self::$key)
						->orwhere('users.name_mei_kana','like',self::$key)
						->orwhere('date_latest_visit','like',self::$key)
						->orwhere('keiyaku_bi','like',self::$key)
						->orwhere('keiyaku_kikan_start','like',self::$key)
						->orwhere('keiyaku_kikan_end','like',self::$key)
						->orwhere('keiyaku_kingaku','like',self::$key)
						->orwhere('how_to_pay','like',self::$key)
						->orwhere('how_many_pay_genkin','like',self::$key)
						->orwhere('how_many_pay_card','like',self::$key);
					});
				/*
				$Contracts=Contract::where('contracts.serial_user','=',session('targetUserSerial'))
				->leftjoin('users', 'contracts.serial_user', '=', 'users.serial_user')
				->where('users.serial_branch','=',session('target_branch_serial'))
				->select('contracts.*', 'users.*')
				->paginate(initConsts::DdisplayLineNumContractList());
				*/
				/*
				$sqlck=Contract::where('contracts.serial_user','=',session('targetUserSerial'))
				->leftjoin('users', 'contracts.serial_user', '=', 'users.serial_user')
				->where('users.serial_branch','=',session('target_branch_serial'))
				->select('contracts.*', 'users.*');
				dd($sqlck->toSql(), $sqlck->getBindings());
				*/
			}
		}
		
			//$key="%".session('serchKey')."%";
		/*
			$contractQuery =$contractQuery->where('contracts.serial_keiyaku','like',self::$key)
			->orwhere('contracts.serial_user','like',self::$key)
			->orwhere('users.name_mei','like',self::$key)
			->orwhere('users.name_sei','like',self::$key)
			->orwhere('users.name_sei_kana','like',self::$key)
			->orwhere('users.name_mei_kana','like',self::$key)
			->orwhere('date_latest_visit','like',self::$key)
			->orwhere('keiyaku_bi','like',self::$key)
			->orwhere('keiyaku_kikan_start','like',self::$key)
			->orwhere('keiyaku_kikan_end','like',self::$key)
			->orwhere('keiyaku_kingaku','like',self::$key)
			->orwhere('how_to_pay','like',self::$key)
			->orwhere('how_many_pay_genkin','like',self::$key)
			->orwhere('how_many_pay_card','like',self::$key);
			*/
		/*
		if(session('target_branch_serial')=='all'){
			$contractQuery =$contractQuery->where('contracts.serial_keiyaku','like',self::$key)
				->orwhere('contracts.serial_user','like',self::$key)
				->orwhere('users.name_mei','like',self::$key)
				->orwhere('users.name_sei','like',self::$key)
				->orwhere('users.name_sei_kana','like',self::$key)
				->orwhere('users.name_mei_kana','like',self::$key)
				->orwhere('date_latest_visit','like',self::$key)
				->orwhere('keiyaku_bi','like',self::$key)
				->orwhere('keiyaku_kikan_start','like',self::$key)
				->orwhere('keiyaku_kikan_end','like',self::$key)
				->orwhere('keiyaku_kingaku','like',self::$key)
				->orwhere('how_to_pay','like',self::$key)
				->orwhere('how_many_pay_genkin','like',self::$key)
				->orwhere('how_many_pay_card','like',self::$key);
		}else{
			$contractQuery =$contractQuery->where('contracts.serial_keiyaku','like',self::$key)
				->orwhere('contracts.serial_user','like',self::$key)
				->orwhere('users.name_mei','like',self::$key)
				->orwhere('users.name_sei','like',self::$key)
				->orwhere('users.name_sei_kana','like',self::$key)
				->orwhere('users.name_mei_kana','like',self::$key)
				->orwhere('date_latest_visit','like',self::$key)
				->orwhere('keiyaku_bi','like',self::$key)
				->orwhere('keiyaku_kikan_start','like',self::$key)
				->orwhere('keiyaku_kikan_end','like',self::$key)
				->orwhere('keiyaku_kingaku','like',self::$key)
				->orwhere('how_to_pay','like',self::$key)
				->orwhere('how_many_pay_genkin','like',self::$key)
				->orwhere('how_many_pay_card','like',self::$key);
			
			$contractQuery=$contractQuery->where('serial_branch','=',session('target_branch_serial'))
				->Where(function($query) {
					$query->orwhere('contracts.serial_keiyaku','like',self::$key)
					->orwhere('contracts.serial_user','like',self::$key)
					->orwhere('users.name_mei','like',self::$key)
					->orwhere('users.name_sei','like',self::$key)
					->orwhere('users.name_sei_kana','like',self::$key)
					->orwhere('users.name_mei_kana','like',self::$key)
					->orwhere('date_latest_visit','like',self::$key)
					->orwhere('keiyaku_bi','like',self::$key)
					->orwhere('keiyaku_kikan_start','like',self::$key)
					->orwhere('keiyaku_kikan_end','like',self::$key)
					->orwhere('keiyaku_kingaku','like',self::$key)
					->orwhere('how_to_pay','like',self::$key)
					->orwhere('how_many_pay_genkin','like',self::$key)
					->orwhere('how_many_pay_card','like',self::$key);
				});
			
		}
		*/
		//dd($contractQuery->toSql(), $contractQuery->getBindings());
		$contractQuery=$contractQuery->paginate(initConsts::DdisplayLineNumContractList());
		//$access_history=implode( ",", $_SESSION['access_history'] );
		foreach($_SESSION['access_history'] as $targetHistory){
			if(strpos($targetHistory,"UserList")){
				$GoBackPlace="/ShowUserList";
				$GoBackPlaceName="戻る";
				break;
			}else if(strpos($targetHistory,"menuStaff")){
				$GoBackPlace="";
				$GoBackPlaceName="";
			}
		}
        return view('livewire.contract-search',compact("GoBackPlaceName","GoBackPlace","userinf","contractQuery","UserSerial","htm_branch_rdo"));
		//return view('livewire.contract-search',compact("userinf","Contracts","UserSerial"));
    }
}