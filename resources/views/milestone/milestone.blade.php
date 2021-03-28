@extends('layouts.app')

@if ($milestone->hidden)
@section('pageTitle', 'Hidden Milestone ·')
@else
@section('pageTitle', $milestone->name.' ·')
@section('title', 'Milestone by @'.$milestone->user->username.' ·')
@section('description', $milestone->name)
@section('image', Helper::getCDNImage($milestone->user->avatar))
@section('url', url()->current())
@endif

@section('content')
<div class="container-md">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="mb-4">
                @livewire('milestone.single-milestone', [
                    'type' => $type,
                    'milestone' => $milestone,
                ])
            </div>
        </div>
        <div class="col-sm">
            <div class="fw-bold text-secondary pb-2">
                Created by
            </div>
            <div class="card mb-4">
                <div class="card-body d-flex align-items-center">
                    <a
                        href="{{ route('user.done', ['username' => $milestone->user->username]) }}"
                        class="user-popover"
                        data-id="{{ $milestone->user->id }}"
                    >
                        <img loading=lazy class="rounded-circle avatar-40 mt-1" src="{{ Helper::getCDNImage($milestone->user->avatar, 80) }}" height="40" width="40" alt="{{ $milestone->user->username }}'s avatar" />
                    </a>
                    <span class="ms-3">
                        <a
                            href="{{ route('user.done', ['username' => $milestone->user->username]) }}"
                            class="align-text-top text-dark user-popover"
                            data-id="{{ $milestone->user->id }}"
                        >
                            <span class="fw-bold">
                                @if ($milestone->user->firstname or $milestone->user->lastname)
                                    {{ $milestone->user->firstname }}{{ ' '.$milestone->user->lastname }}
                                @else
                                    {{ $milestone->user->username }}
                                @endif
                                @if ($milestone->user->status)
                                <span class="ms-1 small" title="{{ $milestone->user->status }}">{{ $milestone->user->status_emoji }}</span>
                                @endif
                            </span>
                            <div>{{ $milestone->user->bio }}</div>
                        </a>
                    </span>
                </div>
            </div>
            @if ($milestone->likerscount() > 0)
            <div class="fw-bold text-secondary pb-2">
                Liked by
            </div>
            <div class="card mb-4">
                <div class="card-body align-items-center pb-2">
                    @foreach ($milestone->likers as $user)
                        <a
                            title="{{ $user->firstname ? $user->firstname . ' ' . $user->lastname : $user->username }}"
                            href="{{ route('user.done', ['username' => $user->username]) }}"
                            class="me-1"
                        >
                            <img loading=lazy class="rounded-circle avatar-30 mb-2" src="{{ Helper::getCDNImage($user->avatar, 80) }}" height="30" width="30" alt="{{ $user->username }}'s avatar" />
                        </a>
                    @endforeach
                </div>
            </div>
            @endif
            <x-footer />
        </div>
    </div>
</div>
@endsection
