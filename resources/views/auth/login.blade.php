@extends('layouts.master')

@section('title', 'Login Page')

@section('content')

<div class="container">
    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <h1>Sign in here</h1>
            @if (count($errors))
            <div class="alert alert-danger alert-dismissible fade in" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <strong>Please double-check and try again.</strong>
                <ul>
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            {!! Form::open(['url' => asset('auth/login'), 'role' => 'login']) !!}
                <div class="form-group">
                    {!! Form::label('email', 'Email', ['class' => 'control-label sr-only']) !!}
                    {!! Form::email('email', old('email'), ['class' => 'form-control', 'required' => 'required', 'autofocus' => 'true', 'placeholder' => 'Email']) !!}
                </div>
                <div class="form-group">
                    {!! Form::label('password', 'Password', ['class' => 'control-label sr-only']) !!}
                    {!! Form::password('password', ['class' => 'form-control', 'required' => 'required', 'placeholder' => 'Password']) !!}
                </div>
                <div class="checkbox">
                    <label>
                        {!! Form::checkbox('remember', old('remember')) !!}&nbsp;Remember me
                    </label>
                </div>
                <div class="form-group">
                    {!! Form::submit('Log in', ['class' => 'btn btn-default btn-lg btn-block']) !!}
                </div>
                <div class="text-center">
                    <a href="#forget-modal" class="forget-password" data-toggle="modal" data-target="#forget-modal">Forgot your password?</a>
                </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>

<div class="modal fade" id="forget-modal" tabindex="-1" role="dialog" aria-labelledby="myForgetModalLabel">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="myForgetModalLabel">Recovery password</h4>
            </div>
            {!! Form::open(['url' => asset('password/email')]) !!}
                <div class="modal-body">
                    <p>Enter your email address</p>
                    {!! Form::email('recovery_email', null, ['class' => 'form-control', 'required' => 'required', 'autocomplete' => 'off', 'placeholder' => 'Email']) !!}
                </div>
                <div class="modal-footer">
                    {!! Form::button('Cancel', ['class' => 'btn btn-default', 'data-dismiss' => 'modal']) !!}
                    {!! Form::button('Send Password Reset Link', ['class' => 'btn btn-primary', 'onclick' => 'javascript:alert("Work in Progress")']) !!}
                </div>
            {!! Form::close() !!}
        </div> <!-- /.modal-content -->
    </div> <!-- /.modal-dialog -->
</div> <!-- /.modal -->

@endsection
