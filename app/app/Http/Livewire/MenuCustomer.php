<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Http\Controllers\OtherFunc;

class MenuCustomer extends Component
{
    public function render()
    {
        $default_customers=OtherFunc::make_htm_get_default_user();
        return view('livewire.menu-customer',compact("default_customers"));
    }
}
