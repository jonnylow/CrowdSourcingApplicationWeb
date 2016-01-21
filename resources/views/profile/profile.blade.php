@extends('layouts.master')

@section('title', 'Update your Profile')

@section('content')

<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <h1>My Profile</h1>
            @include('errors.list')

            {!! Form::model(Auth::user(), ['class' => 'form-horizontal', 'method' => 'PATCH', 'route' => ['profile.update']]) !!}
                <!-- Name Form Input -->
                <div class="form-group">
                    {!! Form::label('name', 'Name', ['class' => 'control-label col-md-4']) !!}
                    <div class="col-md-8">
                        {!! Form::text('name', null, ['class' => 'form-control', 'required']) !!}
                    </div>
                </div>
                <!-- Email Form Input -->
                <div class="form-group">
                    {!! Form::label('email', 'Email', ['class' => 'control-label col-md-4']) !!}
                    <div class="col-md-8">
                        {!! Form::email('email', null, ['class' => 'form-control', 'required']) !!}
                    </div>
                </div>

                <!-- Current Password Form Input -->
                <div class="form-group">
                    {!! Form::label('current_password', 'Current Password', ['class' => 'control-label col-md-4']) !!}
                    <div class="col-md-8">
                        {!! Form::password('current_password', ['class' => 'form-control', 'required']) !!}
                    </div>
                </div>
                <!-- Submit Button Form Input -->
                <div class="form-group text-center">
                    {!! Form::submit('Update profile', ['class' => 'btn btn-primary btn-lg']) !!}
                </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>

@endsection

@section('page-script')

{!! $validator !!}

@endsection
