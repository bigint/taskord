<?php

namespace App\Http\Livewire\Admin\Features;

use App\Models\Feature;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class CreateFeature extends Component
{
    public $name;
    public $description;
    public $slug;

    public function submit()
    {
        if (Auth::check()) {
            $this->validate([
                'name' => 'required|min:5|max:100',
                'description' => 'required|min:3|max:10000',
                'slug' => 'required|unique:features|min:5|max:100',
            ]);

            $feature = Feature::create([
                'name' => $this->name,
                'description' => $this->description,
                'slug' => $this->slug,
            ]);

            loggy(request()->ip(), 'Admin', auth()->user(), 'Created a new feature flag | Feature ID: '.$feature->id);
            $this->flash('success', 'Feature flag has been created!');

            return redirect()->route('admin.features');
        } else {
            $this->alert('error', 'Forbidden!');
        }
    }
}
