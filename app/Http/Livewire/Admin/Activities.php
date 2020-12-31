<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination;
use Spatie\Activitylog\Models\Activity;

class Activities extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $readyToLoad = false;

    public function loadActivities()
    {
        $this->readyToLoad = true;
    }

    public function render()
    {
        $activities = Activity::latest()->paginate('50');
        $count = Activity::all()->count('id');

        return view('livewire.admin.activities', [
            'activities' => $this->readyToLoad ? $activities : [],
            'count' => number_format($count),
        ]);
    }
}
