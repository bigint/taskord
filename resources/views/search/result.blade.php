@extends('layouts.app')

@section('pageTitle', 'Search ·')
@section('title', 'Search ·')
@section('description', 'Browse questions and discuss, answer, give feedbacks, etc.')
@section('image', '')
@section('url', url()->current())

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-sm">
            @include('search.sidebar')
        </div>
        <div class="col-md-8">
            @if ($type === 'tasks')
                <form action="/search/tasks" method="GET" role="search">
                    @csrf
                    <div class="input-group mb-4">
                        <input type="text" class="form-control" name="q" value="{{ $searchTerm }}" placeholder="Search tasks">
                        <button type="submit" class="btn btn-secondary">Search</button>
                    </div>
                </form>
                @if (!$tasks)
                @include('components.empty', [
                    'icon' => 'search',
                    'text' => 'We couldn’t find any tasks matching "'.$searchTerm.'"',
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
            @endif
            
            @if ($type === 'comments')
                <form action="/search/comments" method="GET" role="search">
                    @csrf
                    <div class="input-group mb-4">
                        <input type="text" class="form-control" name="q" value="{{ $searchTerm }}" placeholder="Search comments">
                        <button type="submit" class="btn btn-secondary">Search</button>
                    </div>
                </form>
                @if (!$comments)
                @include('components.empty', [
                    'icon' => 'search',
                    'text' => 'We couldn’t find any comments matching "'.$searchTerm.'"',
                ])
                @else
                @foreach ($comments as $comment)
                @livewire('task.single-comment', [
                    'comment' => $comment,
                ], key($comment->id))
                @endforeach
                <div class="mt-3">
                    {{ $comments->appends(request()->input())->links() }}
                </div>
                @endif
            @endif
            
            @if ($type === 'questions')
                <form action="/search/questions" method="GET" role="search">
                    @csrf
                    <div class="input-group mb-4">
                        <input type="text" class="form-control" name="q" value="{{ $searchTerm }}" placeholder="Search questions">
                        <button type="submit" class="btn btn-secondary">Search</button>
                    </div>
                </form>
                @if (!$questions)
                @include('components.empty', [
                    'icon' => 'search',
                    'text' => 'We couldn’t find any questions matching "'.$searchTerm.'"',
                ])
                @else
                @foreach ($questions as $question)
                @livewire('questions.single-question', [
                    'type' => 'questions.newest',
                    'question' => $question,
                ], key($question->id))
                @endforeach
                <div class="mt-3">
                    {{ $questions->appends(request()->input())->links() }}
                </div>
                @endif
            @endif
            
            @if ($type === 'answers')
                <form action="/search/answers" method="GET" role="search">
                    @csrf
                    <div class="input-group mb-4">
                        <input type="text" class="form-control" name="q" value="{{ $searchTerm }}" placeholder="Search answers">
                        <button type="submit" class="btn btn-secondary">Search</button>
                    </div>
                </form>
                @if (!$answers)
                @include('components.empty', [
                    'icon' => 'search',
                    'text' => 'We couldn’t find any answers matching "'.$searchTerm.'"',
                ])
                @else
                @foreach ($answers as $answer)
                    <div class="card mb-2">
                        <div class="card-header h6 pt-3 pb-3">
                            <a href="{{ route('user.done', ['username' => $answer->question->user->username]) }}">
                                <img class="rounded-circle avatar-30" src="{{ $answer->question->user->avatar }}" />
                            </a>
                            <a class="align-middle text-dark ml-2" href="{{ route('question.question', ['id' => $answer->question->id]) }}">
                                {{ $answer->question->title }}
                            </a>
                        </div>
                        @livewire('answer.single-answer', [
                            'answer' => $answer
                        ], key($answer->id))
                    </div>
                @endforeach
                <div class="mt-3">
                    {{ $answers->appends(request()->input())->links() }}
                </div>
                @endif
            @endif
            
            @if ($type === 'products')
                <form action="/search/products" method="GET" role="search">
                    @csrf
                    <div class="input-group mb-4">
                        <input type="text" class="form-control" name="q" value="{{ $searchTerm }}" placeholder="Search answers">
                        <button type="submit" class="btn btn-secondary">Search</button>
                    </div>
                </form>
                @if (!$products)
                @include('components.empty', [
                    'icon' => 'search',
                    'text' => 'We couldn’t find any products matching "'.$searchTerm.'"',
                ])
                @else
                @foreach ($products as $products)
                    <div class="card mb-2">
                        {{ $products }}
                    </div>
                @endforeach
                <div class="mt-3">
                </div>
                @endif
            @endif
        </div>
    </div>
</div>
@endsection
