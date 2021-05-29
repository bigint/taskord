<?php

namespace App\Http\Livewire\Staff\Features;

use App\Models\Feature;
use Illuminate\Support\Facades\Gate;
use Livewire\Component;

class CreateFeature extends Component
{
    public $name;
    public $description;
    public $slug;

    public function submit()
    {
        if (Gate::denies('create')) {
            return toast($this, 'error', config('taskord.error.deny'));
        }

        $this->validate([
            'name' => ['required', 'min:5', 'max:100'],
            'description' => ['required', 'min:3', 'max:10000'],
            'slug' => ['required', 'unique:features', 'min:5', 'max:100'],
        ]);

        $feature = Feature::create([
            'name' => $this->name,
            'description' => $this->description,
            'slug' => $this->slug,
        ]);

        loggy(request(), 'Staff', auth()->user(), 'Created a new feature flag | Feature ID: '.$feature->id);

        return redirect()->route('staff.features');
    }
}
