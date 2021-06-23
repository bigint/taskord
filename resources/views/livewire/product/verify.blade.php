<div>
    <div class="h5 mb-3 text-secondary d-flex align-content-center">
        <x-heroicon-o-cube class="heroicon heroicon-20px" />
        <span class="ms-1">Verify domain</span>
    </div>
    <div class="card">
        <div class="card-body">
            @if ($product->website)
                <div>
                    <h5>Add a DNS TXT record</h5>
                    <p>
                        1. Create a TXT record in your DNS configuration for the following hostname:
                    </p>
                    <div class="input-group mb-3">
                        <input type="text" id="txt-record" class="form-control @error('token') is-invalid @enderror"
                            value="{{ $txt_record }}" readonly>
                        <div class="input-group-append">
                            <button class="btn btn-outline-secondary js-clipboard" type="button" title="Copy"
                                data-bs-toggle="tooltip" data-for="#txt-record">
                                <x-heroicon-o-clipboard-copy class="heroicon heroicon-18px">
                                </x-heroicon-o-clipboard-copy>
                            </button>
                        </div>
                    </div>
                    <p>
                        2. Use this code as the value for the TXT record:
                    </p>
                    <div class="input-group mb-3">
                        <input type="text" id="txt-code" class="form-control @error('token') is-invalid @enderror"
                            value="{{ $txt_code }}" readonly>
                        <div class="input-group-append">
                            <button class="btn btn-outline-secondary js-clipboard" type="button" title="Copy"
                                data-bs-toggle="tooltip" data-for="#txt-code">
                                <x-heroicon-o-clipboard-copy class="heroicon heroicon-18px">
                                </x-heroicon-o-clipboard-copy>
                            </button>
                        </div>
                    </div>
                    <p>
                        3. Wait until your DNS configuration changes. This could take up to 72 hours.
                    </p>
                </div>
                @if ($product->verified_at)
                    <div class="fw-bold text-success mb-3">
                        Your domain has been verified at {{ carbon($product->verified_at)->format('d M Y g:i A') }}
                    </div>
                    <button class="btn btn-outline-success rounded-pill" wire:click="verifyDomain"
                        wire:loading.attr="disabled">
                        Reverify domain
                    </button>
                @else
                    <button class="btn btn-outline-success rounded-pill" wire:click="verifyDomain"
                        wire:loading.attr="disabled">
                        Verify domain
                    </button>
                @endif
            @else
                <div>
                    <h5 class="mb-3">Add domain name in edit page</h5>
                    <a class="btn btn-outline-success rounded-pill"
                        href="{{ route('product.edit', ['slug' => $product->slug]) }}">
                        Go to edit page
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>
