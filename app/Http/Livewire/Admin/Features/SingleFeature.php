<?php

namespace App\Http\Livewire\Admin\Features;

use App\Models\Feature;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class SingleFeature extends Component
{
    public Feature $feature;
    public $staffStatus;
    public $contributorStatus;
    public $betaStatus;
    public $confirming;

    public function mount($feature)
    {
        $this->feature = $feature;
        $this->staffStatus = $feature->staff;
        $this->contributorStatus = $feature->contributor;
        $this->betaStatus = $feature->beta;
    }

    public function contributorToggle()
    {
        $this->feature->contributor = $this->contributorStatus;
        if ($this->contributorStatus) {
            $this->feature->staff = true;
        }
        $this->feature->save();
    }

    public function betaToggle()
    {
        $this->feature->beta = $this->betaStatus;
        if ($this->betaStatus) {
            $this->feature->staff = true;
            $this->feature->contributor = true;
        }
        $this->feature->save();
    }

    public function staffToggle()
    {
        $this->feature->staff = $this->staffStatus;
        $this->feature->save();
    }

    public function confirmDelete()
    {
        $this->confirming = $this->feature->id;
    }

    public function deleteFeature()
    {
        if (Auth::check()) {
            loggy(request()->ip(), 'Admin', auth()->user(), 'Deleted a feature flag | Feature ID: '.$this->feature->id);
            $this->feature->delete();
            auth()->user()->touch();
            $this->flash('success', 'Feature flag has been deleted successfully!');

            return redirect()->route('admin.features');
        } else {
            return $this->alert('error', 'Forbidden!');
        }
    }

    public function render()
    {
        return view('livewire.admin.features.single-feature');
    }
}
