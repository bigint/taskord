<div>
    @auth
    @if (Auth::user()->hasSubscribed($question))
    <button wire:click="subscribeQuestion" wire:loading.attr="disabled" class="btn btn-sm btn-danger">
        <x-heroicon-o-status-offline class="heroicon" />
        Unsubscribe
        <span wire:target="subscribeQuestion" wire:loading class="spinner-border spinner-border-sm ms-2" role="status"></span>
    </button>
    @else
    <button wire:click="subscribeQuestion" wire:loading.attr="disabled" class="btn btn-sm btn-primary">
        <x-heroicon-o-status-online class="heroicon" />
        Subscribe
        <span wire:target="subscribeQuestion" wire:loading class="spinner-border spinner-border-sm ms-2" role="status"></span>
    </button>
    @endif
    @endauth
    <span class="small ms-2">
        <span class="fw-bold">{{ number_format($question->subscribersCount()) }}</span>
        {{ $question->subscribersCount() <= 1 ? 'Subscriber' : 'Subscribers' }}
    </span>
</div>
