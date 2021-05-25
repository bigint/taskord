<?php

namespace App\Http\Livewire\Staff\Features;

use App\Models\Feature;
use Livewire\Component;

class Features extends Component
{
    public $readyToLoad = false;

    public function loadFeatures()
    {
        $this->readyToLoad = true;
    }

    public function render()
    {
        return view('livewire.staff.features.features', [
            'features' => $this->readyToLoad ? Feature::latest()->get() : [],
        ]);
    }
}
