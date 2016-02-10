@extends('layouts.master')

@section('title', 'View your Profile')

@section('content')

<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <h1>View my Profile</h1>

            {!! Form::model(Auth::user(), ['class' => 'form-horizontal']) !!}
                <!-- Name Form Input -->
                <div class="form-group">
                    {!! Form::label('name', 'Name', ['class' => 'control-label col-md-4']) !!}
                    <div class="col-md-8">
                        {!! Form::text('name', null, ['class' => 'form-control', 'readonly']) !!}
                    </div>
                </div>
                <!-- Email Form Input -->
                <div class="form-group">
                    {!! Form::label('email', 'Email', ['class' => 'control-label col-md-4']) !!}
                    <div class="col-md-8">
                        {!! Form::email('email', null, ['class' => 'form-control', 'readonly']) !!}
                    </div>
                </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>

@endsection
