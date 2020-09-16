@extends('layouts.app')

@section('pageTitle', 'Questions / Newest ·')
@section('title', 'Questions / Newest ·')
@section('description', 'Browse questions and discuss, answer, give feedbacks, etc.')
@section('image', '')
@section('url', url()->current())

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="container">
            <div class="row">
                <div class="col-md-8">
                    @include('questions.nav')
                    @if (session()->has('question_deleted'))
                        <div class="alert alert-success alert-dismissible fade show mt-2">
                            <button type="button" class="close" data-dismiss="alert">×</button>
                            <i class="fa fa-check mr-1"></i>
                            {{ session('question_deleted') }}
                        </div>
                    @endif
                    @livewire('questions.questions', [
                        'type' => $type,
                        'page' => 1,
                        'perPage' => 10
                    ])
                </div>
                <div class="col-sm">
                    @include('questions.sidebar')
                    <x-footer />
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
