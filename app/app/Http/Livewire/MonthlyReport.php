<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Keiyaku;
use App\Models\PaymentHistory;
use App\Models\SalesRecord;
use App\Models\Good;
use App\Http\Controllers\InitConsts;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\constract;
use App\Http\Controllers\OtherFunc;
use App\Models\Staff;
use App\Models\User;

class MonthlyReport extends Component
{
    public function select_branch($target_serial_branch){
        session(['target_branch_serial' => $target_serial_branch]);
        //self::$serial_branch=$target_serial_branch;
        Staff::where('serial_staff', '=', Auth::user()->serial_staff)->update([
            'selected_branch' => session('target_branch_serial'),
        ]);
	}
   
    public function render()
    {
        if(isset($_SERVER['HTTP_REFERER'])){
			OtherFunc::set_access_history($_SERVER['HTTP_REFERER']);
		}
        $split_year_month_day_array=array();
    	if(isset($_POST['year_month_day'])){
    		$split_year_month_day_array=explode( '-', $_POST['year_month_day'] );
    		$targetYear=$split_year_month_day_array[0];
    		$targetMonth=$split_year_month_day_array[1];
            session(['targetYear' => $split_year_month_day_array[0]]);
            session(['targetMonth' => $split_year_month_day_array[1]]);
    	}else if(isset($_POST['year']) and isset($_POST['month'])){
    	    $targetYear=$_POST['year'];
    		$targetMonth=$_POST['month'];
            session(['targetYear' => $_POST['year']]);
            session(['targetMonth' => $_POST['month']]);
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
   	
    	$RaitenReason="来店理由 : ".OtherFunc::get_raitenReason(session('targetYear'),session('targetMonth'));
    	$htm_branch_cbox=OtherFunc::make_html_branch_rdo_for_monthly_report();
        //$html_year_slct=OtherFunc::make_html_year_slct($targetYear);
        $html_year_slct=OtherFunc::make_html_year_slct(session('targetYear'));
		//$html_month_slct=OtherFunc::make_html_month_slct($targetMonth);
        $html_month_slct=OtherFunc::make_html_month_slct(session('targetMonth'));
    	$monthly_report_table=OtherFunc::make_html_monthly_report_table(session('targetYear'),session('targetMonth'));
        $monthly_report_table=OtherFunc::make_html_monthly_report_table(session('targetYear'),session('targetMonth'));
        $tst=session('target_branch_serial');$targetYear=session('targetYear');$targetMonth=session('targetMonth');
       return view('livewire.monthly-report',compact('tst','htm_branch_cbox','monthly_report_table','targetYear','targetMonth','html_year_slct','html_month_slct','RaitenReason'));
    }
}
