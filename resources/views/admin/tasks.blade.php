@extends('layouts.app')

@section('pageTitle', 'Admin - Tasks ·')
@section('title', 'Admin - Tasks ·')
@section('description', 'Get things done socially with Taskord.')
@section('image', '')
@section('url', url()->current())

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="container-md">
            @include('admin.nav')
            <div class="card">
                <div class="card-header h6 pt-3 pb-3">
                    <div class="h5">Tasks</div>
                    <span class="font-weight-bold">{{ $count }}</span>
                    total tasks
                </div>
                <div class="table-responsive">
                    <table class="table text-dark">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Username</th>
                                <th scope="col">Status</th>
                                <th scope="col">Task</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($tasks as $task)
                            <tr>
                                <th>{{ $task->id }}</th>
                                <td>
                                    <a href="{{ route('user.done', ['username' => $task->user->username]) }}" target="_blank">
                                        {{ '@'.$task->user->username }}
                                    </a>
                                </td>
                                <td>
                                    @if ($task->done)
                                    ✅
                                    @else
                                    ⌛
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('task', ['id' => $task->id]) }}">
                                        {{ Str::limit($task->task, '100') }}
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                {{ $tasks->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
