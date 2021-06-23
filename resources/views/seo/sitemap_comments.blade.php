@foreach ($comments as $comment)
    {{ 'https://taskord.com/task/' . $comment->task->id . '/' . $comment->id }}
@endforeach
