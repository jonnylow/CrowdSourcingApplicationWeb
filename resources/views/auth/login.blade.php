@extends('layouts.master')

@section('title', 'Login')

@section('content')

<div class="container">
    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <h1>Welcome back!</h1>

            @include('errors.list')

            {!! Form::open(['url' => asset('auth/login'), 'role' => 'login']) !!}
                <div class="form-group">
                    {!! Form::label('email', 'Email', ['class' => 'control-label sr-only']) !!}
                    {!! Form::email('email', old('email'), ['class' => 'form-control', 'required', 'autofocus', 'placeholder' => 'Email']) !!}
                </div>
                <div class="form-group">
                    {!! Form::label('password', 'Password', ['class' => 'control-label sr-only']) !!}
                    {!! Form::password('password', ['class' => 'form-control', 'required', 'placeholder' => 'Password']) !!}
                </div>
                <div class="checkbox">
                    <label>
                        {!! Form::checkbox('remember', old('remember')) !!}&nbsp;Remember me
                    </label>
                </div>
                <div class="form-group">
                    {!! Form::submit('Log in', ['class' => 'btn btn-primary btn-lg btn-block']) !!}
                </div>
                <div class="text-center">
                    <a href="{{ asset('password/email') }}" class="forget-password">Forgot your password?</a>
                </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>

@endsection

@section('page-script')

{!! $validator !!}

@endsection
