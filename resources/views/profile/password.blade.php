@extends('layouts.master')

@section('title', 'Change your Password')

@section('content')

<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <h1>Change your Password</h1>

            <div class="row margin-bottom-sm">
                <div class="col-md-8 col-md-offset-2">
                    @include('errors.list')
                </div>
            </div>

            {!! Form::open(['class' => 'form-horizontal', 'method' => 'PATCH', 'route' => 'profile.update.password']) !!}
                <!-- Current Password Form Input -->
                <div class="form-group">
                    {!! Form::label('current_password', 'Current Password', ['class' => 'control-label col-md-4']) !!}
                    <div class="col-md-8">
                        {!! Form::password('current_password', ['class' => 'form-control', 'required']) !!}
                    </div>
                </div>
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
                <!-- Submit Button Form Input -->
                <div class="form-group text-center">
                    {!! Form::submit('Update Password', ['class' => 'btn btn-primary btn-lg']) !!}
                </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>

@endsection

@section('page-script')

{!! $validator !!}

@endsection

@section('auth-script')

@include('auth._redirect_if_no_auth')

@endsection
