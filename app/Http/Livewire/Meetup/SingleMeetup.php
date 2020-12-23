<?php

namespace App\Http\Livewire\Meetup;

use Livewire\Component;

class SingleMeetup extends Component
{
    public $meetup;

    public function mount($meetup)
    {
        $this->meetup = $meetup;
    }
}
