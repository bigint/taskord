<?php

namespace App\Http\Livewire\User\Settings;

use App\Models\User;
use Illuminate\Contracts\View\View;
use Livewire\Component;
use Livewire\WithPagination;
use Spatie\Activitylog\Models\Activity;

class Logs extends Component
{
    use WithPagination;

    public User $user;
    protected $paginationTheme = 'bootstrap';

    public function mount($user)
    {
        $this->user = $user;
    }

    public function render(): View
    {
        $activities = Activity::causedBy($this->user)
            ->latest()
            ->paginate(10);

        return view('livewire.user.settings.logs', [
            'activities' => $activities,
        ]);
    }
}
