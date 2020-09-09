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
                            <th scope="col">Email</th>
                            <th scope="col">Last IP</th>
                            <th scope="col">Via</th>
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
                            <td>
                                {{ $user->email }}
                                @if ($user->hasVerifiedEmail())
                                <i class="fa fa-check text-success ml-1" title="Email Verified"></i>
                                @else
                                <i class="fa fa-times text-danger ml-1" title="Email not Verified"></i>
                                @endif
                            </td>
                            <td>
                                <code>{{ $user->lastIP }}</code>
                            </td>
                            <td>
                                @if ($user->provider === 'google')
                                    <i class="fa fa-google text-danger"></i>
                                @elseif ($user->provider === 'twitter')
                                    <i class="fa fa-twitter text-info"></i>
                                @else
                                    <i class="fa fa-globe text-success"></i>
                                @endif
                            </td>
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
