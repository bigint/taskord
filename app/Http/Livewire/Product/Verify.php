<?php

namespace App\Http\Livewire\Product;

use App\Models\Product;
use DanHarrin\LivewireRateLimiting\Exceptions\TooManyRequestsException;
use DanHarrin\LivewireRateLimiting\WithRateLimiting;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Str;
use Livewire\Component;
use Spatie\Dns\Dns;

class Verify extends Component
{
    use WithRateLimiting;

    public Product $product;

    public function mount($product)
    {
        $this->product = $product;
    }

    public function verifyDomain()
    {
        try {
            $this->rateLimit(10);
        } catch (TooManyRequestsException $exception) {
            return toast($this, 'error', config('taskord.error.rate-limit'));
        }

        if (Gate::denies('edit/delete', $this->product)) {
            return toast($this, 'error', config('taskord.toast.deny'));
        }

        $dns = new Dns();
        $records = $dns->getRecords($this->getDomain($this->product->website), 'TXT');
        $txtList = [];
        foreach ($records as $record) {
            array_push($txtList, $record->txt());
        }

        if (in_array($this->product->txt_code, $txtList)) {
            $this->product->verified_at = carbon();
            $this->product->save();
            loggy(request(), 'Product', auth()->user(), "Verified the product and domain | Product ID: {$this->product->id}");

            return toast($this, 'success', 'Domain and product has been successfully verified 🎉');
        }

        return toast($this, 'error', "We can't verify the domain at this time, please try again later!");
    }

    public function getDomain($url)
    {
        return parse_url($url)['host'];
    }

    public function render(): View
    {
        if (! $this->product->txt_code) {
            $this->product->txt_code = "_taskord-challenge-{$this->product->slug}-".Str::uuid();
            $this->product->save();
        }

        $txtRecord = $this->getDomain($this->product->website);

        return view('livewire.product.verify', [
            'txt_record' => $txtRecord,
            'txt_code' => $this->product->txt_code,
        ]);
    }
}
