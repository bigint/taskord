@extends('layouts.app')

@section('pageTitle', 'Search · '.$searchTerm.' ·')
@section('title', 'Search · '.$searchTerm.' ·')
@section('description', 'Browse questions and discuss, answer, give feedbacks, etc.')
@section('image', '')
@section('url', url()->current())

@section('content')
<div class="container-md">
    <div class="row justify-content-center">
        <div class="col-sm">
            @include('search.sidebar')
        </div>
        <div class="col-lg-8">
            @if ($type === 'tasks')
                <form action="/search/tasks" method="GET" role="search">
                    @csrf
                    <div class="input-group mb-4">
                        <input type="text" class="form-control" name="q" value="{{ $searchTerm }}" placeholder="Search tasks">
                        <button type="submit" class="btn btn-secondary">Search</button>
                    </div>
                </form>
                @if (!$tasks)
                <x-empty icon="search" text="We couldn’t find any tasks matching '{{ $searchTerm }}'" />
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
                <x-empty icon="search" text="We couldn’t find any comments matching '{{ $searchTerm }}'" />
                @else
                @foreach ($comments as $comment)
                @livewire('comment.single-comment', [
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
                <x-empty icon="search" text="We couldn’t find any questions matching '{{ $searchTerm }}'" />
                @else
                @foreach ($questions as $question)
                @livewire('question.single-question', [
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
                <x-empty icon="search" text="We couldn’t find any answers matching '{{ $searchTerm }}'" />
                @else
                @foreach ($answers as $answer)
                    <div class="card mb-2">
                        <div class="card-header h6 pt-3 pb-3">
                            <a href="{{ route('user.done', ['username' => $answer->question->user->username]) }}">
                                <img class="rounded-circle avatar-30" src="{{ Helper::getCDNImage($answer->question->user->avatar) }}" alt="{{ $answer->question->user->username }}'s avatar" />
                            </a>
                            <a class="align-middle text-dark ms-2" href="{{ route('question.question', ['id' => $answer->question->id]) }}">
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
                <x-empty icon="search" text="We couldn’t find any products matching '{{ $searchTerm }}'" />
                @else
                @foreach ($products as $product)
                    <li class="list-group-item pt-3 pb-3">
                        <div class="d-flex align-items-center">
                            <a href="{{ route('product.done', ['slug' => $product->slug]) }}">
                                <img class="rounded avatar-50 mt-1 ms-2" src="{{ Helper::getCDNImage($product->avatar) }}" height="50" width="50" alt="{{ $product->slug }}'s avatar" />
                            </a>
                            <span class="ms-3">
                                <a href="{{ route('product.done', ['slug' => $product->slug]) }}" class="me-2 h5 align-text-top fw-bold text-dark">
                                    {{ $product->name }}
                                    @if ($product->launched)
                                        <a href="{{ route('products.launched') }}" class="small" data-bs-toggle="tooltip" data-placement="right" title="Launched">
                                            🚀
                                        </a>
                                    @endif
                                    @if ($product->deprecated)
                                        <span class="ms-1 small" title="Deprecated">
                                            <i class="fa fa-ghost text-danger"></i>
                                        </span>
                                    @endif
                                </a>
                                <div class="text-black-50 mb-2">
                                    {{ "#" . $product->slug }}
                                </div>
                                <div>{{ $product->description }}</div>
                                <div class="small mt-2">
                                    <i class="fa fa-calendar-alt me-1 text-black-50"></i>
                                    @if ($product->launched)
                                    <span>Launched at {{ Carbon::parse($product->launched_at)->format("F Y") }}</span>
                                    @else
                                    <span>Created at {{ Carbon::parse($product->created_at)->format("F Y") }}</span>
                                    @endif
                                </div>
                                <div class="mt-3">
                                    @livewire('product.subscribe', [
                                        'product' => $product
                                    ], key($product->id))
                                </div>
                            </span>
                            <a class="ms-auto" href="{{ route('user.done', ['username' => $product->owner->username]) }}">
                                <img class="rounded-circle float-end avatar-30 mt-1 ms-2" src="{{ Helper::getCDNImage($product->owner->avatar) }}" height="50" width="50" alt="{{ $product->owner->username }}'s avatar" />
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
                <x-empty icon="search" text="We couldn’t find any users matching '{{ $searchTerm }}'" />
                @else
                @foreach ($users as $user)
                    <li class="list-group-item pt-3 pb-3">
                        <div class="d-flex align-items-center">
                            <a href="{{ route('user.done', ['username' => $user->username]) }}">
                                <img class="rounded-circle avatar-50 mt-1 ms-2" src="{{ Helper::getCDNImage($user->avatar) }}" height="50" width="50" alt="{{ $user->username }}'s avatar" />
                            </a>
                            <span class="ms-3">
                                <a href="{{ route('user.done', ['username' => $user->username]) }}" class="me-2 h5 align-text-top fw-bold text-dark">
                                    @if ($user->firstname or $user->lastname)
                                        {{ $user->firstname }}{{ ' '.$user->lastname }}
                                    @else
                                        {{ $user->username }}
                                    @endif
                                    @auth
                                    @if (Auth::user()->staffShip)
                                        <span class="ms-2 text-secondary small">#{{ $user->id }}</span>
                                    @endif
                                    @endauth
                                    @if ($user->isPatron)
                                        <a class="ms-2 small" href="{{ route('patron.home') }}" title="Patron">
                                            🤝
                                        </a>
                                    @endif
                                    @auth
                                    @if ($user->isFollowing(Auth::user()))
                                        <span class="ms-2 badge bg-light text-black-50">Follows you</span>
                                    @endif
                                    @endauth
                                </a>
                                <div class="text-black-50 mb-2">
                                    {{ "@" . $user->username }}
                                </div>
                                <div>{{ $user->bio }}</div>
                                <div class="small mt-2">
                                    <span>
                                        <i class="fa fa-calendar-alt me-1 text-black-50"></i>
                                        Joined {{ Carbon::parse($user->created_at)->format("F Y") }}
                                    </span>
                                    @if ($user->location)
                                    <span class="ms-3">
                                        <a class="text-dark" href="https://www.google.com/maps/search/{{ urlencode($user->location) }}" target="_blank" rel="noreferrer">
                                            <i class="fa fa-compass me-1 text-black-50"></i>
                                            {{ $user->location }}
                                        </a>
                                    </span>
                                    @endif
                                    @if ($user->company)
                                    <span class="ms-3">
                                        <i class="fa fa-briefcase me-1 text-black-50"></i>
                                        {{ $user->company }}
                                    </span>
                                    @if ($user->isStaff)
                                    <span class="badge rounded-pill bg-primary ms-1">Staff</span>
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
