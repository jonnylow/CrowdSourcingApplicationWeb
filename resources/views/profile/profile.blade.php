@extends('layouts.master')

@section('title', 'Profile')

@section('content')

<div class="container">
    <div class="row">
        <div class="col-md-offset-2 col-md-8">
            <h1>My Profile</h1>
            @if (count($errors) || Session::has('success'))
            <div class="alert alert-{{ count($errors) ? 'danger' : 'success' }} alert-dismissible fade in" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                @if (count($errors))
                <strong>Please double-check and try again.</strong>
                <ul>
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
                @elseif (Session::has('success'))
                {{ Session::get('success') }}
                @endif
            </div>
            @endif

            <form class="form-horizontal" method="post" action="{{ URL::asset('profile') }}">
                {!! csrf_field() !!}
                <div class="form-group">
                    <label class="control-label col-md-4" for="name">Name</label>
                    <div class="col-md-8">
                        <input class="form-control" type="text" name="name" value="{{ old('name', Auth::user()->name) }}" required>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-4" for="email">Email</label>
                    <div class="col-md-8">
                        <input class="form-control" type="email" name="email" value="{{ old('email', Auth::user()->email) }}" required>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-4" for="new_password">New Password</label>
                    <div class="col-md-8">
                        <input class="form-control" type="password" name="new_password" value="{{ old('new_password') }}">
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-4" for="new_password_confirmation">Confirm New Password</label>
                    <div class="col-md-8">
                        <input class="form-control" type="password" name="new_password_confirmation" value="{{ old('new_password_confirmation') }}">
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-4" for="current_password">Current Password</label>
                    <div class="col-md-8">
                        <input class="form-control" type="password" name="current_password" required>
                        <p class="help-block">You must enter your current password to make any changes.</p>
                    </div>
                </div>
                <div class="form-group text-center">
                        <input class="btn btn-default btn-md" type="submit" value="Update profile">
                </div>
            </form>
        </div>
    </div>
</div>

@endsection
