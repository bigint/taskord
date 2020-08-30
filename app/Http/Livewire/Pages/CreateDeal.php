<?php

namespace App\Http\Livewire\Pages;

use Livewire\Component;
use App\Models\Deal;
use Illuminate\Support\Facades\Auth;

class CreateDeal extends Component
{
    public $name;
    public $description;
    public $offer;
    public $coupon;
    public $website;
    public $logo;
    
    public function submit()
    {
        if (Auth::check()) {
            $validatedData = $this->validate([
                'name' => 'required|min:2',
                'description' => 'required|min:5',
                'offer' => 'required|integer',
                'coupon' => 'required',
                'website' => 'required|active_url',
                'logo' => 'required|active_url',
            ]);
            if (Auth::user()->isStaff) {
                Deal::create([
                    'name' =>  $this->name,
                    'description' => $this->description,
                    'offer' => $this->offer,
                    'coupon' => $this->coupon,
                    'website' => $this->website,
                    'logo' => $this->logo,
                ]);
                session()->flash('success', 'Deal has been created!');

                return redirect()->route('deals');
            } else {
                session()->flash('error', 'Forbidden!');
            }
        } else {
            session()->flash('error', 'Forbidden!');
        }
    }
    
    public function render()
    {
        return view('livewire.pages.create-deal');
    }
}
