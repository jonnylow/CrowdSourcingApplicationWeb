@extends('layouts.master')

@section('title', 'Add new activity')

@section('content')

<div class="container-fluid">
    <div class="row">
        <div class="col-md-offset-2 col-md-8">
            <h1>Add new activity</h1>
            {!! Form::open() !!}
                <!-- Activity Name Form Input -->
                <div class="form-group">
                    {!! Form::label('activity_name', 'Activity Name', ['class' => 'control-label']) !!}
                    {!! Form::text('activity_name', null, ['class' => 'form-control', 'required' => 'required']) !!}
                </div>
                <div class="row form-group">
                    <!-- Date To Start Form Input -->
                    <div class="col-md-4">
                        {!! Form::label('date_to_start', 'Date To Start', ['class' => 'control-label']) !!}
                        {!! Form::date('date_to_start', null, ['class' => 'form-control', 'required' => 'required', 'min' => Carbon\Carbon::now()->format('Y-m-d')]) !!}
                    </div>
                    <!-- Time To Start Form Input -->
                    <div class="col-md-4">
                        {!! Form::label('time_to_start', 'Time To Start', ['class' => 'control-label']) !!}
                        {!! Form::time('time_to_start', null, ['class' => 'form-control', 'required' => 'required']) !!}
                    </div>
                    <!-- Duration Form Input -->
                    <div class="col-md-4">
                        {!! Form::label('duration', 'Duration (in hours)', ['class' => 'control-label']) !!}
                        {!! Form::number('duration', null, ['class' => 'form-control', 'required' => 'required', 'step' => '0.5', 'min' => '0']) !!}
                    </div>
                </div>
                <div class="row form-group">
                    <!-- Start Location Form Input -->
                    <div class="col-md-6">
                        {!! Form::label('start_location', 'Start Location', ['class' => 'control-label']) !!}
                        {!! Form::textarea('start_location', null, ['class' => 'form-control', 'required' => 'required', 'rows' => '3']) !!}
                    </div>
                    <!-- End Location Form Input -->
                    <div class="col-md-6">
                        {!! Form::label('end_location', 'End Location', ['class' => 'control-label']) !!}
                        {!! Form::textarea('end_location', null, ['class' => 'form-control', 'required' => 'required', 'rows' => '3']) !!}
                    </div>
                </div>
                <!-- More Information Form Input -->
                <div class="form-group">
                    {!! Form::label('more_information', 'More Information', ['class' => 'control-label']) !!}
                    {!! Form::textarea('more_information', null, ['class' => 'form-control', 'rows' => '5', 'placeholder' => 'Optional']) !!}
                </div>
                <hr>
                <div class="row form-group">
                    <!-- Senior Name Form Input -->
                    <div class="col-md-4">
                        {!! Form::label('senior_name', 'Senior Name', ['class' => 'control-label']) !!}
                        {!! Form::text('senior_name', null, ['class' => 'form-control', 'required' => 'required']) !!}
                    </div>
                    <!-- Senior's Next-of-Kin Name Form Input -->
                    <div class="col-md-4">
                        {!! Form::label('senior_nok_name', 'Senior\'s Next-of-Kin Name', ['class' => 'control-label']) !!}
                        {!! Form::text('senior_nok_name', null, ['class' => 'form-control', 'required' => 'required']) !!}
                    </div>
                    <!-- Senior's Next-of-Kin Contact Number Form Input -->
                    <div class="col-md-4">
                        {!! Form::label('senior_nok_contact', 'Senior\'s Next-of-Kin Contact Number', ['class' => 'control-label']) !!}
                        {!! Form::tel('senior_nok_contact', null, ['class' => 'form-control', 'required' => 'required', 'maxlength' => '8', 'pattern' => '^[0-9]+$', 'placeholder' => '67654321']) !!}
                    </div>
                </div>
                <!-- Submit Button Form Input -->
                <div class="form-group text-center">
                    {!! Form::submit('Add new activity', ['class' => 'btn btn-default btn-md']) !!}
                </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>

@endsection
