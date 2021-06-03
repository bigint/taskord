<div class="card mb-4">
    <div class="card-header d-flex align-items-center h6 py-3">
        <x:shared.user-label-big :user="$update->user" />
    </div>
    <div class="card-body">
        <div>{!! markdown($update->body) !!}</div>
        <div class="mt-2">
            @auth
                @if (!$update->user->is_private)
                    @if (auth()->user()->hasLiked($update))
                        <span>
                            <button type="button" class="btn btn-action btn-praise me-1" wire:click="togglePraise" wire:loading.attr="disabled" wire:offline.attr="disabled" wire:key="{{ $update->id }}" aria-label="Praise">
                                <span wire:loading wire:target="togglePraise" class="spinner-border spinner-border-task" role="status"></span>
                                <x-heroicon-s-heart wire:loading.remove wire:target="togglePraise" class="heroicon heroicon-15px me-0" />
                                <span class="small fw-bold">
                                    {{ number_format($update->likerscount()) }}
                                </span>
                            </button>
                        </span>
                    @else
                        <span>
                            <button type="button" class="btn btn-action btn-outline-praise me-1" wire:click="togglePraise" wire:loading.attr="disabled" wire:offline.attr="disabled" wire:key="{{ $update->id }}" aria-label="Praises">
                                <span wire:loading wire:target="togglePraise" class="spinner-border spinner-border-task" role="status"></span>
                                <x-heroicon-o-heart wire:loading.remove wire:target="togglePraise" class="heroicon heroicon-15px me-0" />
                                @if ($update->likerscount() !== 0)
                                    <span class="small fw-bold">
                                        {{ number_format($update->likerscount()) }}
                                    </span>
                                @endif
                            </button>
                        </span>
                    @endif
                @endif
            @endauth
            @guest
                <a href="/login" class="btn btn-action btn-outline-praise me-1" aria-label="Praises">
                    <x-heroicon-o-heart class="heroicon heroicon-15px me-0" />
                    @if ($update->likerscount() !== 0)
                        <span class="small fw-bold">
                            {{ number_format($update->likerscount()) }}
                        </span>
                    @endif
                </a>
            @endguest
            @auth
                @can('edit/delete', $update)
                    <button
                        type="button"
                        class="btn btn-action btn-outline-danger"
                        onclick="confirm('Are you sure?') || event.stopImmediatePropagation()"
                        wire:click="deleteUpdate"
                        wire:loading.attr="disabled"
                        wire:offline.attr="disabled"
                        aria-label="Delete"
                    >
                        <x-heroicon-o-trash class="heroicon heroicon-15px me-0" />
                    </button>
                @endcan
            @endauth
        </div>
    </div>
</div>
