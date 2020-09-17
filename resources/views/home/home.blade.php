@extends('layouts.app')

@section('description', 'Get things done socially with Taskord.')
@section('image', 'https://i.imgur.com/AcK2WpZ.png')
@section('url', url()->current())

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="container">
            <div class="row">
                <div class="col-md-8">
                    @guest
                    <div class="p-5 rounded mb-4 text-white welcome-card">
                        <h1>Welcome to Taskord</h1>
                        <p class="lead">
                            Taskord helps you stay social with your todolist, so you can get things done together.
                        </p>
                        <a class="btn btn-lg btn-light" href="/register" role="button">
                            Signup now
                        </a>
                    </div>
                    @endguest
                    <div class="card mb-4">
                        <div class="card-header">
                            Recent questions
                        </div>
                        <div class="card-body">
                            @foreach ($recent_questions as $question)
                                <div class="{{ $loop->index === count($recent_questions) - 1 ? '' : 'mb-2' }} {{ $question->patronOnly ? 'bg-patron recent-questions' : '' }}">
                                    <a href="{{ route('user.done', ['username' => $question->user->username]) }}">
                                        <img class="rounded-circle avatar-30" src="{{ $question->user->avatar }}" />
                                    </a>
                                    <a href="{{ route('question.question', ['id' => $question->id]) }}">
                                        <span class="ml-1 font-weight-bold align-middle text-dark">{{ Str::words($question->title, '10') }}</span>
                                        @if ($question->answer->count('id') >= 1)
                                        <span class="ml-1 align-middle text-black-50">
                                            {{ $question->answer->count('id') }} {{ $question->answer->count('id') >= 1 ? 'answers' : 'answer' }}
                                        </span>
                                        @endif
                                    </a>
                                    @if ($question->created_at->isToday())
                                    <span class="badge bg-success ml-2 align-middle">New</span>
                                    @endif
                                    <span class="avatar-stack ml-1">
                                        @foreach ($question->answer->groupBy('user_id')->take(5) as $answer)
                                        <img class="replies-avatar rounded-circle {{ $loop->last ? 'mr-0' : '' }}" src="{{ $answer[0]->user->avatar }}" />
                                        @endforeach
                                    </span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    @if (count($launched_today) > 0)
                    <div class="card mb-4">
                        <div class="card-header">
                            🚀 Launched Today
                            <x-beta background="light" />
                        </div>
                        <ul class="list-group list-group-flush">
                            @foreach ($launched_today->take(5) as $product)
                            <li class="list-group-item">
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
                                    <a class="ml-auto" href="{{ route('user.done', ['username' => $product->owner->username]) }}">
                                        <img class="rounded-circle float-right avatar-30 mt-1 ml-2" src="{{ $product->owner->avatar }}" height="50" width="50" />
                                    </a>
                                </div>
                            </li>
                            @endforeach
                        </ul>
                        @if (count($launched_today) > 5)
                        <div class="card-footer">
                            <a class="font-weight-bold" href="{{ route('products.newest') }}">More Products...</a>
                        </div>
                        @endif
                    </div>
                    @endif
                    @auth
                        @if (!Auth::user()->isFlagged)
                        @livewire('create-task', [
                            'type' => 'user',
                            'product_id' => null,
                        ])
                        @endif
                    @endauth
                    <div class="mb-3">
                        <span class="h5">
                            Tasks
                        </span>
                        @auth
                        @livewire('home.only-following')
                        @endauth
                    </div>
                    @livewire('home.tasks', [
                        'page' => 1,
                    ])
                </div>
                <div class="col-sm">
                    @auth
                        @livewire('home.onboarding')
                        <div class="card mb-4">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <a href="{{ route('user.done', ['username' => Auth::user()->username]) }}">
                                        <img class="rounded-circle avatar-50 mt-1" src="{{ Auth::user()->avatar }}" />
                                    </a>
                                    <a class="ml-3 text-dark" href="{{ route('user.done', ['username' => Auth::user()->username]) }}">
                                        @if (Auth::user()->firstname or Auth::user()->lastname)
                                        <div class="h5">
                                            {{ Auth::user()->firstname }}{{ ' '.Auth::user()->lastname }}
                                            @if (Auth::user()->isVerified)
                                                <i class="fa fa-check-circle ml-1 text-primary" title="Verified"></i>
                                            @endif
                                        </div>
                                        @endif
                                        <div class="small font-weight-bold">
                                            {{ '@'.Str::limit(Auth::user()->username, '20') }}
                                        </div>
                                    </a>
                                    <a class="btn btn-sm btn-success text-white float-right ml-auto" href="{{ route('user.settings.profile') }}">
                                        <i class="fa fa-gear mr-1"></i>
                                        Update
                                    </a>
                                </div>
                            </div>
                            <div class="card-footer small font-weight-bold d-flex justify-content-between">
                                <a class="text-dark" href="{{ route('user.following', ['username' => Auth::user()->username]) }}">
                                    <i class="fa fa-plus mr-1 text-black-50"></i>
                                    {{ Auth::user()->followings()->count() }}
                                    Following
                                </a>
                                <a class="text-dark" href="{{ route('user.followers', ['username' => Auth::user()->username]) }}">
                                    <i class="fa fa-users mr-1 text-black-50"></i>
                                    {{ number_format(Auth::user()->followers()->count()) }}
                                    {{ Auth::user()->followers()->count() === 1 ? "Follower" : "Followers" }}
                                </a>
                                <span>
                                    <i class="fa fa-fire mr-1 text-black-50"></i>
                                    {{ number_format(Auth::user()->getPoints()) }}
                                    {{ Auth::user()->getPoints() < 2 ? 'Reputation' : 'Reputations' }}
                                </span>
                            </div>
                        </div>
                    @endauth
                    <div class="card mb-4">
                        <div class="card-header">
                            🙌 Recently Joined
                        </div>
                        <ul class="list-group list-group-flush">
                            @foreach ($recently_joined as $user)
                            <li class="d-flex list-group-item align-items-center">
                                <a href="{{ route('user.done', ['username' => $user->username]) }}">
                                    <img class="rounded-circle avatar-40 mt-1" src="{{ $user->avatar }}" />
                                </a>
                                <span class="ml-3">
                                    <a href="{{ route('user.done', ['username' => $user->username]) }}" class="align-text-top text-dark">
                                        <span class="font-weight-bold">
                                            @if ($user->firstname or $user->lastname)
                                                {{ $user->firstname }}{{ ' '.$user->lastname }}
                                            @else
                                                {{ $user->username }}
                                            @endif
                                            @if ($user->isVerified)
                                                <i class="fa fa-check-circle ml-1 text-primary" title="Verified"></i>
                                            @endif
                                        </span>
                                        <div>
                                            @if ($user->bio)
                                            <span class="small">
                                                {{ $user->bio }}
                                            </span>
                                            @else
                                            <span class="small text-black-50">
                                                Joined {{ Carbon::parse($user->created_at)->diffForHumans() }}
                                            </span>
                                            @endif
                                        </div>
                                    </a>
                                </span>
                            </li>
                            @endforeach
                        </ul>
                        @if ($recently_joined_count > 5)
                        <div class="card-footer">
                            <span class="font-weight-bold">{{ $recently_joined_count - 5 }} more...</span>
                        </div>
                        @endif
                    </div>
                    <div class="card mb-4">
                        <div class="card-header">
                            ✨ Recently Launched
                        </div>
                        <ul class="list-group list-group-flush">
                            @foreach ($products as $product)
                            <li class="list-group-item pb-2 pt-2">
                                <a href="{{ route('product.done', ['slug' => $product->slug]) }}">
                                    <img class="rounded avatar-30 mt-1 ml-2" src="{{ $product->avatar }}" height="50" width="50" />
                                </a>
                                <a href="{{ route('product.done', ['slug' => $product->slug]) }}" class="ml-2 mr-2 align-text-top font-weight-bold text-dark">
                                    {{ $product->name }}
                                    @if ($product->launched)
                                        <a href="{{ route('products.launched') }}" class="small" data-toggle="tooltip" data-placement="right" title="Launched">
                                            {{ Emoji::rocket() }}
                                        </a>
                                    @endif
                                </a>
                                <a href="{{ route('user.done', ['username' => $product->owner->username]) }}">
                                    <img class="rounded-circle float-right avatar-30 mt-1 ml-2" src="{{ $product->owner->avatar }}" height="50" width="50" />
                                </a>
                            </li>
                            @endforeach
                        </ul>
                        <div class="card-footer">
                            <a class="font-weight-bold" href="{{ route('products.newest') }}">More Products...</a>
                        </div>
                    </div>
                    <div class="card mb-4">
                        <div class="card-header">
                            🥇 Top Reputations
                        </div>
                        <ul class="list-group list-group-flush">
                            @foreach ($reputations as $user)
                            <li class="list-group-item pb-2 pt-2">
                                <span class="h6 text-black-50" style="vertical-align:sub">
                                    @if ($loop->index === 0)
                                    <span class="font-weight-bold" style="color:#38c172">
                                    @elseif ($loop->index === 1)
                                    <span class="font-weight-bold" style="color:#6a63ec">
                                    @elseif ($loop->index === 2)
                                    <span class="font-weight-bold" style="color:#fd5f60">
                                    @else
                                    <span>
                                    @endif
                                        #{{ $loop->index + 1 }}
                                    </span>
                                </span>
                                <a href="{{ route('user.done', ['username' => $user->username]) }}">
                                    <img class="rounded-circle avatar-30 mt-1 ml-2" src="{{ $user->avatar }}" height="50" width="50" />
                                </a>
                                <a href="{{ route('user.done', ['username' => $user->username]) }}" class="ml-2 mr-2 align-text-top font-weight-bold text-dark">
                                    @if ($user->firstname or $user->lastname)
                                        {{ $user->firstname }}{{ ' '.$user->lastname }}
                                    @else
                                        {{ $user->username }}
                                    @endif
                                    @if ($user->isVerified)
                                        <i class="fa fa-check-circle ml-1 text-primary" title="Verified"></i>
                                    @endif
                                </a>
                                <span class="badge rounded-pill bg-warning text-dark align-middle reputation" title="{{ Emoji::fire() }} {{ number_format($user->getPoints()) }}">
                                    {{ Emoji::fire() }} {{ $user->getPoints(true) }}
                                </span>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                    <x-footer />
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
