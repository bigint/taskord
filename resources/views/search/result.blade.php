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
                        <input type="text" class="form-control" name="q" value="{{ $searchTerm }}" placeholder="Search products">
                        <button type="submit" class="btn btn-secondary">Search</button>
                    </div>
                </form>
                @if (!$products)
                @include('components.empty', [
                    'icon' => 'search',
                    'text' => 'We couldn’t find any products matching "'.$searchTerm.'"',
                ])
                @else
                @foreach ($products as $product)
                    <li class="list-group-item pt-3 pb-3">
                        <div class="d-flex align-items-center">
                            <a href="{{ route('product.done', ['slug' => $product->slug]) }}">
                                <img class="rounded avatar-50 mt-1 ml-2" src="{{ $product->avatar }}" height="50" width="50" />
                            </a>
                            <span class="ml-3">
                                <a href="{{ route('product.done', ['slug' => $product->slug]) }}" class="mr-2 h5 align-text-top font-weight-bold text-dark">
                                    {{ $product->name }}
                                    @if ($product->launched)
                                        <a href="{{ route('products.launched') }}" class="small" data-toggle="tooltip" data-placement="right" title="Launched">
                                            {{ Emoji::rocket() }}
                                        </a>
                                    @endif
                                </a>
                                <div>{{ $product->description }}</div>
                            </span>
                            <a class="ml-auto" href="{{ route('user.done', ['username' => $product->user->username]) }}">
                                <img class="rounded-circle float-right avatar-30 mt-1 ml-2" src="{{ $product->user->avatar }}" height="50" width="50" />
                            </a>
                        </div>
                    </li>
                @endforeach
                <div class="mt-3">
                    {{ $products->appends(request()->input())->links() }}
                </div>
                @endif
            @endif
            
            @if ($type === 'users')
                <form action="/search/users" method="GET" role="search">
                    @csrf
                    <div class="input-group mb-4">
                        <input type="text" class="form-control" name="q" value="{{ $searchTerm }}" placeholder="Search users">
                        <button type="submit" class="btn btn-secondary">Search</button>
                    </div>
                </form>
                @if (!$users)
                @include('components.empty', [
                    'icon' => 'search',
                    'text' => 'We couldn’t find any users matching "'.$searchTerm.'"',
                ])
                @else
                @foreach ($users as $user)
                    <li class="list-group-item pt-3 pb-3">
                        <div class="d-flex align-items-center">
                            <a href="{{ route('user.done', ['username' => $user->username]) }}">
                                <img class="rounded-circle avatar-50 mt-1 ml-2" src="{{ $user->avatar }}" height="50" width="50" />
                            </a>
                            <span class="ml-3">
                                <a href="{{ route('user.done', ['username' => $user->username]) }}" class="mr-2 h5 align-text-top font-weight-bold text-dark">
                                    @if ($user->firstname or $user->lastname)
                                        {{ $user->firstname }}{{ ' '.$user->lastname }}
                                    @else
                                        {{ $user->username }}
                                    @endif
                                    @auth
                                    @if (Auth::user()->staffShip)
                                        <span class="ml-2 text-secondary small">#{{ $user->id }}</span>
                                    @endif
                                    @endauth
                                    @if ($user->isPatron)
                                        <a class="ml-2 small" href="{{ route('patron.home') }}" title="Patron">
                                            {{ Emoji::handshake() }}
                                        </a>
                                    @endif
                                    @auth
                                    @if ($user->isFollowing(Auth::user()))
                                        <span class="ml-2 badge bg-light text-black-50">Follows you</span>
                                    @endif
                                    @endauth
                                </a>
                                <div>{{ $user->bio }}</div>
                                <div class="small mt-2">
                                    <span>
                                        <i class="fa fa-calendar-alt mr-1 text-black-50"></i>
                                        Joined {{ Carbon::parse($user->created_at)->format("F Y") }}
                                    </span>
                                    @if ($user->location)
                                    <span class="ml-3">
                                        <a class="text-dark" target="_blank" rel="noreferrer" href="https://www.google.com/maps/search/{{ urlencode($user->location) }}">
                                            <i class="fa fa-compass mr-1 text-black-50"></i>
                                            {{ $user->location }}
                                        </a>
                                    </span>
                                    @endif
                                    @if ($user->company)
                                    <span class="ml-3">
                                        <i class="fa fa-briefcase mr-1 text-black-50"></i>
                                        {{ $user->company }}
                                    </span>
                                    @if ($user->isStaff)
                                    <span class="badge rounded-pill bg-primary ml-1">Staff</span>
                                    @endif
                                    @endif
                                </div>
                                <div class="mt-3">
                                    @livewire('user.follow', [
                                        'user' => $user
                                    ], key($user->id))
                                </div>
                            </span>
                        </div>
                    </li>
                @endforeach
                <div class="mt-3">
                    {{ $users->appends(request()->input())->links() }}
                </div>
                @endif
            @endif
        </div>
    </div>
</div>
@endsection
