<div class="{{ $comment->replies->count('id') > 0 ? 'mt-3' : '' }}">
    @foreach ($comment->replies as $reply)
        <livewire:comment.reply.single-reply :reply="$reply" :wire:key="$reply->id" />
    @endforeach
</div>
