@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row row-cols-1 row-cols-md-3 mb-3 text-center">
        <div class="col">
            <div class="card mb-4 shadow-sm">
                <div class="card-header">
                    <h4 class="my-0 font-weight-normal">Tier {{ $tier }}</h4>
                </div>
                <div class="card-body">
                    <h1>$50 <small class="text-muted">/ mo</small></h1>
                    <ul class="list-unstyled mt-3 mb-4">
                        <li>Soon</li>
                        <li>Soon</li>
                        <li>Soon</li>
                        <li>Soon</li>
                    </ul>
                    <button class="btn btn-lg btn-block btn-primary">
                        Support now
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
