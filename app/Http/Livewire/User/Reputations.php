<?php

namespace App\Http\Livewire\User;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class Reputations extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $readyToLoad = false;

    public function loadReputations()
    {
        $this->readyToLoad = true;
    }

    public function render()
    {
        $points = DB::table('reputations')
            ->where('payee_id', Auth::id())
            ->latest()
            ->paginate(50);

        return view('livewire.user.reputations', [
            'points' => $this->readyToLoad ? $points : [],
        ]);
    }
}
