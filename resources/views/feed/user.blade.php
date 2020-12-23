<?xml version="1.0" encoding="UTF-8"?>
<feed xmlns="http://www.w3.org/2005/Atom">
    <id>https://taskord.com/feed/{{ $user->username }}</id>
    <link href="https://taskord.com/feed/{{ $user->username }}"></link>
    <title><![CDATA[{{ config('app.name') }}]]></title>
    <description></description>
    <language></language>
    <updated>{{ $user->updated_at->format('D, d M Y H:i:s +0000') }}</updated>
    @foreach ($user->tasks as $task)
    <entry>
        <title><![CDATA[{{ $task->task }}]]></title>
        <link rel="alternate" href="https://taskord.com/task/{{ $task->id }}" />
        <id>https://taskord.com/task/{{ $task->id }}</id>
        <author>
            <name> <![CDATA[{{ $user->username }}]]></name>
        </author>
        <summary type="html">
            <![CDATA[{!! parsedown($task->task) !!}]]>
        </summary>
        <category type="html">
            <![CDATA[]]>
        </category>
        <updated>{{ $task->updated_at->format('D, d M Y H:i:s +0000') }}</updated>
    </entry>
    @endforeach
</feed>
