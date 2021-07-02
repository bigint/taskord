<span wire:init="loadModerator">
    <div class="text-uppercase fw-bold text-secondary pb-2">
        <x-heroicon-o-shield-check class="heroicon text-danger" />
        <span class="text-danger">Moderator</span>
    </div>
    <div class="card border-danger mb-4">
        <div class="card-body">
            @if (!$readyToLoad)
                <div class="card-body text-center">
                    <div class="spinner-border spinner-border-sm taskord-spinner text-secondary" role="status"></div>
                </div>
            @else
                <div class="mb-1">
                    <x-heroicon-o-clock class="heroicon text-secondary" />
                    <span class="h6">Created:</span>
                    <span class="fw-bold">
                        @if ($product->created_at)
                            @if (strtotime(carbon()) - strtotime($product->created_at) <= 5)
                                <span class="fw-bold text-success">active</span>
                            @else
                                {{ carbon($product->created_at)->diffForHumans() }}
                            @endif
                        @else
                            <span class="small fw-bold text-secondary">Not Set</span>
                        @endif
                    </span>
                </div>
                <div class="mb-3">
                    <x-heroicon-o-cube class="heroicon text-secondary" />
                    <span class="h6">Launched:</span>
                    <span class="fw-bold">
                        @if ($product->launched_at)
                            @if (strtotime(carbon()) - strtotime($product->launched_at) <= 5)
                                <span class="fw-bold text-success">active</span>
                            @else
                                {{ carbon($product->launched_at)->diffForHumans() }}
                            @endif
                        @else
                            <span class="small fw-bold text-secondary">Not Set</span>
                        @endif
                    </span>
                </div>
                <div class="text-info h5 mb-3">
                    <x-heroicon-o-flag class="heroicon heroicon-20px" />
                    Flags
                </div>
                <div class="mb-2 mt-3">
                    <input wire:click="markDeprecated" id="markDeprecated" class="form-check-input" type="checkbox"
                        wire:model="deprecated">
                    <label for="markDeprecated" class="ms-1">Mark as deprecated</label>
                </div>
                <div>
                    <input wire:click="verifyProduct" id="verifyProduct" class="form-check-input" type="checkbox"
                        wire:model="isVerified">
                    <label for="verifyProduct" class="ms-1 text-success fw-bold">Verify this product</label>
                </div>
                <hr>
                <div class="text-danger h5 mb-3">
                    <x-heroicon-o-user class="heroicon heroicon-20px" />
                    Danger Zone
                </div>
                <div class="mt-2">
                    <button wire:loading.attr="disabled" wire:click="resetLogo"
                        class="btn btn-sm btn-outline-danger rounded-pill fw-bold">
                        <x-heroicon-o-refresh class="heroicon heroicon-15px" />
                        Reset logo
                    </button>
                </div>
                <div class="mt-2">
                    <button wire:loading.attr="disabled" wire:click="releaseSlug"
                        class="btn btn-sm btn-outline-danger rounded-pill fw-bold">
                        <x-heroicon-o-switch-horizontal class="heroicon heroicon-15px" />
                        Release slug
                    </button>
                </div>
            @endif
        </div>
    </div>
</span>
