<?php

namespace App\Http\Livewire\Product\Update;

use Livewire\Component;

class SingleUpdate extends Component
{
    public $update;
    
    public function mount($update)
    {
        $this->update = $update;
    }
    
    public function render()
    {
        return view('livewire.product.update.single-update');
    }
}
