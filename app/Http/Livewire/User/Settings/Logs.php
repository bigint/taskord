<?php

namespace App\Http\Livewire\User\Settings;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Spatie\Activitylog\Models\Activity;
use Livewire\WithPagination;

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
        $activities = Activity::where('causer_id', $this->user->id)
            ->paginate(10);

        return view('livewire.user.settings.logs', [
            'activities' => $activities
        ]);
    }
}
