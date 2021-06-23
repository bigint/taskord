@extends('layouts.app')

@section('pageTitle', 'About ·')
@section('title', 'About ·')
@section('description', 'Get things done socially with Taskord.')
@section('image', '')
@section('url', url()->current())

@section('content')
    <div class="container col-lg-6">
        <div class="text-center my-5">
            <img class="mb-3" src="https://ik.imagekit.io/taskordimg/logo_FLhAmih_U.svg" height="70" alt="Taskord Logo">
            <div class="h1">Get things done in public</div>
            <div class="mt-3 h4 lh-sm text-secondary fw-normal" style="letter-spacing:1px">
                Taskord is a community of makers in tech shipping and working together. Makers post their daily tasks and
                grow a network of supportive, like-minded people.
            </div>
        </div>
    </div>
    <div class="container font-monospace d-flex justify-content-evenly">
        <div class="text-center">
            <div class="h4">{{ $tasks }}</div>
            <div class="small">Tasks</div>
        </div>
        <div class="text-center">
            <div class="h4">{{ $users }}</div>
            <div class="small">Users</div>
        </div>
        <div class="text-center">
            <div class="h4">{{ $questions }}</div>
            <div class="small">Questions</div>
        </div>
        <div class="text-center">
            <div class="h4">{{ $milestones }}</div>
            <div class="small">Milestones</div>
        </div>
    </div>
    <div class="container col-3 my-5">
        <div class="card bg-transparent">
            <div class="card-body d-flex justify-content-between align-items-center">
                <div>Follow us on</div>
                <div>
                    <a class="me-3" href="https://twitter.com/taskord" target="_blank">
                        <img class="avatar-20" src="https://ik.imagekit.io/taskordimg/icons/twitter_4cXueyhRfH.svg"
                            loading=lazy />
                    </a>
                    <a class="me-3 href=" https://gitlab.com/yo" target="_blank">
                        <img class="avatar-20" src="https://ik.imagekit.io/taskordimg/icons/gitlab_j_ySNAHxP.svg"
                            loading=lazy />
                    </a>
                    <a href="https://taskord.com/product/taskord" target="_blank">
                        <img class="avatar-20" src="https://ik.imagekit.io/taskordimg/logo_FLhAmih_U.svg" loading=lazy />
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
