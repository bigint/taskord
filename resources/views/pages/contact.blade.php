@extends('layouts.app')

@section('pageTitle', 'About ·')
@section('title', 'About ·')
@section('description', 'Get things done socially with Taskord.')
@section('image', '')
@section('url', url()->current())

@section('content')
<div class="container-md">
    <div class="row justify-content-center">
        <div class="col-lg-7 mt-5">
            <iframe
                src="https://tally.so/embed/63lL53?transparentBackground=1"
                width="100%"
                height="650"
                frameborder="0"
                marginheight="0"
                marginwidth="0"
            ></iframe>
        </div>
    </div>
</div>
@endsection
