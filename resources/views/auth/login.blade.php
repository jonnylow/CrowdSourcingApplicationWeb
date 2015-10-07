@extends('layouts.master')

@section('title', 'Login Page')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-offset-3 col-md-6">
                <h1>Sign in here</h1>
                {!! Form::open(['url' => 'auth/login', 'role' => 'login']) !!}
                    <div class="form-group">
                        {!! Form::label('email','Email', ['class' => 'sr-only']) !!}
                        {!! Form::email('email', null, ['class' => 'form-control', 'placeholder' => 'Email', 'required' => 'true' ]) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('password','Password', ['class' => 'sr-only']) !!}
                        {!! Form::password('password', ['class' => 'form-control', 'placeholder' => 'Password', 'required' => 'true' ]) !!}
                    </div>
                    <div class="form-group">
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" name="remember">
                                {!! Form::label('remember', 'Remember me') !!}
                            </label>
                        </div>
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
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title" id="myForgetModalLabel">Recovery password</h4>
                </div>
                <div class="modal-body">
                    <p>Enter your email account</p>
                    <input type="email" name="recovery-email" id="recovery-email" class="form-control" autocomplete="off">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary">Send password</button>
                </div>
            </div> <!-- /.modal-content -->
        </div> <!-- /.modal-dialog -->
    </div> <!-- /.modal -->
@endsection
