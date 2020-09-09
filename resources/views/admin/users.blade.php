@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="container">
            @include('admin.sidebar')
            <div class="card">
                <div class="card-header">
                    Users
                </div>
                <table class="table table-striped table-hover text-center">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Avatar</th>
                            <th scope="col">Name</th>
                            <th scope="col">Username</th>
                            <th scope="col">Last IP</th>
                            <th scope="col">Created</th>
                            <th scope="col">Last updated</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                        <tr>
                            <th>{{ $user->id }}</th>
                            <td>
                                <img class="avatar-30 rounded-circle mr-2" src="{{ $user->avatar }}" />
                            </td>
                            <td class="font-weight-bold">
                                {{ $user->firstname.' '.$user->lastname }}
                            </td>
                            <td>{{ '@'.$user->username }}</td>
                            <td>{{ $user->lastIP }}</td>
                            <td>{{ Carbon::parse($user->created_at)->format('M d, Y') }}</td>
                            <td>{{ Carbon::parse($user->updated_at)->format('M d, Y') }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                {{ $users->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
