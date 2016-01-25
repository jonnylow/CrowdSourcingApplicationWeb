@extends('layouts.master')

@section('title', 'Add new Activity')

@section('content')

<div class="container-fluid margin-bottom-lg">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <h1>Add new Activity</h1>

            @include('errors.list')

            {!! Form::open(['route' => 'activities.store']) !!}

                <div class="panel-group margin-bottom-md" id="accordion" role="tablist" aria-multiselectable="true">

                    <div class="panel panel-default">
                        <div class="panel-heading" role="tab" id="heading-information">
                            <h4 class="panel-title">
                                <a role="button" data-toggle="collapse" href="#collapse-information" aria-expanded="true" aria-controls="collapse-information">
                                    <span class="fa fa-fw fa-calendar"></span>
                                    <strong>Information</strong>
                                    <span class="icon-arrow fa fa-lg fa-chevron-up"></span>
                                </a>
                            </h4>
                        </div>
                        <div id="collapse-information" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="heading-information">
                            <div class="panel-body">
                                <div class="row">
                                    <!-- Centre Form Input -->
                                    <div class="col-md-3 form-group">
                                        {!! Form::label('centre', 'For', ['class' => 'control-label']) !!}
                                        {!! Form::select('centre', $centreList, null, ['class' => 'form-control', 'required']) !!}
                                    </div>
                                    <!-- Date Form Input -->
                                    <div class="col-md-5 form-group">
                                        {!! Form::label('date', 'Date', ['class' => 'control-label']) !!}
                                        <div class="inline-field">
                                            <div class="col-md-4">{!! Form::selectMonth('date_month', null, ['class' => 'form-control date-field', 'required']) !!}</div>
                                            <div class="col-md-4">{!! Form::number('date_day', null, ['class' => 'form-control date-field', 'required', 'min' => '1', 'max' => '31', 'placeholder' => 'Day']) !!}</div>
                                            <div class="col-md-4">{!! Form::number('date_year', null, ['class' => 'form-control date-field', 'required', 'min' => Carbon\Carbon::now()->year, 'placeholder' => 'Year']) !!}</div>
                                        </div>
                                    </div>
                                    <!-- Time To Start Form Input -->
                                    <div class="col-md-4 form-group">
                                        {!! Form::label('time', 'Time To Start (hh:mm AM/PM)', ['class' => 'control-label']) !!}
                                        <div class="inline-field">
                                            <div class="col-md-4">{!! Form::number('time_hour', null, ['class' => 'form-control', 'required', 'min' => '1', 'max' => '12', 'placeholder' => 'Hour']) !!}</div>
                                            <div class="col-md-4">{!! Form::number('time_minute', null, ['class' => 'form-control', 'required', 'min' => '0', 'max' => '59', 'placeholder' => 'Minute']) !!}</div>
                                            <div class="col-md-4">{!! Form::select('time_period', $timePeriodList, null, ['class' => 'form-control', 'required']) !!}</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <!-- Duration Form Input -->
                                    <div class="col-md-3 form-group">
                                        {!! Form::label('duration', 'Expected Duration (hours, minutes)', ['class' => 'control-label']) !!}
                                        <div class="inline-field">
                                            <div class="col-md-6">{!! Form::number('duration_hour', null, ['class' => 'form-control duration-field', 'required', 'min' => '0', 'max' => '10', 'placeholder' => 'Hour']) !!}</div>
                                            <div class="col-md-6">{!! Form::number('duration_minute', null, ['class' => 'form-control duration-field', 'required', 'min' => '0', 'max' => '59', 'placeholder' => 'Minute']) !!}</div>
                                        </div>
                                    </div>
                                    <!-- More Information Form Input -->
                                    <div class="col-md-9 form-group">
                                        {!! Form::label('more_information', 'More Information', ['class' => 'control-label']) !!}
                                        {!! Form::textarea('more_information', null, ['class' => 'form-control', 'rows' => '5', 'placeholder' => 'Optional']) !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="panel panel-default">
                        <div class="panel-heading" role="tab" id="heading-location">
                            <h4 class="panel-title">
                                <a role="button" data-toggle="collapse" href="#collapse-location" aria-expanded="true" aria-controls="collapse-location">
                                    <span class="fa fa-fw fa-map-marker"></span>
                                    <strong>Activity Location</strong>
                                    <span class="icon-arrow fa fa-lg fa-chevron-up"></span>
                                </a>
                            </h4>
                        </div>
                        <div id="collapse-location" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="heading-location">
                            <div class="panel-body">
                                <div class="row">
                                    <!-- Start Location Form Input -->
                                    <div class="col-md-6 form-group">
                                        {!! Form::label('start_location', 'Start Location', ['class' => 'control-label']) !!}
                                        {!! Form::select('start_location', $startLocations, null, ['class' => 'form-control', 'required']) !!}
                                        <div class="collapse collapse-start-loc">
                                            <p class="help-block">Location will be saved when activity is added.</p>
                                        </div>
                                    </div>
                                    <!-- End Location Form Input -->
                                    <div class="col-md-6 form-group">
                                        {!! Form::label('end_location', 'End Location', ['class' => 'control-label']) !!}
                                        {!! Form::select('end_location', $endLocations, null, ['class' => 'form-control', 'required']) !!}
                                        <div class="collapse collapse-end-loc">
                                            <p class="help-block">Location will be saved when activity is added.</p>
                                        </div>
                                    </div>
                                </div>

                                <div class="collapse collapse-start-loc">
                                    <div class="panel panel-default">
                                        <div class="panel-body">
                                            <!-- Start Location Name Form Input -->
                                            <div class="col-md-6 form-group">
                                                {!! Form::label('start_location_name', 'Start Location Name', ['class' => 'control-label']) !!}
                                                {!! Form::text('start_location_name', null, ['class' => 'form-control', 'placeholder' => 'e.g. Henderson Home']) !!}
                                            </div>
                                            <!-- Start Location Postal Code Form Input -->
                                            <div class="col-md-6 form-group">
                                                {!! Form::label('start_postal', 'Start Location Postal Code', ['class' => 'control-label']) !!}
                                                {!! Form::number('start_postal', null, ['class' => 'form-control', 'maxlength' => '6', 'pattern' => '[0-9]{6}', 'placeholder' => 'e.g. 123456']) !!}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="collapse collapse-end-loc">
                                    <div class="panel panel-default">
                                        <div class="panel-body">
                                            <!-- End Location Name Form Input -->
                                            <div class="col-md-6 form-group">
                                                {!! Form::label('end_location_name', 'End Location Name', ['class' => 'control-label']) !!}
                                                {!! Form::text('end_location_name', null, ['class' => 'form-control', 'placeholder' => 'e.g. Singapore General Hospital']) !!}
                                            </div>
                                            <!-- End Location Postal Code Form Input -->
                                            <div class="col-md-6 form-group">
                                                {!! Form::label('end_postal', 'End Location Postal Code', ['class' => 'control-label']) !!}
                                                {!! Form::number('end_postal', null, ['class' => 'form-control', 'maxlength' => '6', 'pattern' => '[0-9]{6}', 'placeholder' => 'e.g. 123456']) !!}
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
                                    <span class="fa fa-fw fa-user"></span>
                                    <strong>Senior Information</strong>
                                    <span class="icon-arrow fa fa-lg fa-chevron-up"></span>
                                </a>
                            </h4>
                        </div>
                        <div id="collapse-senior-all" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="heading-senior-all">
                            <div class="panel-body">
                                <!-- Senior NRIC and Name Form Input -->
                                <div class="col-md-8 col-md-offset-2 form-group">
                                    {!! Form::label('senior', 'Senior NRIC & Name', ['class' => 'control-label']) !!}
                                    {!! Form::select('senior', $seniorList, null, ['class' => 'form-control', 'required']) !!}
                                    <div class="collapse collapse-senior">
                                        <p class="help-block">Senior information will be saved when activity is added.</p>
                                    </div>
                                </div>
                            </div>

                            <div class="collapse collapse-senior">
                                <div class="panel panel-default">
                                    <div class="panel-body">
                                        <div class="row">
                                            <!-- Senior NRIC Form Input -->
                                            <div class="col-md-3 form-group">
                                                {!! Form::label('senior_nric', 'Senior NRIC', ['class' => 'control-label']) !!}
                                                {!! Form::text('senior_nric', null, ['class' => 'form-control', 'size' => '9', 'pattern' => '^[STFGstfg][0-9]{7}[a-zA-Z]', 'placeholder' => 'e.g. S1234567Z']) !!}
                                            </div>
                                            <!-- Senior Name Form Input -->
                                            <div class="col-md-4 form-group">
                                                {!! Form::label('senior_name', 'Senior Name', ['class' => 'control-label']) !!}
                                                {!! Form::text('senior_name', null, ['class' => 'form-control']) !!}
                                            </div>
                                            <!-- Senior Gender Form Input -->
                                            <div class="col-md-2 form-group">
                                                {!! Form::label('senior_gender', 'Senior Gender', ['class' => 'control-label']) !!}
                                                {!! Form::select('senior_gender', $genderList, null, ['class' => 'form-control']) !!}
                                            </div>
                                            <!-- Senior Birth Year Form Input -->
                                            <div class="col-md-3 form-group">
                                                {!! Form::label('senior_birth_year', 'Birth Year', ['class' => 'control-label']) !!}
                                                {!! Form::number('senior_birth_year', null, ['class' => 'form-control', 'required', 'min' => '1900', 'placeholder' => 'e.g. 1965']) !!}
                                            </div>

                                        </div>
                                        <div class="row">
                                            <!-- Senior Languages Form Input -->
                                            <div class="col-md-4 form-group">
                                                {!! Form::label('languages[]', 'Languages Spoken', ['class' => 'control-label']) !!}
                                                {!! Form::select('languages[]', $seniorLanguages, null, ['class' => 'form-control', 'id' => 'languages', 'multiple']) !!}
                                            </div>
                                            <!-- Next-of-Kin Name Form Input -->
                                            <div class="col-md-4 form-group">
                                                {!! Form::label('senior_nok_name', 'Next-of-Kin Name', ['class' => 'control-label']) !!}
                                                {!! Form::text('senior_nok_name', null, ['class' => 'form-control']) !!}
                                            </div>
                                            <!-- Next-of-Kin Contact Number Form Input -->
                                            <div class="col-md-4 form-group">
                                                {!! Form::label('senior_nok_contact', 'Next-of-Kin Contact Number', ['class' => 'control-label']) !!}
                                                {!! Form::tel('senior_nok_contact', null, ['class' => 'form-control', 'maxlength' => '8', 'pattern' => '^[689][0-9]{7}', 'placeholder' => 'e.g. 67654321']) !!}
                                            </div>
                                        </div>
                                        <div class="row">
                                            <!-- Medical Condition Form Input -->
                                            <div class="col-md-12 form-group">
                                                {!! Form::label('senior_medical', 'Medical Condition', ['class' => 'control-label']) !!}
                                                {!! Form::textarea('senior_medical', null, ['class' => 'form-control', 'rows' => '5', 'placeholder' => 'Optional']) !!}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                <!-- Submit Button Form Input -->
                <div class="form-group text-center">
                    {!! Form::submit('Add activity', ['class' => 'btn btn-primary btn-lg']) !!}
                </div>

            {!! Form::close() !!}
        </div>
    </div>
</div>

@endsection

@section('page-script')

{!! $validator !!}
<link rel="stylesheet" href="{{ asset('css/selectize.bootstrap3.css') }}">
<script type="text/javascript" src="{{ asset('js/selectize.min.js') }}"></script>

<style>
    .inline-field div:first-of-type {
        padding-left: 0px;
        padding-right: 5px;
    }
    .inline-field div:last-of-type {
        padding-left: 5px;
        padding-right: 0px;
    }
    .inline-field div:not(:first-of-type):not(:last-of-type) {
        padding-left: 5px;
        padding-right: 5px;
    }
    .form-control.selectize-control { height: 46px !important; }
    .selectize-input {
        min-height: 46px !important;
        padding: 11px 15px 5px !important;
        box-shadow: none !important;
        border: 2px solid #dce4ec;
    }
    .selectize-input.focus { border-color: #2C3E50; }
    .has-error .selectize-input, .has-error .selectize-input.focus { border-color: #e74c3c; }
    .has-success .selectize-input, .has-success .selectize-input.focus { border-color: #18bc9c; }
    .selectize-input > input { padding: 2px 0px !important; }
    ::-webkit-input-placeholder { color: #acb6c0; }
    :-moz-placeholder { color: #acb6c0; }
    ::-moz-placeholder { color: #acb6c0; }
    :-ms-input-placeholder { color: #acb6c0; }
</style>

<script>
    $("#languages").selectize({
        plugins: ['restore_on_backspace', 'remove_button'],
        delimiter: ',',
        persist: false,
        create: true,
        createOnBlur: true,
        placeholder: 'e.g. English, Chinese'
    });

    $('#start_location').on('change', function() {
        var key = $(this).val();
        if(key == "others") {
            $('.collapse-start-loc').collapse('show');
        } else {
            $('.collapse-start-loc').collapse('hide');
        }
    });

    $('.collapse-start-loc').on('show.bs.collapse', function () {
        $('#start_location').val("others");
    });

    $('.collapse-start-loc').on('hide.bs.collapse', function () {
        $('#start_location').prop("selectedIndex", 0);
    });

    $('#end_location').on('change', function() {
        var key = $(this).val();
        if(key == "others") {
            $('.collapse-end-loc').collapse('show');
        } else {
            $('.collapse-end-loc').collapse('hide');
        }
    });

    $('.collapse-end-loc').on('show.bs.collapse', function () {
        $('#end_location').val("others");
    });

    $('.collapse-end-loc').on('hide.bs.collapse', function () {
        $('#end_location').prop("selectedIndex", 0);
    });

    $('#senior').on('change', function() {
        var key = $(this).val();
        if(key == "others") {
            $('.collapse-senior').collapse('show');
        } else {
            $('.collapse-senior').collapse('hide');
        }
    });

    $('.collapse-senior').on('show.bs.collapse', function () {
        $('#senior').val("others");
    });

    $('.collapse-senior').on('hide.bs.collapse', function () {
        $('#senior').prop("selectedIndex", 0);
    });

    $(document).ready(function() {
        if($('#start_location').val() == "others") { $('.collapse-start-loc').collapse('show'); }
        if($('#end_location').val() == "others") { $('.collapse-end-loc').collapse('show'); }
        if($('#senior').val() == "others") { $('.collapse-senior').collapse('show'); }
    });
</script>

@endsection