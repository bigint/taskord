<?xml version="1.0" encoding="UTF-8"?>
<feed xmlns="http://www.w3.org/2005/Atom">
    <id>https://taskord.com/feed/{{ $user->username }}</id>
    <link href="https://taskord.com/feed/{{ $user->username }}"></link>
    <title>{{ '@'.$user->username }}'s Feed - {{ config('app.name') }}</title>
    <updated>{{ $user->updated_at->format('D, d M Y H:i:s') }}</updated>
    @foreach ($tasks as $task)
    <entry>
        <title>{{ $task->task }}</title>
        <link rel="alternate" href="https://taskord.com/task/{{ $task->id }}" />
        <id>https://taskord.com/task/{{ $task->id }}</id>
        <author>
            <username>{{ $user->username }}</username>
            <name>{{ $user->firstname .' '. $user->lastname }}</name>
            <email>{{ $user->email }}</email>
        </author>
        <created>{{ $task->created_at->format('D, d M Y H:i:s') }}</created>
        <updated>{{ $task->updated_at->format('D, d M Y H:i:s') }}</updated>
    </entry>
    @endforeach
</feed>
