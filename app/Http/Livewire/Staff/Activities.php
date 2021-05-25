<?php

namespace App\Http\Livewire\Staff;

use Livewire\Component;
use Livewire\WithPagination;
use Spatie\Activitylog\Models\Activity;

class Activities extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $ready_to_load = false;

    public function loadActivities()
    {
        $this->ready_to_load = true;
    }

    public function getActivities()
    {
        return Activity::latest()->paginate('50');
    }

    public function render()
    {
        return view('livewire.staff.activities', [
            'activities' => $this->ready_to_load ? $this->getActivities() : [],
            'count' => number_format(Activity::count('id')),
        ]);
    }
}
