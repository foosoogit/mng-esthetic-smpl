<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Branch;
use Livewire\WithPagination;

class BranchList extends Component
{
    use WithPagination;
    public function render()
    {
        $Branches = Branch::orderBy('serial_branch')->paginate(15);
        return view('livewire.branch-list',compact('Branches'));
    }
}
