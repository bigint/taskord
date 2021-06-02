<?php

namespace App\Http\Livewire\Notification\Type\Milestone;

use App\Models\Milestone;
use Livewire\Component;

class MilestonePraised extends Component
{
    public $data;

    public function mount($data)
    {
        $this->data = $data;
    }

    public function render()
    {
        $milestone = Milestone::find($this->data['milestone_id']);

        return view('livewire.notification.type.milestone.milestone-praised', [
            'milestone' => $milestone,
        ]);
    }
}
