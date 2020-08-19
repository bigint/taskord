<div>
    @if ($comments->count('id') === 0)
    @include('components.empty', [
        'icon' => 'comments',
        'text' => 'No comments found!',
    ])
    @endif
    <ul class="list-group mt-4">
    @foreach ($comments as $comment)
        @livewire('task.single-comment', [
            'comment' => $comment,
        ], key($comment->id))
    @endforeach
    </ul>
    <div class="mt-4">
        @if ($comments->hasMorePages())
            @livewire('task.load-more', [
                'task' => $task,
                'page' => $page,
                'perPage' => $perPage
            ])
        @endif
    </div>
</div>
