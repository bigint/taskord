<?php

namespace App\Http\Livewire\Meetup;

use Livewire\Component;
use App\Models\Meetup;

class SingleMeetup extends Component
{
    public Meetup $meetup;

    public function mount($meetup)
    {
        $this->meetup = $meetup;
    }
}
