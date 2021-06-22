<?php

namespace App\Http\Livewire\Task;

use Livewire\Component;
use App\Models\Oembed as OembedType;

class Oembed extends Component
{
    public OembedType $oembed;

    public function mount($oembed)
    {
        $this->oembed = $oembed;
    }

    public function render()
    {
        return view('livewire.task.oembed');
    }
}
