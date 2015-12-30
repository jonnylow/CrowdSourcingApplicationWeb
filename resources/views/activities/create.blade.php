@extends('layouts.master')

@section('title', 'Add new activity')

@section('content')

<div class="container-fluid">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <h1>Add new activity</h1>
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

            {!! Form::open(['route' => 'activities.store']) !!}
            {!! Form::hidden('start_location_lat', null) !!}
            {!! Form::hidden('start_location_lng', null) !!}
            {!! Form::hidden('end_location_lat', null) !!}
            {!! Form::hidden('end_location_lng', null) !!}

            <div class="panel-group margin-bottom-md" id="accordion" role="tablist" aria-multiselectable="true">

                <div class="panel panel-default">
                    <div class="panel-heading" role="tab" id="heading-information">
                        <h4 class="panel-title">
                            <a role="button" data-toggle="collapse" href="#collapse-information" aria-expanded="true" aria-controls="collapse-information">
                                <strong><span class="glyphicon glyphicon-calendar"></span> Information</strong>
                            </a>
                        </h4>
                    </div>
                    <div id="collapse-information" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="heading-information">
                        <div class="panel-body">
                            <div class="row">
                                <!-- Date To Start Form Input -->
                                <div class="col-md-4 form-group">
                                    {!! Form::label('date_to_start', 'Date To Start', ['class' => 'control-label']) !!}
                                    {!! Form::date('date_to_start', null, ['class' => 'form-control', 'required' => 'required', 'min' => Carbon\Carbon::now()->format('Y-m-d')]) !!}
                                </div>
                                <!-- Time To Start Form Input -->
                                <div class="col-md-4 form-group">
                                    {!! Form::label('time_to_start', 'Time To Start', ['class' => 'control-label']) !!}
                                    {!! Form::time('time_to_start', null, ['class' => 'form-control', 'required' => 'required']) !!}
                                </div>
                                <!-- Duration Form Input -->
                                <div class="col-md-4 form-group">
                                    {!! Form::label('duration', 'Expected Duration (in hours)', ['class' => 'control-label']) !!}
                                    {!! Form::select('duration', $expectedDuration, null, ['class' => 'form-control', 'required' => 'required']) !!}
                                </div>
                            </div>
                            <!-- More Information Form Input -->
                            <div class="form-group">
                                {!! Form::label('more_information', 'More Information', ['class' => 'control-label']) !!}
                                {!! Form::textarea('more_information', null, ['class' => 'form-control', 'rows' => '5', 'placeholder' => 'Optional']) !!}
                            </div>
                        </div>
                    </div>
                </div>

                <div class="panel panel-default">
                    <div class="panel-heading" role="tab" id="heading-location">
                        <h4 class="panel-title">
                            <a role="button" data-toggle="collapse" href="#collapse-location" aria-expanded="true" aria-controls="collapse-location">
                                <strong><span class="glyphicon glyphicon-map-marker"></span> Activity Location</strong>
                            </a>
                        </h4>
                    </div>
                    <div id="collapse-location" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="heading-location">
                        <div class="panel-body">
                            <div class="row">
                                <!-- Start Location Form Input -->
                                <div class="col-md-6 form-group">
                                    {!! Form::label('start_location', 'Start Location', ['class' => 'control-label']) !!}
                                    <div class="input-group">
                                        {!! Form::select('start_location', $seniorCentreList, null, ['class' => 'form-control', 'required' => 'required']) !!}
                                        <span class="input-group-btn">
                                            <button class="btn btn-default" type="button" data-toggle="collapse" data-target="#collapse-start-loc" aria-expanded="false" aria-controls="collapse-start-loc">
                                                Not in this list
                                            </button>
                                        </span>
                                    </div>
                                </div>
                                <!-- End Location Form Input -->
                                <div class="col-md-6 form-group">
                                    {!! Form::label('end_location', 'End Location', ['class' => 'control-label']) !!}
                                    <div class="input-group">
                                        {!! Form::select('end_location', $endLocations, null, ['class' => 'form-control', 'required' => 'required']) !!}
                                        <span class="input-group-btn">
                                            <button class="btn btn-default" type="button" data-toggle="collapse" data-target="#collapse-end-loc" aria-expanded="false" aria-controls="collapse-end-loc">
                                                Not in this list
                                            </button>
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <div class="collapse" id="collapse-start-loc">
                                <div class="panel panel-default">
                                    <div class="panel-body">
                                        <!-- Start Location Name Form Input -->
                                        <div class="col-md-6 form-group">
                                            {!! Form::label('start_location_name', 'Start Location Name', ['class' => 'control-label']) !!}
                                            {!! Form::text('start_location_name', null, ['class' => 'form-control', 'required' => 'required', 'placeholder' => 'e.g. Henderson Home']) !!}
                                        </div>
                                        <!-- Start Location Postal Code Form Input -->
                                        <div class="col-md-6 form-group">
                                            {!! Form::label('start_postal', 'Start Location Postal Code', ['class' => 'control-label']) !!}
                                            {!! Form::number('start_postal', null, ['class' => 'form-control', 'required' => 'required', 'maxlength' => '6', 'pattern' => '[0-9]{6}', 'placeholder' => 'e.g. 123456']) !!}
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="collapse" id="collapse-end-loc">
                                <div class="panel panel-default">
                                    <div class="panel-body">
                                        <!-- End Location Name Form Input -->
                                        <div class="col-md-6 form-group">
                                            {!! Form::label('end_location_name', 'End Location Name', ['class' => 'control-label']) !!}
                                            {!! Form::text('end_location_name', null, ['class' => 'form-control', 'required' => 'required', 'placeholder' => 'e.g. Singapore General Hospital']) !!}
                                        </div>
                                        <!-- End Location Postal Code Form Input -->
                                        <div class="col-md-6 form-group">
                                            {!! Form::label('end_postal', 'End Location Postal Code', ['class' => 'control-label']) !!}
                                            {!! Form::number('end_postal', null, ['class' => 'form-control', 'required' => 'required', 'maxlength' => '6', 'pattern' => '[0-9]{6}', 'placeholder' => 'e.g. 123456']) !!}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="panel panel-default">
                    <div class="panel-heading" role="tab" id="heading-senior-all">
                        <h4 class="panel-title">
                            <a role="button" data-toggle="collapse" href="#collapse-senior-all" aria-expanded="true" aria-controls="collapse-senior-all">
                                <strong><span class="glyphicon glyphicon-user"></span> Senior Information</strong>
                            </a>
                        </h4>
                    </div>
                    <div id="collapse-senior-all" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="heading-senior-all">
                        <div class="panel-body">
                            <!-- Duration Form Input -->
                            <div class="col-md-8 col-md-offset-2 form-group">
                                {!! Form::label('senior', 'Senior NRIC & Name', ['class' => 'control-label']) !!}
                                <div class="input-group">
                                    {!! Form::select('senior', $seniorList, null, ['class' => 'form-control', 'required' => 'required']) !!}
                                    <span class="input-group-btn">
                                            <button class="btn btn-default" type="button" data-toggle="collapse" data-target="#collapse-senior" aria-expanded="false" aria-controls="collapse-senior">
                                                Not in this list
                                            </button>
                                        </span>
                                </div>
                            </div>
                        </div>

                        <div class="collapse" id="collapse-senior">
                            <div class="panel panel-default">
                                <div class="panel-body">
                                    <div class="row">
                                        <!-- Senior NRIC Form Input -->
                                        <div class="col-md-3 form-group">
                                            {!! Form::label('senior_nric', 'Senior NRIC', ['class' => 'control-label']) !!}
                                            {!! Form::text('senior_nric', null, ['class' => 'form-control', 'required' => 'required', 'size' => '9', 'pattern' => '[S|T|F|G|s|t|f|g][0-9]{7}[a-z|A-Z]', 'placeholder' => 'e.g. S1234567Z']) !!}
                                        </div>
                                        <!-- Senior Name Form Input -->
                                        <div class="col-md-4 form-group">
                                            {!! Form::label('senior_name', 'Senior Name', ['class' => 'control-label']) !!}
                                            {!! Form::text('senior_name', null, ['class' => 'form-control', 'required' => 'required']) !!}
                                        </div>
                                        <!-- Senior Gender Form Input -->
                                        <div class="col-md-2 form-group">
                                            {!! Form::label('senior_gender', 'Senior Gender', ['class' => 'control-label']) !!}
                                            {!! Form::select('senior_gender', ['M', 'F'], null, ['class' => 'form-control', 'required' => 'required']) !!}
                                        </div>
                                        <!-- Senior Gender Form Input -->
                                        <div class="col-md-3 form-group">
                                            {!! Form::label('senior_photo', 'Senior Photo', ['class' => 'control-label']) !!}
                                            {!! Form::file('senior_photo', ['class' => 'form-control', 'required' => 'required']) !!}
                                        </div>
                                    </div>
                                    <div class="row">
                                        <!-- Senior Languages Form Input -->
                                        <div class="col-md-4 form-group">
                                            {!! Form::label('senior_languages', 'Languages Spoken', ['class' => 'control-label']) !!}
                                            {!! Form::text('senior_languages', null, ['class' => 'form-control', 'required' => 'required', 'placeholder' => 'e.g. English, Chinese']) !!}
                                        </div>
                                        <!-- Senior's Next-of-Kin Name Form Input -->
                                        <div class="col-md-4 form-group">
                                            {!! Form::label('senior_nok_name', 'Senior\'s Next-of-Kin Name', ['class' => 'control-label']) !!}
                                            {!! Form::text('senior_nok_name', null, ['class' => 'form-control', 'required' => 'required']) !!}
                                        </div>
                                        <!-- Senior's Next-of-Kin Contact Number Form Input -->
                                        <div class="col-md-4 form-group">
                                            {!! Form::label('senior_nok_contact', 'Senior\'s Next-of-Kin Contact Number', ['class' => 'control-label']) !!}
                                            {!! Form::tel('senior_nok_contact', null, ['class' => 'form-control', 'required' => 'required', 'maxlength' => '8', 'pattern' => '[0-9]{8}', 'placeholder' => 'e.g. 67654321']) !!}
                                        </div>
                                    </div>
                                    <!-- Medical Condition Form Input -->
                                    <div class="form-group">
                                        {!! Form::label('senior_medical', 'Medical Condition', ['class' => 'control-label']) !!}
                                        {!! Form::textarea('senior_medical', null, ['class' => 'form-control', 'rows' => '5', 'placeholder' => 'Optional']) !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
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
