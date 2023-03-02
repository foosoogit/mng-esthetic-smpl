<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Http\Controllers\InitConsts;
use App\Models\TreatmentContent;

class TreatmentContents extends Component
{
    public function render()
    {
        $header="";$slot="";
		$treatment_contents=TreatmentContent::orderBy('name_treatment_contents_kana')->paginate(initConsts::DdisplayLineNumCustomerList());
		return view('livewire.treatment-contents',compact('treatment_contents','header','slot'));

        //return view('livewire.treatment-contents');
    }
}