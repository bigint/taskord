<div>
    @auth
    @if (Auth::user()->hasSubscribed($question))
    <button wire:click="subscribeQuestion" wire:loading.attr="disabled" class="btn btn-sm btn-danger">
        <x-heroicon-o-status-offline class="heroicon" />
        Unsubscribe
    </button>
    @else
    <button wire:click="subscribeQuestion" wire:loading.attr="disabled" class="btn btn-sm btn-primary">
        <x-heroicon-o-status-online class="heroicon" />
        Subscribe
    </button>
    @endif
    @endauth
    <span class="small ms-2">
        <span class="fw-bold">{{ number_format($question->subscribersCount()) }}</span>
        {{ str_plural('Subscriber', $question->subscribersCount()) }}
    </span>
</div>
