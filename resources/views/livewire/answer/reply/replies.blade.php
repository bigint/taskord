<div class="{{ $replies->count('id') > 0 ? 'mt-3' : '' }}">
    @if ($replies->count('id') > 0)
        @foreach ($replies as $reply)
            <livewire:answer.reply.single-reply :reply="$reply" :wire:key="$reply->id" />
        @endforeach
    @endif
</div>
