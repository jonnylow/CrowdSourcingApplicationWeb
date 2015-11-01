@extends('layouts.master')

@section('title', 'Edit Activity' . $activity->name)

@section('content')

<div class="container-fluid">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <h1>Edit activity</h1>
            @if (count($errors) || Session::has('success'))
                <div class="alert alert-{{ count($errors) ? 'danger' : 'success' }} alert-dismissible fade in" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    @if (count($errors))
                        <strong>Please double-check and try again.</strong>
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    @elseif (Session::has('success'))
                        {{ Session::get('success') }}
                    @endif
                </div>
            @endif

            {!! Form::model($activity, ['method' => 'PATCH', 'route' => ['activities.update', $activity->activity_id]]) !!}
                <fieldset class="margin-bottom-sm">
                    <legend><p class="bg-primary">Activity</p></legend>
                    <!-- Activity Name Form Input -->
                    <div class="form-group">
                        {!! Form::label('name', 'Activity Name', ['class' => 'control-label']) !!}
                        {!! Form::text('name', null, ['class' => 'form-control', 'required' => 'required', 'placeholder' => 'e.g. Henderson Home - Singapore General Hospital']) !!}
                    </div>
                    <div class="row">
                        <!-- Date To Start Form Input -->
                        <div class="col-md-4 form-group">
                            {!! Form::label('date_to_start', 'Date To Start', ['class' => 'control-label']) !!}
                            {!! Form::date('date_to_start', $activity->datetime_start->toDateString(), ['class' => 'form-control', 'required' => 'required', 'min' => Carbon\Carbon::now()->format('Y-m-d')]) !!}
                        </div>
                        <!-- Time To Start Form Input -->
                        <div class="col-md-4 form-group">
                            {!! Form::label('time_to_start', 'Time To Start', ['class' => 'control-label']) !!}
                            {!! Form::time('time_to_start', $activity->datetime_start->toTimeString(), ['class' => 'form-control', 'required' => 'required']) !!}
                        </div>
                        <!-- Duration Form Input -->
                        <div class="col-md-4 form-group">
                            {!! Form::label('duration', 'Duration (in hours)', ['class' => 'control-label']) !!}
                            {!! Form::number('duration', $activity->expected_duration_minutes, ['class' => 'form-control', 'required' => 'required', 'step' => '0.1', 'min' => '0.1']) !!}
                        </div>
                    </div>
                    <!-- More Information Form Input -->
                    <div class="form-group">
                        {!! Form::label('more_information', 'More Information', ['class' => 'control-label']) !!}
                        {!! Form::textarea('more_information', null, ['class' => 'form-control', 'rows' => '5', 'placeholder' => 'Optional']) !!}
                    </div>
                </fieldset>

                <fieldset class="margin-bottom-sm">
                    <legend><p class="bg-primary">Location</p></legend>
                    <div class="row">
                        <!-- Start Location Form Input -->
                        <div class="col-md-6 form-group">
                            {!! Form::label('location_from', 'Start Location', ['class' => 'control-label']) !!}
                            {!! Form::textarea('location_from', null, ['class' => 'form-control', 'required' => 'required', 'rows' => '3', 'placeholder' => 'Generate from postal code']) !!}
                        </div>
                        <!-- End Location Form Input -->
                        <div class="col-md-6 form-group">
                            {!! Form::label('location_to', 'End Location', ['class' => 'control-label']) !!}
                            {!! Form::textarea('location_to', null, ['class' => 'form-control', 'required' => 'required', 'rows' => '3', 'placeholder' => 'Auto generate from postal code']) !!}
                        </div>
                    </div>
                </fieldset>

                <fieldset class="margin-bottom-sm">
                    <legend><p class="bg-primary">Particulars</p></legend>
                    <div class="row">
                        <!-- Senior Name Form Input -->
                        <div class="col-md-4 form-group">
                            {!! Form::label('elderly_name', 'Senior Name', ['class' => 'control-label']) !!}
                            {!! Form::text('elderly_name', null, ['class' => 'form-control', 'required' => 'required']) !!}
                        </div>
                        <!-- Senior's Next-of-Kin Name Form Input -->
                        <div class="col-md-4 form-group">
                            {!! Form::label('next_of_kin_name', 'Senior\'s Next-of-Kin Name', ['class' => 'control-label']) !!}
                            {!! Form::text('next_of_kin_name', null, ['class' => 'form-control', 'required' => 'required']) !!}
                        </div>
                        <!-- Senior's Next-of-Kin Contact Number Form Input -->
                        <div class="col-md-4 form-group">
                            {!! Form::label('next_of_kin_contact', 'Senior\'s Next-of-Kin Contact Number', ['class' => 'control-label']) !!}
                            {!! Form::tel('next_of_kin_contact', null, ['class' => 'form-control', 'required' => 'required', 'maxlength' => '8', 'pattern' => '^[0-9]+$', 'placeholder' => 'e.g. 67654321']) !!}
                        </div>
                    </div>
                </fieldset>

                <!-- Submit Button Form Input -->
                <div class="form-group text-center">
                    {!! Form::submit('Update activity', ['class' => 'btn btn-default btn-md']) !!}
                </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>

@endsection
