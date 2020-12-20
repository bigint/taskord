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

    public function render()
    {
        return view('livewire.meetup.single-meetup');
    }
}
