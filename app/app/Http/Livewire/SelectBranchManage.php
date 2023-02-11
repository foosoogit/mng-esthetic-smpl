<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Http\Controllers\OtherFunc;
use App\Models\Staff;
use Illuminate\Support\Facades\Auth;
if(!isset($_SESSION)){session_start();}

class SelectBranchManage extends Component
{
    public static $serial_branch = '';

    public function select_branch($target_serial_branch){
        session(['target_branch_serial' => $target_serial_branch]);
        self::$serial_branch=$target_serial_branch;
        Staff::where('serial_staff', '=', Auth::user()->serial_staff)->update([
            'selected_branch' => session('target_branch_serial'),
        ]);
	}

    public function render()
    {
        $default_customers=OtherFunc::make_htm_get_default_user();
        $T=self::$serial_branch;
        $htm_branch_cbox=OtherFunc::make_html_branch_rdo();
        $not_coming_customers=OtherFunc::make_htm_get_not_coming_customer();
        return view('livewire.select-branch-manage',compact("htm_branch_cbox","T","default_customers","not_coming_customers"));
    }
}