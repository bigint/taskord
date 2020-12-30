@extends('layouts.app')

@section('description', 'Get things done socially with Taskord.')
@section('image', 'https://i.imgur.com/AcK2WpZ.png')
@section('url', url()->current())

@section('content')
<div class="container-md">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            @guest
            <div class="p-5 rounded mb-4 text-white welcome-card">
                <h1>Welcome to Taskord 👋</h1>
                <p class="lead">
                    <span class="fw-bold">Don't fake just make!</span> Get things done in public with awesome community of makers.
                </p>
                <a class="btn btn-lg btn-light" href="/register" role="button">
                    Signup now
                </a>
            </div>
            @endguest
            @livewire('home.recent-questions')
            @livewire('home.launched-today')
            @auth
                @if (!Auth::user()->isFlagged)
                @livewire('create-task')
                @endif
            @endauth
            <div class="pb-3">
                <span class="h5">
                    <x-heroicon-o-check-circle class="heroicon-2x ms-1 text-secondary" />
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
                <div class="h5 text-muted pb-2">
                    @php
                        $hour = Carbon::now()->setTimezone(Auth::user()->timezone)->format('H');
                    @endphp
                    Good
                    <span>
                        @if ($hour < 12) morning 🌄
                        @elseif ($hour < 17) afternoon ☀️
                        @else evening 🌇
                        @endif
                    </span>
                </div>
                <div class="card mb-4">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <a href="{{ route('user.done', ['username' => Auth::user()->username]) }}">
                                <img loading=lazy class="rounded-circle avatar-50 mt-1" src="{{ Helper::getCDNImage(Auth::user()->avatar, 160) }}" height="50" width="50" alt="{{ Auth::user()->username }}'s avatar" />
                            </a>
                            <a class="ms-3 text-dark" href="{{ route('user.done', ['username' => Auth::user()->username]) }}">
                                @if (Auth::user()->firstname or Auth::user()->lastname)
                                <div class="h5">
                                    {{ Auth::user()->firstname }}{{ ' '.Auth::user()->lastname }}
                                    @if (Auth::user()->isVerified)
                                        <x-heroicon-s-badge-check class="heroicon-2x ms-1 text-primary verified" />
                                    @endif
                                </div>
                                @endif
                                <div class="small fw-bold">
                                    {{ '@'.Str::limit(Auth::user()->username, '20') }}
                                </div>
                            </a>
                            <a class="btn btn-sm btn-success text-white float-end ms-auto" href="{{ route('user.settings.profile') }}">
                                <x-heroicon-o-cog class="heroicon" />
                                Update
                            </a>
                        </div>
                    </div>
                    <div class="card-footer small fw-bold d-flex justify-content-between">
                        <a class="text-dark" href="{{ route('user.following', ['username' => Auth::user()->username]) }}">
                            <x-heroicon-o-user-add class="heroicon text-secondary" />
                            {{ Auth::user()->followings()->count() }}
                            Following
                        </a>
                        <a class="text-dark" href="{{ route('user.followers', ['username' => Auth::user()->username]) }}">
                            <x-heroicon-o-users class="heroicon text-secondary" />
                            {{ number_format(Auth::user()->followers()->count()) }}
                            {{ Auth::user()->followers()->count() === 1 ? "Follower" : "Followers" }}
                        </a>
                        <span>
                            <x-heroicon-o-fire class="heroicon text-secondary" />
                            {{ number_format(Auth::user()->getPoints()) }}
                            {{ Auth::user()->getPoints() < 2 ? 'Reputation' : 'Reputations' }}
                        </span>
                    </div>
                </div>
            @endauth
            @livewire('home.recently-joined')
            @livewire('home.recently-launched')
            @livewire('home.top-reputations')
            <x-footer />
        </div>
    </div>
</div>
@endsection
