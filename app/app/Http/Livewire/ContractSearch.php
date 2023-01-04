<?php

namespace App\Http\Livewire;

use Livewire\Component;

class ContractSearch extends Component
{
    public $title="title0";
	
	public function ct(){
		$this->title="New Title";
		print "title=".$this->title."<br>";
	}
    public function render()
    {
        return view('livewire.contract-search');
    }
}
