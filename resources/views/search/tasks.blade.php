@extends('layouts.app')

@section('pageTitle', 'Search ·')
@section('title', 'Search ·')
@section('description', 'Browse questions and discuss, answer, give feedbacks, etc.')
@section('image', '')
@section('url', url()->current())

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="container">
            <div class="row">
                <div class="col-sm">
                    Soon
                </div>
                <div class="col-md-8">
                    <form action="/search/tasks" method="GET" role="search">
                        @csrf
                        <div class="input-group mb-4">
                            <input type="text" class="form-control" name="q" placeholder="Search users">
                            </span>
                        </div>
                    </form>
                    @if (!$tasks)
                    @include('components.empty', [
                        'icon' => 'check-square',
                        'text' => 'No questions found',
                    ])
                    @else
                    @foreach ($tasks as $task)
                    <li class="list-group-item p-3">
                        @livewire('task.single-task', [
                            'task' => $task
                        ], key($task->id))
                    </li>
                    @endforeach
                    <div class="mt-3">
                        {{ $tasks->appends(request()->input())->links() }}
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
