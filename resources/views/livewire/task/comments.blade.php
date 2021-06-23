<div wire:init="loadComments" class="pt-3">
    <div class="card">
        <div class="card-body">
            @if (!$readyToLoad)
                <div class="text-center">
                    <div class="spinner-border spinner-border-sm taskord-spinner text-secondary" role="status"></div>
                </div>
            @else
                @foreach ($comments as $comment)
                    <x:shared.user-label-small :user="$comment->user" />
                    <div class="mt-2 card d-inline-block bg-light {{ $loop->last ? '' : 'mb-3' }}">
                        <div class="card-body px-2 py-1 body-font">
                            {!! markdown($comment->comment) !!}
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
    </div>
</div>
