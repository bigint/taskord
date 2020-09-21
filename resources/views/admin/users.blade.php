@extends('layouts.app')

@section('pageTitle', 'Admin - Users ·')
@section('title', 'Admin - Users ·')
@section('description', 'Get things done socially with Taskord.')
@section('image', '')
@section('url', url()->current())

@section('content')
@livewire('admin.users')
@endsection
