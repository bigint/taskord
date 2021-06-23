@foreach ($tasks as $task)
    {{ 'https://taskord.com/task/' . $task->id }}
@endforeach
