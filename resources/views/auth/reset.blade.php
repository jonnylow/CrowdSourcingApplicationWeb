{{-- Password reset --}}
@extends('layouts.master')

@section('title', 'Choose new Password')

@section('content')

<div class="container">
    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <h1>Choose new password</h1>

            @include('errors.list')

            {!! Form::open(['route' => 'password.reset']) !!}
                <input type="hidden" name="token" value="{{ $token }}">
                <div class="form-group">
                    {!! Form::label('email', 'Email address', ['class' => 'control-label']) !!}
                    {!! Form::email('email', $_GET['email'], ['class' => 'form-control', 'required', 'autofocus', 'placeholder' => 'Email', 'onBlur' => 'javascript:{this.value = this.value.toLowerCase(); }']) !!}
                </div>
                <div class="form-group">
                    {!! Form::label('password', 'New Password', ['class' => 'control-label']) !!}
                    {!! Form::password('password', ['class' => 'form-control']) !!}
                </div>
                <div class="form-group">
                    {!! Form::label('password_confirmation', 'Confirm New Password', ['class' => 'control-label']) !!}
                    {!! Form::password('password_confirmation', ['class' => 'form-control']) !!}
                </div>
                <div class="form-group text-center">
                    {!! Form::submit('Reset password', ['class' => 'btn btn-primary btn-md']) !!}
                </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>

@endsection

@section('page-script')

{!! $validator !!}

@endsection
