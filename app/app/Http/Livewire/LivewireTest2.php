<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\User;
use Livewire\WithPagination;
use App\Http\Controllers\InitConsts;
use App\Models\Contract;
use Illuminate\Http\Request;
use App\Http\Controllers\OtherFunc;
if(!isset($_SESSION)){session_start();}

class LivewireTest2 extends Component
{
    use WithPagination;
    public $count = 5;
    public $sort_key_p = '',$asc_desc_p="",$serch_key_p="";
    public function increment()
    {
        $this->count++;
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
        //$userQuery = User::query();
        //$userQuery = User::paginate(10);

        if(!isset($sort_key_p) and session('sort_key')==null){
			session(['sort_key' =>'']);
		}
		$this->sort_key_p=session('sort_key');

		if(!isset($asc_desc_p) and session('asc_desc')==null){
			session(['asc_desc' =>'ASC']);
		}
		$this->asc_desc_p=session('asc_desc');
        $userQuery = User::query();

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
        $userQuery =$userQuery->orderBy('name_sei_kana', 'asc');
        $targetPage=null;
        $users=$userQuery->paginate($perPage = initConsts::DdisplayLineNumCustomerList(),['*'], 'page',$targetPage);
       // $users=User::paginate($perPage = initConsts::DdisplayLineNumCustomerList(),['*'], 'page',$targetPage);
        $from_place="";$header="";$slot="";$target_day="";
        //$totalZankin=Contract::sum('keiyaku_kingaku')-PaymentHistory::sum('amount_payment');
        $totalZankin=0;
        return view('livewire.livewire-test2',compact('users','header','slot','totalZankin','from_place','target_day','from_place'));
    }
}