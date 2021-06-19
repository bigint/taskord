<?php

namespace App\Http\Livewire\Staff\Features;

use App\Models\Feature;
use Livewire\Component;

class SingleFeature extends Component
{
    public Feature $feature;
    public $staffStatus;
    public $contributorStatus;
    public $betaStatus;
    public $publicStatus;
    public $confirming;

    public function mount($feature)
    {
        $this->feature = $feature;
        $this->staffStatus = $feature->staff;
        $this->contributorStatus = $feature->contributor;
        $this->betaStatus = $feature->beta;
        $this->publicStatus = $feature->public;
    }

    public function staffToggle()
    {
        $this->feature->staff = $this->staffStatus;
        if (! $this->staffStatus) {
            $this->feature->beta = false;
            $this->feature->contributor = false;
            $this->feature->public = false;
        }
        $this->feature->save();

        return loggy(request(), 'Staff', auth()->user(), "Toggled staff feature flag | Feature ID: {$this->feature->id}");
    }

    public function contributorToggle()
    {
        $this->feature->contributor = $this->contributorStatus;
        if ($this->contributorStatus) {
            $this->feature->staff = true;
        }
        $this->feature->save();

        return loggy(request(), 'Staff', auth()->user(), "Toggled contributor feature flag | Feature ID: {$this->feature->id}");
    }

    public function betaToggle()
    {
        $this->feature->beta = $this->betaStatus;
        if ($this->betaStatus) {
            $this->feature->staff = true;
            $this->feature->contributor = true;
        }
        $this->feature->save();

        return loggy(request(), 'Staff', auth()->user(), "Toggled beta feature flag | Feature ID: {$this->feature->id}");
    }

    public function publicToggle()
    {
        $this->feature->public = $this->publicStatus;
        if ($this->publicStatus) {
            $this->feature->staff = true;
            $this->feature->contributor = true;
            $this->feature->beta = true;
        }
        $this->feature->save();

        return loggy(request(), 'Staff', auth()->user(), "Toggled public feature flag | Feature ID: {$this->feature->id}");
    }

    public function confirmDelete()
    {
        $this->confirming = $this->feature->id;
    }

    public function deleteFeature()
    {
        if (! auth()->check()) {
            return toast($this, 'error', config('taskord.toast.deny'));
        }

        loggy(request(), 'Staff', auth()->user(), "Deleted a feature flag | Feature ID: {$this->feature->id}");
        $this->feature->delete();

        return redirect()->route('staff.features');
    }

    public function render()
    {
        return view('livewire.staff.features.single-feature');
    }
}
