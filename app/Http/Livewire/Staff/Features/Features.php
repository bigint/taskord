<?php

namespace App\Http\Livewire\Staff\Features;

use App\Models\Feature;
use Livewire\Component;

class Features extends Component
{
    public $ready_to_load = false;

    public function loadFeatures()
    {
        $this->ready_to_load = true;
    }

    public function render()
    {
        return view('livewire.staff.features.features', [
            'features' => $this->ready_to_load ? Feature::latest()->get() : [],
        ]);
    }
}
