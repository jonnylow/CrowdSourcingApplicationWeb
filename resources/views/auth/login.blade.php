@extends('layouts.master')

@section('title', 'Login Page')

@section('content')

<div class="container">
    <div class="row">
        <div class="col-md-offset-4 col-md-4">
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

            <form method="post" action="auth/login" role="login">
                {!! csrf_field() !!}
                <div class="form-group">
                    <label class="sr-only" for="email">Email</label>
                    <input class="form-control" type="email" name="email" placeholder="Email" value="{{ old('email') }}" required autofocus>
                </div>
                <div class="form-group">
                    <label class="sr-only" for="password">Password</label>
                    <input class="form-control" type="password" name="password" placeholder="Password" required>
                </div>
                <div class="form-group">
                    <div class="checkbox">
                        <label>
                            <input type="checkbox" name="remember" value="{{ old('remember') }}">&nbsp;Remember me
                        </label>
                    </div>
                </div>
                <div class="form-group">
                    <input class="btn btn-default btn-lg btn-block" type="submit" value="Log in">
                </div>
                <div class="text-center">
                    <a href="#forget-modal" class="forget-password" data-toggle="modal" data-target="#forget-modal">Forgot your password?</a>
                </div>
            </form>
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
            <form method="post" action="password/email">
                {!! csrf_field() !!}
                <div class="modal-body">
                    <p>Enter your email address</p>
                    <input class="form-control" type="email" name="email" placeholder="Email" autocomplete="off" required>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    <input class="btn btn-primary" type="submit" value="Send Password Reset Link">
                </div>
            </form>
        </div> <!-- /.modal-content -->
    </div> <!-- /.modal-dialog -->
</div> <!-- /.modal -->

@endsection
