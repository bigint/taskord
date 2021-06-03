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
                            <button type="button" class="btn btn-action btn-like me-1" wire:click="toggleLike" wire:loading.attr="disabled" wire:offline.attr="disabled" wire:key="{{ $update->id }}" aria-label="Like">
                                <span wire:loading wire:target="toggleLike" class="spinner-border spinner-border-task" role="status"></span>
                                <x-heroicon-s-heart wire:loading.remove wire:target="toggleLike" class="heroicon heroicon-15px me-0" />
                                <span class="small fw-bold">
                                    {{ number_format($update->likerscount()) }}
                                </span>
                            </button>
                        </span>
                    @else
                        <span>
                            <button type="button" class="btn btn-action btn-outline-like me-1" wire:click="toggleLike" wire:loading.attr="disabled" wire:offline.attr="disabled" wire:key="{{ $update->id }}" aria-label="Likes">
                                <span wire:loading wire:target="toggleLike" class="spinner-border spinner-border-task" role="status"></span>
                                <x-heroicon-o-heart wire:loading.remove wire:target="toggleLike" class="heroicon heroicon-15px me-0" />
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
                <a href="/login" class="btn btn-action btn-outline-like me-1" aria-label="Likes">
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
