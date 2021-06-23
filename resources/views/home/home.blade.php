@extends('layouts.app')

@section('description', 'Get things done socially with Taskord.')
@section('image', 'https://ik.imagekit.io/taskordimg/cover_i8r6XmiSW.png')
@section('url', url()->current())

@section('content')
    <div class="container-md">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <livewire:home.recent-questions />
                <livewire:home.launched-today />
                @auth
                    @if (!auth()->user()->spammy)
                        <div class="card mb-3">
                            <div class="card-body">
                                <livewire:create-task />
                            </div>
                        </div>
                    @endif
                @endauth
                <div class="pb-3">
                    <span class="h5">
                        <x-heroicon-o-check-circle class="heroicon heroicon-20px text-secondary" />
                        Tasks
                    </span>
                    @auth
                        <livewire:home.only-following />
                    @endauth
                </div>
                <livewire:home.tasks :page="1" />
            </div>
            <div class="col-sm">
                @auth
                    <livewire:home.onboarding />
                    <div class="h5 text-secondary pb-2">
                        @php
                            $hour = carbon()
                                ->setTimezone(auth()->user()->timezone)
                                ->format('H');
                        @endphp
                        Good
                        <span>
                            @if ($hour < 12) morning 🌄
                        @elseif ($hour < 17) afternoon ☀️ @else evening 🌇 @endif
                    </span>
                </div>
                <div class="card mb-4">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <a href="{{ route('user.done', ['username' => auth()->user()->username]) }}">
                                <img loading=lazy class="rounded-circle avatar-50 mt-1"
                                    src="{{ Helper::getCDNImage(auth()->user()->avatar, 160) }}" height="50" width="50"
                                    alt="{{ auth()->user()->username }}'s avatar" />
                            </a>
                            <a class="ms-3 text-dark"
                                href="{{ route('user.done', ['username' => auth()->user()->username]) }}">
                                @if (auth()->user()->firstname or auth()->user()->lastname)
                                    <div class="h5">
                                        {{ auth()->user()->firstname }}{{ ' ' . auth()->user()->lastname }}
                                        @if (auth()->user()->status)
                                            <span class="ms-1 small"
                                                title="{{ auth()->user()->status }}">{{ auth()->user()->status_emoji }}</span>
                                        @else
                                            <span class="ms-1 small" title="Set Status">💭</span>
                                        @endif
                                        @if (auth()->user()->is_verified)
                                            <x-heroicon-s-badge-check
                                                class="heroicon heroicon-20px ms-1 text-primary verified" />
                                        @endif
                                    </div>
                                @endif
                                <div class="small fw-bold">
                                    {{ '@' . Str::limit(auth()->user()->username, '20') }}
                                </div>
                            </a>
                            <a class="btn btn-sm btn-outline-success rounded-pill float-end ms-auto"
                                href="{{ route('user.settings.profile') }}">
                                <x-heroicon-o-cog class="heroicon heroicon-15px" />
                                Update
                            </a>
                        </div>
                    </div>
                    <div class="card-footer small fw-bold d-flex justify-content-between">
                        <a class="text-dark"
                            href="{{ route('user.following', ['username' => auth()->user()->username]) }}">
                            <x-heroicon-o-user-add class="heroicon text-secondary" />
                            {{ auth()->user()->followings->count() }}
                            {{ pluralize(
    'Following',
    auth()->user()->followings->count(),
) }}
                        </a>
                        <a class="text-dark"
                            href="{{ route('user.followers', ['username' => auth()->user()->username]) }}">
                            <x-heroicon-o-users class="heroicon text-secondary" />
                            {{ number_format(
    auth()->user()->followers->count(),
) }}
                            {{ pluralize(
    'Follower',
    auth()->user()->followers->count(),
) }}
                        </a>
                        <span title="{{ number_format(auth()->user()->streaks) }} day streak">
                            <x-heroicon-o-fire class="heroicon text-secondary" />
                            {{ number_format(auth()->user()->streaks) }}
                            {{ pluralize('Streak', auth()->user()->streaks) }}
                        </span>
                    </div>
                </div>
                @include('home.ad')
                <livewire:home.suggestions :user="auth()->user()" :wire:key="$auth()->id()" />
            @endauth
            <livewire:home.recently-joined />
            <livewire:home.recently-launched />
            <livewire:home.top-reputations />
            <x-footer />
        </div>
    </div>
</div>
@endsection
