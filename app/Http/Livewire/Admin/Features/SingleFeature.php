<?php

namespace App\Http\Livewire\Admin\Features;

use App\Models\Feature;
use Livewire\Component;

class SingleFeature extends Component
{
    public Feature $feature;
    public $staffStatus;
    public $betaStatus;

    public function mount($feature)
    {
        $this->feature = $feature;
        $this->staffStatus = $feature->staff;
        $this->betaStatus = $feature->beta;
    }

    public function betaToggle()
    {
        $this->feature->beta = $this->betaStatus;
        if ($this->betaStatus) {
            $this->feature->staff = true;
        }
        $this->feature->save();
    }

    public function staffToggle()
    {
        $this->feature->staff = $this->staffStatus;
        $this->feature->save();
    }

    public function render()
    {
        return view('livewire.admin.features.single-feature');
    }
}
