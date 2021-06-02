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
                <livewire:milestone.single-milestone :type="$type" :milestone="$milestone" :wire:key="$milestone->id" />
            </div>
            @livewire('milestone.tasks', [
                'milestone' => $milestone,
                'page' => 1,
                'perPage' => 1
            ])
        </div>
        <div class="col-sm">
            <div class="text-uppercase fw-bold text-secondary pb-2">
                Created by
            </div>
            <div class="card mb-4">
                <div class="card-body d-flex align-items-center">
                    <x:shared.user-label-with-bio :user="$milestone->user" />
                </div>
            </div>
            @if ($milestone->likerscount() > 0)
                <div class="text-uppercase fw-bold text-secondary pb-2">
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
