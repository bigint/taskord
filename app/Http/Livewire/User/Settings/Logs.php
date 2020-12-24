<?php

namespace App\Http\Livewire\User\Settings;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;
use Spatie\Activitylog\Models\Activity;

class Logs extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public User $user;

    public function mount($user)
    {
        $this->user = $user;
    }

    public function render()
    {
        $activities = Activity::causedBy($this->user)
            ->latest()
            ->paginate(10);

        return view('livewire.user.settings.logs', [
            'activities' => $activities,
        ]);
    }
}
