<?php

namespace App\Http\Livewire\Notification\Type\Milestone;

use App\Models\Milestone;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class MilestoneLiked extends Component
{
    public $data;

    public function mount($data)
    {
        $this->data = $data;
    }

    public function render(): View
    {
        $milestone = Milestone::find($this->data['milestone_id']);

        return view('livewire.notification.type.milestone.milestone-liked', [
            'milestone' => $milestone,
        ]);
    }
}
