<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;
use Spatie\Activitylog\Models\Activity;
use Livewire\WithPagination;

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
            'activities' => $activities,
            'count' => number_format($count),
        ]);
    }
}
