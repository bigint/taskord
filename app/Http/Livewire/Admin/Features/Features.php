<?php

namespace App\Http\Livewire\Admin\Features;

use App\Models\Feature;
use Livewire\Component;

class Features extends Component
{
    public function render()
    {
        $features = Feature::latest()->get();

        return view('livewire.admin.features.features', [
            'features' => $features,
        ]);
    }
}
