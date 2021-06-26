<?php

namespace App\Http\Livewire\Task;

use App\Models\Oembed as OembedType;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class Oembed extends Component
{
    public OembedType $oembed;

    public function mount($oembed)
    {
        $this->oembed = $oembed;
    }

    public function render(): View
    {
        return view('livewire.task.oembed');
    }
}
