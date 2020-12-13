<div>
    @auth
    @if (Auth::user()->hasSubscribed($question))
    <button wire:click="subscribeQuestion" wire:loading.attr="disabled" class="btn btn-sm btn-danger">
        <i class="fa fa-bell-slash mr-1"></i>
        Unsubscribe
        <span wire:target="subscribeQuestion" wire:loading class="spinner-border spinner-border-sm ms-2" role="status"></span>
    </button>
    @else
    <button wire:click="subscribeQuestion" wire:loading.attr="disabled" class="btn btn-sm btn-primary">
        <i class="fa fa-bell mr-1"></i>
        Subscribe
        <span wire:target="subscribeQuestion" wire:loading class="spinner-border spinner-border-sm ms-2" role="status"></span>
    </button>
    @endif
    @if (session()->has('error'))
        <span class="ms-2 text-danger fw-bold">{{ session('error') }}</span>
    @endif
    @endauth
    <span class="small ms-2">
        <span class="fw-bold">{{ number_format($question->subscribersCount()) }}</span>
        {{ $question->subscribersCount() <= 1 ? 'Subscriber' : 'Subscribers' }}
    </span>
</div>
