<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Http\Controllers\OtherFunc;

class YearlyReport extends Component
{
    public function render()
    {
        $header="";$slot="";
    	$yearly_report_table=OtherFunc::make_html_yearly_Report_table($_POST['year'],$_POST['kesan_month']);

        return view('livewire.yearly-report',compact('header','slot','yearly_report_table'));
    }
}
