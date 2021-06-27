@extends('layouts.app')

@section('pageTitle', 'Search · ' . $searchTerm . ' ·')
@section('title', 'Search · ' . $searchTerm . ' ·')
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
                            <input type="text" class="form-control" name="q" value="{{ $searchTerm }}"
                                placeholder="Search tasks">
                            <button type="submit" class="btn btn-secondary">Search</button>
                        </div>
                    </form>
                    @if (!$tasks)
                        <div class="card-body text-center mt-3 mb-3">
                            <x-heroicon-o-search class="heroicon heroicon-60px text-primary mb-2" />
                            <div class="h4">
                                We couldn’t find any tasks matching '{{ $searchTerm }}'
                            </div>
                        </div>
                    @else
                        @foreach ($tasks as $task)
                            <li class="list-group-item p-3">
                                <livewire:task.single-task :task="$task" :wire:key="$task->id" />
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
                            <input type="text" class="form-control" name="q" value="{{ $searchTerm }}"
                                placeholder="Search comments">
                            <button type="submit" class="btn btn-secondary">Search</button>
                        </div>
                    </form>
                    @if (!$comments)
                        <div class="card-body text-center mt-3 mb-3">
                            <x-heroicon-o-search class="heroicon heroicon-60px text-primary mb-2" />
                            <div class="h4">
                                We couldn’t find any comments matching '{{ $searchTerm }}'
                            </div>
                        </div>
                    @else
                        @foreach ($comments as $comment)
                            <div class="mb-3">
                                @livewire('comment.single-comment', [
                                'comment' => $comment,
                                ], key($comment->id))
                            </div>
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
                            <input type="text" class="form-control" name="q" value="{{ $searchTerm }}"
                                placeholder="Search questions">
                            <button type="submit" class="btn btn-secondary">Search</button>
                        </div>
                    </form>
                    @if (!$questions)
                        <div class="card-body text-center mt-3 mb-3">
                            <x-heroicon-o-search class="heroicon heroicon-60px text-primary mb-2" />
                            <div class="h4">
                                We couldn’t find any questions matching '{{ $searchTerm }}'
                            </div>
                        </div>
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
                            <input type="text" class="form-control" name="q" value="{{ $searchTerm }}"
                                placeholder="Search answers">
                            <button type="submit" class="btn btn-secondary">Search</button>
                        </div>
                    </form>
                    @if (!$answers)
                        <div class="card-body text-center mt-3 mb-3">
                            <x-heroicon-o-search class="heroicon heroicon-60px text-primary mb-2" />
                            <div class="h4">
                                We couldn’t find any answers matching '{{ $searchTerm }}'
                            </div>
                        </div>
                    @else
                        @foreach ($answers as $answer)
                            <div class="card mb-2">
                                <div class="card-header h6 py-3">
                                    <a
                                        href="{{ route('user.done', ['username' => $answer->question->user->username]) }}">
                                        <img loading=lazy class="rounded-circle avatar-30"
                                            src="{{ Helper::getCDNImage($answer->question->user->avatar, 80) }}"
                                            height="30" width="30"
                                            alt="{{ $answer->question->user->username }}'s avatar" />
                                    </a>
                                    <a class="align-middle text-dark ms-2"
                                        href="{{ route('question.question', ['slug' => $answer->question->slug]) }}">
                                        {{ $answer->question->title }}
                                    </a>
                                </div>
                                <livewire:answer.single-answer :answer="$answer" :wire:key="$answer->id" />
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
                            <input type="text" class="form-control" name="q" value="{{ $searchTerm }}"
                                placeholder="Search products">
                            <button type="submit" class="btn btn-secondary">Search</button>
                        </div>
                    </form>
                    @if (!$products)
                        <div class="card-body text-center mt-3 mb-3">
                            <x-heroicon-o-search class="heroicon heroicon-60px text-primary mb-2" />
                            <div class="h4">
                                We couldn’t find any products matching '{{ $searchTerm }}'
                            </div>
                        </div>
                    @else
                        @foreach ($products as $product)
                            <li class="list-group-item py-3">
                                <div class="d-flex align-items-center">
                                    <a href="{{ route('product.done', ['slug' => $product->slug]) }}">
                                        <img loading=lazy class="rounded avatar-50"
                                            src="{{ Helper::getCDNImage($product->avatar, 80) }}" height="50" width="50"
                                            alt="{{ $product->slug }}'s avatar" />
                                    </a>
                                    <span class="ms-3">
                                        <a href="{{ route('product.done', ['slug' => $product->slug]) }}"
                                            class="me-2 h5 align-text-top fw-bold text-dark">
                                            {{ $product->name }}
                                            @if ($product->launched)
                                                <a href="{{ route('products.launched') }}" class="small"
                                                    data-bs-toggle="tooltip" data-placement="right" title="Launched">
                                                    🚀
                                                </a>
                                            @endif
                                            @if ($product->deprecated)
                                                <span class="ms-1 small" title="Deprecated">
                                                    <x-heroicon-o-shield-exclamation class="heroicon text-danger" />
                                                </span>
                                            @endif
                                        </a>
                                        <div class="text-secondary mb-2">
                                            {{ '#' . $product->slug }}
                                        </div>
                                        <div class="pe-5 text-secondary">{{ $product->description }}</div>
                                        <div class="small mt-2 text-dark">
                                            <x-heroicon-o-calendar class="heroicon text-secondary" />
                                            @if ($product->launched)
                                                <span>Launched at
                                                    {{ carbon($product->launched_at)->format('F Y') }}</span>
                                            @else
                                                <span>Created at {{ $product->created_at->format('F Y') }}</span>
                                            @endif
                                        </div>
                                        <div class="mt-3">
                                            @livewire('product.subscribe', [
                                            'product' => $product
                                            ], key($product->id))
                                        </div>
                                    </span>
                                    <a class="d-flex ms-auto"
                                        href="{{ route('user.done', ['username' => $product->user->username]) }}">
                                        <img loading=lazy class="rounded-circle float-end avatar-30 mt-1 ms-2"
                                            src="{{ Helper::getCDNImage($product->user->avatar, 80) }}" height="30"
                                            width="30" alt="{{ $product->user->username }}'s avatar" />
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
                            <input type="text" class="form-control" name="q" value="{{ $searchTerm }}"
                                placeholder="Search users">
                            <button type="submit" class="btn btn-secondary">Search</button>
                        </div>
                    </form>
                    @if (!$users)
                        <div class="card-body text-center mt-3 mb-3">
                            <x-heroicon-o-search class="heroicon heroicon-60px text-primary mb-2" />
                            <div class="h4">
                                We couldn’t find any users matching '{{ $searchTerm }}'
                            </div>
                        </div>
                    @else
                        @foreach ($users as $user)
                            <li class="list-group-item py-3">
                                <div class="d-flex align-items-center">
                                    <a href="{{ route('user.done', ['username' => $user->username]) }}">
                                        <img loading=lazy class="rounded-circle avatar-50 mt-1 ms-2"
                                            src="{{ Helper::getCDNImage($user->avatar, 80) }}" height="50" width="50"
                                            alt="{{ $user->username }}'s avatar" />
                                    </a>
                                    <span class="ms-3">
                                        <a href="{{ route('user.done', ['username' => $user->username]) }}"
                                            class="h5 align-text-top fw-bold text-dark">
                                            @if ($user->firstname or $user->lastname)
                                                {{ $user->firstname }}{{ ' ' . $user->lastname }}
                                            @else
                                                {{ $user->username }}
                                            @endif
                                            @can('staff.ops')
                                                <span class="ms-2 text-secondary small">#{{ $user->id }}</span>
                                            @endcan
                                            @if ($user->is_private)
                                                <x-heroicon-o-lock-closed
                                                    class="heroicon heroicon-20px text-primary ms-2 me-0 private" />
                                            @endif
                                            @if ($user->is_verified)
                                                <x-heroicon-s-badge-check
                                                    class="heroicon heroicon-20px text-primary ms-2 me-0 verified" />
                                            @endif
                                            @if ($user->is_patron)
                                                <a class="badge tk-badge bg-patron text-capitalize ms-1"
                                                    href="{{ route('patron.home') }}">
                                                    Patron
                                                </a>
                                            @endif
                                            @auth
                                                @if ($user->isFollowing(auth()->user()))
                                                    <span class="ms-2 badge bg-light text-secondary">Follows you</span>
                                                @endif
                                            @endauth
                                        </a>
                                        <div class="text-secondary mb-2">
                                            {{ '@' . $user->username }}
                                        </div>
                                        <div class="text-dark">{{ $user->bio }}</div>
                                        <div class="small mt-2 text-dark">
                                            <span>
                                                <x-heroicon-o-calendar class="heroicon text-secondary" />
                                                Joined {{ $user->created_at->format('F Y') }}
                                            </span>
                                            @if ($user->location)
                                                <span class="ms-3">
                                                    <a class="text-dark"
                                                        href="https://www.google.com/maps/search/{{ urlencode($user->location) }}"
                                                        target="_blank" rel="noreferrer">
                                                        <x-heroicon-o-map class="heroicon text-secondary" />
                                                        {{ $user->location }}
                                                    </a>
                                                </span>
                                            @endif
                                            @if ($user->company)
                                                <span class="ms-3">
                                                    <x-heroicon-o-briefcase class="heroicon text-secondary" />
                                                    {{ $user->company }}
                                                </span>
                                                @if ($user->is_staff)
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
