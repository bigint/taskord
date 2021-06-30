@extends('layouts.app')

@section('pageTitle', $badge->title . ' ·')
@section('title', 'Badge | ' . $badge->title . ' ·')
@section('description', $badge->title)
@section('image', '')
@section('url', url()->current())

@section('content')
    <div class="badge-bg" style="background: {{ $badge->color }}"></div>
    <div class="container-md badge-card">
        <div class="row justify-content-center">
            <div class="col-lg-7">
                @livewire('badges.single-badge', [
                'badge' => $badge,
                ], key($badge->id))
                <div class="h5 mt-4 mb-3">
                    People with {{ $badge->title }} badge
                </div>
                <div class="card">
                    @livewire('badges.subscribers', [
                    'badge' => $badge,
                    ], key($badge->id))
                </div>
            </div>
        </div>
    </div>
@endsection
