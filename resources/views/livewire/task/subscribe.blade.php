<div>
    @auth
    @if (Auth::user()->hasSubscribed($task))
    <button wire:click="subscribeTask" wire:loading.attr="disabled" class="btn btn-sm btn-danger">
        <x-heroicon-o-status-offline class="heroicon" />
        Unsubscribe
        <span wire:target="subscribeTask" wire:loading class="spinner-border spinner-border-sm ms-2" role="status"></span>
    </button>
    @else
    <button wire:click="subscribeTask" wire:loading.attr="disabled" class="btn btn-sm btn-primary">
        <x-heroicon-o-status-online class="heroicon" />
        Subscribe
        <span wire:target="subscribeTask" wire:loading class="spinner-border spinner-border-sm ms-2" role="status"></span>
    </button>
    @endif
    @if (session()->has('error'))
        <span class="ms-2 text-danger fw-bold">{{ session('error') }}</span>
    @endif
    @endauth
    <span class="small ms-2">
        <span class="fw-bold">{{ number_format($task->subscribersCount()) }}</span>
        {{ $task->subscribersCount() <= 1 ? 'Subscriber' : 'Subscribers' }}
    </span>
</div>
