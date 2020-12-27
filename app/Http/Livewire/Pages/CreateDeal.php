<?php

namespace App\Http\Livewire\Pages;

use App\Models\Deal;
use Illuminate\Support\Facades\Auth;
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
        if (Auth::check()) {
            $this->validate([
                'name' => 'required|min:2',
                'description' => 'required|min:5',
                'offer' => 'required|integer|max:100',
                'coupon' => 'nullable',
                'referral' => 'nullable|active_url',
                'website' => 'required|active_url',
                'logo' => 'required|active_url',
            ]);
            if (Auth::user()->isStaff) {
                $deal = Deal::create([
                    'name' =>  $this->name,
                    'description' => $this->description,
                    'offer' => $this->offer,
                    'coupon' => $this->coupon,
                    'referral' => $this->referral,
                    'website' => $this->website,
                    'logo' => $this->logo,
                ]);
                Auth::user()->touch();
                $this->flash('success', 'Deal has been created!', [
                    'showCancelButton' =>  false,
                ]);
                activity()
                    ->withProperties(['type' => 'Admin'])
                    ->log('New deal has been created D: '.$deal->id);

                return redirect()->route('deals');
            } else {
                $this->alert('error', 'Forbidden!', [
                    'showCancelButton' =>  false,
                ]);
            }
        } else {
            $this->alert('error', 'Forbidden!', [
                'showCancelButton' =>  false,
            ]);
        }
    }
}
