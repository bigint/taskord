@extends('layouts.app')

@section('pageTitle', 'Deals ·')
@section('title', 'Deals ·')
@section('description', 'Get things done socially with Taskord.')
@section('image', '')
@section('url', url()->current())

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header pt-3 pb-3">
            <span class="h5">Deals</span>
            <div>Sub-heading</div>
            @auth
            @if (Auth::user()->staffShip)
            <button type="button" class="mt-2 btn btn-success text-white" data-toggle="modal" data-target="#newQuestionModal">
                <i class="fa fa-plus"></i>
                Add a Deal
            </button>
            @livewire('pages.create-deal')
            @endif
            @endauth
        </div>
        <div class="card-body">
            Soon
        </div>
    </div>
</div>
@endsection
