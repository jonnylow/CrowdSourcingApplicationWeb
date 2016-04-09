@extends('layouts.master')

@section('title', 'Forgot my Password')

@section('content')

<div class="container">
    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <h1>Forgot your password?</h1>

            @if (session('status'))
                <div class="alert alert-success alert-dismissible fade in" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    {{ session('status') }}
                </div>
            @endif

            {!! Form::open(['route' => 'password.request']) !!}
                <div class="form-group {{ $errors->has('email') ? 'has-error' : '' }}">
                    {!! Form::label('email', 'Enter your email address', ['class' => 'control-label']) !!}
                    {!! Form::email('email', old('email'), ['class' => 'form-control', 'required', 'autofocus', 'placeholder' => 'Email', 'onBlur' => 'javascript:{this.value = this.value.toLowerCase(); }']) !!}

                    @if ($errors->has('email'))
                        <span class="help-block">
                            <strong>{{ $errors->first('email') }}</strong>
                        </span>
                    @endif
                </div>
                <div class="form-group text-right">
                    <a class="btn btn-default btn-md" href="{{ asset('auth/login') }}">Back to Login</a>
                    {!! Form::submit('Send Password Reset Link', ['class' => 'btn btn-primary btn-md']) !!}
                </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>

@endsection
