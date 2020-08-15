@extends('layouts.app')

@section('pageTitle', 'Questions / Unanswered · ')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="container">
            <div class="row">
                <div class="col-md-8">
                    @include('questions.nav')
                    @livewire('questions.questions', [
                        'type' => $type,
                        'page' => 1,
                        'perPage' => 10
                    ])
                </div>
                <div class="col-sm">
                    @include('questions.sidebar')
                    @include('components.footer')
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
