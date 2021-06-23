<span>
    @php
        $liked = auth()
            ->user()
            ->hasLiked($entity);
    @endphp
    <button type="button" class="btn btn-action {{ $liked ? 'btn-like' : 'btn-outline-like' }} me-1"
        wire:click="toggleLike" wire:loading.attr="disabled" wire:key="{{ $entity->id }}" aria-label="Likes">
        <span wire:loading wire:target="toggleLike" class="spinner-border spinner-border-action" role="status"></span>
        @if ($liked)
            <x-heroicon-s-heart wire:loading.remove wire:target="toggleLike" class="heroicon heroicon-15px me-0" />
        @else
            <x-heroicon-o-heart wire:loading.remove wire:target="toggleLike" class="heroicon heroicon-15px me-0" />
        @endif
        @if ($entity->likerscount() !== 0)
            <span class="small fw-bold">
                {{ number_format($entity->likerscount()) }}
            </span>
        @endif
    </button>
</span>
