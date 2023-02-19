<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\constract;
use App\Models\PaymentHistory;
use App\Models\SalesRecord;
use App\Models\Good;
use Livewire\WithPagination;
use Illuminate\Http\Request;
use App\Http\Controllers\InitConsts;
use App\Http\Controllers\OtherFunc;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Staff;
use Illuminate\Support\Facades\Auth;
if(!isset($_SESSION)){session_start();}

class DailyReport extends Component
{
    public static $serial_branch = '';
    
    public function select_branch_for_daily_report($target_serial_branch){
        //print "target_serial_branch=".$target_serial_branch."<br>";
        session(['target_branch_serial' => $target_serial_branch]);
        self::$serial_branch=$target_serial_branch;
        Staff::where('serial_staff', '=', Auth::user()->serial_staff)->update([
            'selected_branch' => session('target_branch_serial'),
        ]);
	}

    public function sort($sort_key){
		$sort_key_array=array();
		$sort_key_array=explode("-", $sort_key);
		$this->sort_key_p=$sort_key_array[0];
		$this->asc_desc_p=$sort_key_array[1];
		session(['sort_key' =>$sort_key_array[0]]);
		session(['asc_desc' =>$sort_key_array[1]]);
	}

    public function render()
    {
        $header="";$slot="";
        $today = date("Y-m-d");
        $from_place="";
        OtherFunc::set_access_history($_SERVER['HTTP_REFERER']);
        $backmonthly="";

        foreach($_SESSION['access_history'] as $targeturl){
            if(strpos($targeturl, 'ShowMonthlyReport') !== false){
                $backmonthly=true;
                break;
            }else if (strpos($targeturl, 'ShowMenuCustomerManagement') !== false){
                $backmonthly=false;
                break;
            }
        }
        if($backmonthly===true){
            if(isset($_POST['target_date_from_monthly_rep'])){
                $today=$_POST['target_date_from_monthly_rep'];
            }else{
                $today=$_SESSION['backmonthday'];
            }
            $from_place="monthly_rep";
        }else if(isset($_POST['target_date'])){
            $today=$_POST['target_date'];
        }else if(isset($_POST['target_date_from_monthly_rep'])){
            $today=$_POST['target_date_from_monthly_rep'];
            $from_place="monthly_rep";
        }

        $staff_inf=Staff::where('serial_staff','=',Auth::user()->serial_staff)->first();
        if(isset($_POST['branch_rdo'])){
            if($staff_inf->selected_branch<>$_POST['branch_rdo'] and isset($_POST['branch_rdo'])){
                session(['target_branch_serial' => $_POST['branch_rdo']]);
                //self::$serial_branch=$target_serial_branch;

                //update(['date_latest_visit' =>$date_latest_visit])
                Staff::where('serial_staff', '=', Auth::user()->serial_staff)->update(['selected_branch' => $_POST['branch_rdo']]);
            }
        }else{
            session(['target_branch_serial' => $staff_inf->selected_branch]);
        }

        if(session('target_branch_serial')=="all" or session('target_branch_serial')== NULL){
            $PaymentHistories=PaymentHistory::where('date_payment','=',$today)
                ->leftJoin('users', 'payment_histories.serial_user', '=', 'users.serial_user')
                ->paginate(initConsts::DdisplayLineNumCustomerList());
            $subtotal_treatment=PaymentHistory::where('date_payment','=',$today)->sum('amount_payment');
        }else{
            $PaymentHistories=PaymentHistory::where('date_payment','=',$today)
            ->whereIn('payment_histories.serial_user', User::select('serial_user')->where('serial_branch','=', session('target_branch_serial')))
            ->leftJoin('users', 'payment_histories.serial_user', '=', 'users.serial_user')->dump();
            //dd($PaymentHistories->toSql(), $PaymentHistories->getBindings());
           
            $PaymentHistories=PaymentHistory::where('date_payment','=',$today)
            ->whereIn('payment_histories.serial_user', User::select('serial_user')->where('serial_branch','=', session('target_branch_serial')))
            ->leftJoin('users', 'payment_histories.serial_user', '=', 'users.serial_user')
            ->paginate(initConsts::DdisplayLineNumCustomerList());
            /*
            $PaymentHistories=PaymentHistory::where('date_payment','=',$today)
                ->whereIn('PaymentHistory.serial_user', User::select('serial_user')->where('serial_branch','=', session('target_branch_serial')))
                ->leftJoin('users', 'payment_histories.serial_user', '=', 'users.serial_user')
                ->paginate(initConsts::DdisplayLineNumCustomerList());
            */
            /*
            $PaymentHistories=PaymentHistory::where('date_payment','=',$today)
                ->leftJoin('users', 'payment_histories.serial_user', '=', session('target_branch_serial'))
                ->where('users.serial_branch','=',$today)
                ->paginate(initConsts::DdisplayLineNumCustomerList());
            */
            $subtotal_treatment=PaymentHistory::where('date_payment','=',$today)->sum('amount_payment');
        }
        //print_r( $PaymentHistories);
        //$subtotal_treatment=PaymentHistory::where('date_payment','=',$today)->sum('amount_payment');
        
        $SalesRecords=SalesRecord::where('date_sale','=',$today)
            ->leftJoin('users', 'sales_records.serial_user', '=', 'users.serial_user')
            ->leftJoin('goods', 'sales_records.serial_good', '=', 'goods.serial_good')
            ->paginate(initConsts::DdisplayLineNumCustomerList());
            
        $subtotal_good=SalesRecord::where('date_sale','=',$today)->sum('selling_price');
        $total=$subtotal_treatment+$subtotal_good;
        $Sum=array();
        $Sum['cash']=PaymentHistory::where('date_payment','=',$today)
                ->leftJoin('contracts', 'payment_histories.serial_keiyaku', '=', 'contracts.serial_keiyaku')
                ->where('payment_histories.how_to_pay','=','cash')
                 ->where(function($query) {
                    $query->where('contracts.how_many_pay_genkin','=',1)->orWhere('contracts.how_many_pay_card','=',1);
                })
            ->sum('amount_payment');
    
        $Sum['card']=PaymentHistory::where('date_payment','=',$today)
                ->where('date_payment','=',$today)
                ->where('how_to_pay','=','card')
            ->sum('amount_payment');
    
        $Sum['CashSplit']=PaymentHistory::where('date_payment','=',$today)
                ->leftJoin('contracts', 'payment_histories.serial_keiyaku', '=', 'contracts.serial_keiyaku')
                ->where('payment_histories.how_to_pay','=','cash')
                 ->where(function($query) {
                    $query->where('contracts.how_many_pay_genkin','>',1)->orWhere('contracts.how_many_pay_card','>',1);
                })->sum('amount_payment');
        $Sum['total_cash']=$Sum['cash']+$Sum['CashSplit'];
        $Sum['total']=$Sum['cash']+$Sum['card']+$Sum['CashSplit'];

        session(['targetDay' => $today]);
        $_SESSION['backmonthday']=$today;
        $htm_branch_cbox=OtherFunc::make_html_branch_rdo_for_daily_report();
        //$T="";
        //$htm_branch_cbox=OtherFunc::make_html_branch_rdo();
        //$T=self::session('target_branch_serial');
        //$T=$_POST['branch_rdo'];
        return view('livewire.daily-report',compact('PaymentHistories','SalesRecords','header','slot','today','subtotal_treatment','subtotal_good','total','Sum','from_place','htm_branch_cbox'));
    }
}