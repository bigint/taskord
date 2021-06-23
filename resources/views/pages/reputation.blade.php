@extends('layouts.app')

@section('pageTitle', 'Reputation ·')
@section('title', 'Reputation ·')
@section('description', 'Get things done socially with Taskord.')
@section('image', '')
@section('url', url()->current())

@section('content')
    <div class="container-md">
        <div class="row justify-content-center mt-4">
            <div class="col-sm">
                <div class="card mb-4">
                    <div class="card-header py-3">
                        <span class="h5 text-success">Badges</span>
                    </div>
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <span class="fw-bold">Beginner</span>
                            <span>0 to 500</span>
                        </div>
                        <div class="d-flex justify-content-between mt-2">
                            <span class="fw-bold">Novice</span>
                            <span>500 to 2500</span>
                        </div>
                        <div class="d-flex justify-content-between mt-2">
                            <span class="fw-bold">Intermediate</span>
                            <span>2500 to 5000</span>
                        </div>
                        <div class="d-flex justify-content-between mt-2">
                            <span class="fw-bold">Professional</span>
                            <span>5000 to 7500</span>
                        </div>
                        <div class="d-flex justify-content-between mt-2">
                            <span class="fw-bold">Expert</span>
                            <span>7500 to 10000</span>
                        </div>
                        <div class="d-flex justify-content-between mt-2">
                            <span class="fw-bold">Master</span>
                            <span>10000 to 20000</span>
                        </div>
                        <div class="d-flex justify-content-between mt-2">
                            <span class="fw-bold">GrandMaster</span>
                            <span>20000 to 50000</span>
                        </div>
                        <div class="d-flex justify-content-between mt-2">
                            <span class="fw-bold">Enlightened</span>
                            <span>50000 and above</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-8">
                <livewire:user.reputations />
            </div>
        </div>
    </div>
@endsection
