<?php

namespace App\Http\Livewire\Staff;

use Illuminate\Contracts\View\View;
use Livewire\Component;
use Livewire\WithPagination;
use Spatie\Activitylog\Models\Activity;

class Activities extends Component
{
    use WithPagination;

    public $readyToLoad = false;
    protected $paginationTheme = 'bootstrap';

    public function loadActivities()
    {
        $this->readyToLoad = true;
    }

    public function getActivities()
    {
        return Activity::latest()->paginate('50');
    }

    public function render(): View
    {
        return view('livewire.staff.activities', [
            'activities' => $this->readyToLoad ? $this->getActivities() : [],
            'count' => number_format(Activity::count('id')),
        ]);
    }
}
