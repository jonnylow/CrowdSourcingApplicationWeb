@extends('layouts.master')

@section('title', 'Profile')

@section('content')

<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <h1>Change Password</h1>
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

            {!! Form::open(['class' => 'form-horizontal', 'method' => 'POST', 'action' => 'Profiles\ProfileController@updatePassword']) !!}
                <!-- New Password Form Input -->
                <div class="form-group">
                    {!! Form::label('new_password', 'New Password', ['class' => 'control-label col-md-4']) !!}
                    <div class="col-md-8">
                        {!! Form::password('new_password', ['class' => 'form-control']) !!}
                    </div>
                </div>
                <!-- Confirm New Password Form Input -->
                <div class="form-group">
                    {!! Form::label('new_password_confirmation', 'Confirm New Password', ['class' => 'control-label col-md-4']) !!}
                    <div class="col-md-8">
                        {!! Form::password('new_password_confirmation', ['class' => 'form-control']) !!}
                    </div>
                </div>
                <!-- Current Password Form Input -->
                <div class="form-group">
                    {!! Form::label('current_password', 'Current Password', ['class' => 'control-label col-md-4']) !!}
                    <div class="col-md-8">
                        {!! Form::password('current_password', ['class' => 'form-control', 'required' => 'required']) !!}
                        <p class="help-block">You must enter your current password to make any changes.</p>
                    </div>
                </div>
                <!-- Submit Button Form Input -->
                <div class="form-group text-center">
                    {!! Form::submit('Update Password', ['class' => 'btn btn-default btn-md']) !!}
                </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>

@endsection
