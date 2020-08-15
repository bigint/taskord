@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            @livewire('tasks.create-task')
            @livewire('tasks.today')
            @livewire('tasks.all-time')
        </div>
    </div>
</div>
@endsection
