<?php

namespace App\Http\Livewire\Staff\Features;

use App\Models\Feature;
use Livewire\Component;

class CreateFeature extends Component
{
    public $name;
    public $description;
    public $slug;

    public function submit()
    {
        if (! auth()->check()) {
            return toast($this, 'error', 'Forbidden!');
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
