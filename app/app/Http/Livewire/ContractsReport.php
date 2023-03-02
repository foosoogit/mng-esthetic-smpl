<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Keiyaku;
use App\Http\Controllers\OtherFunc;
use App\Http\Controllers\InitConsts;

class ContractsReport extends Component
{
    public function render()
    {
        $html_year_slct=OtherFunc::make_html_year_slct($_POST['year']);
		$html_month_slct=OtherFunc::make_html_month_slct($_POST['month']);
		list($htm_month_table, $ruikei_keiyaku_amount ,$ruikei_contract_cnt)=OtherFunc::make_html_contract_report_table($_POST['year'],$_POST['month']);
		$contract_report_table=$htm_month_table;
		$targetYear=$_POST['year'];
		$targetMonth=$_POST['month'];
		$value=initConsts::TargetContractMoney();
    	$targetmony_array=explode( ',', $value);
		$TargetSales="--";
    	foreach($targetmony_array as $targetmony){
    		$array=explode( '-', $targetmony);
    		if($array[0]==$targetYear and $array[1]==$targetMonth){
    			$TargetSales=$array[2];
    			break;
    		}
    	}
    	$rate="--";
        //print "TargetSales=".$TargetSales."<br>";
    	if($TargetSales<>0 and is_null($TargetSales)==false and $TargetSales<>"" and $TargetSales<>"--"){
   			$rate=round((int)$ruikei_keiyaku_amount/(int)$TargetSales*100, 1);
   		}

        return view('livewire.contracts-report',compact('contract_report_table','targetYear','ruikei_keiyaku_amount','ruikei_contract_cnt','targetMonth','html_year_slct','html_month_slct','rate','TargetSales'));
    }
}
