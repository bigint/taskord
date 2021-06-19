<?php

namespace App\Http\Livewire\Pages;

use App\Models\Deal;
use Illuminate\Support\Facades\Gate;
use Livewire\Component;

class CreateDeal extends Component
{
    public $name;
    public $description;
    public $offer;
    public $coupon;
    public $website;
    public $logo;
    public $referral;

    public function submit()
    {
        if (Gate::denies('create')) {
            return toast($this, 'error', config('taskord.toast.deny'));
        }

        $this->validate([
            'name' => ['required', 'min:2'],
            'description' => ['required', 'min:5'],
            'offer' => ['required', 'integer', 'max:100'],
            'coupon' => ['nullable'],
            'referral' => ['nullable', 'active_url'],
            'website' => ['required', 'active_url'],
            'logo' => ['required', 'active_url'],
        ]);

        $deal = Deal::create([
            'name' => $this->name,
            'description' => $this->description,
            'offer' => $this->offer,
            'coupon' => $this->coupon,
            'referral' => $this->referral,
            'website' => $this->website,
            'logo' => $this->logo,
        ]);
        loggy(request(), 'Staff', auth()->user(), "Created a new deal | Deal ID: {$deal->id}");

        return redirect()->route('deals');
    }
}
