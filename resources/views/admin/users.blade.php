@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="container">
            @include('admin.sidebar')
            <div class="card">
                <div class="card-header">
                    Featured
                </div>
                <div class="card-body">
                    @foreach ($users as $user)
                        {{$user->username}}
                    @endforeach
                    {{ $users->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
