<?php

namespace App\Http\Livewire\Meetup;

use App\Models\Meetup;
use Livewire\Component;

class SingleMeetup extends Component
{
    public Meetup $meetup;

    public function mount($meetup)
    {
        $this->meetup = $meetup;
    }
}
