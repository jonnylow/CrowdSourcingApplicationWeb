@extends('layouts.master')

@section('title', 'Edit an Activity')

@section('content')

<div class="container-fluid margin-bottom-lg">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <h1>Edit an Activity</h1>

            @include('errors.list')

            {!! Form::model($activity, ['method' => 'PATCH', 'route' => ['activities.update', $activity->activity_id]]) !!}

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
                                        {!! Form::select('centre', $centreList, $activity->centre_id, ['class' => 'form-control', 'required']) !!}
                                    </div>
                                    <!-- Date Form Input -->
                                    <div class="col-md-5 form-group">
                                        {!! Form::label('date', 'Date', ['class' => 'control-label']) !!}
                                        <div class="inline-field">
                                            <div class="col-md-4">{!! Form::selectMonth('date_month', $activity->datetime_start->month, ['class' => 'form-control date-field', 'required']) !!}</div>
                                            <div class="col-md-4">{!! Form::text('date_day', $activity->datetime_start->day, ['class' => 'form-control date-field', 'required', 'min' => '1', 'max' => '31', 'placeholder' => 'Day']) !!}</div>
                                            <div class="col-md-4">{!! Form::text('date_year', $activity->datetime_start->year, ['class' => 'form-control date-field', 'required', 'min' => Carbon\Carbon::now()->year, 'placeholder' => 'Year']) !!}</div>
                                        </div>
                                    </div>
                                    <!-- Time To Start Form Input -->
                                    <div class="col-md-4 form-group">
                                        {!! Form::label('time', 'Time To Start (12-hour clock)', ['class' => 'control-label']) !!}
                                        <div class="inline-field">
                                            <div class="col-md-4">{!! Form::text('time_hour', $activity->datetime_start->format('h'), ['class' => 'form-control', 'required', 'min' => '1', 'max' => '12', 'placeholder' => 'Hour']) !!}</div>
                                            <div class="col-md-4">{!! Form::text('time_minute', $activity->datetime_start->format('i'), ['class' => 'form-control', 'required', 'min' => '0', 'max' => '59', 'placeholder' => 'Minute']) !!}</div>
                                            <div class="col-md-4">{!! Form::select('time_period', $timePeriodList, $activity->datetime_start->format('A'), ['class' => 'form-control', 'required']) !!}</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <!-- Duration Form Input -->
                                    <div class="col-md-3 form-group">
                                        {!! Form::label('duration', 'Expected Duration (hours, minutes)', ['class' => 'control-label']) !!}
                                        <div class="inline-field">
                                            <div class="col-md-6">{!! Form::text('duration_hour', $activity->durationHour(), ['class' => 'form-control duration-field', 'required', 'min' => '0', 'max' => '10', 'placeholder' => 'Hour']) !!}</div>
                                            <div class="col-md-6">{!! Form::text('duration_minute', $activity->durationMinute(), ['class' => 'form-control duration-field', 'required', 'min' => '0', 'max' => '59', 'placeholder' => 'Minute']) !!}</div>
                                        </div>
                                    </div>
                                    <!-- More Information Form Input -->
                                    <div class="col-md-9 form-group">
                                        {!! Form::label('more_information', 'More Information (optional)', ['class' => 'control-label']) !!}
                                        {!! Form::textarea('more_information', $activity->more_information, ['class' => 'form-control', 'rows' => '5', 'placeholder' => 'Optional']) !!}
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
                                        {!! Form::label('start_location', 'Branch', ['class' => 'control-label']) !!}
                                        <div class="input-group">
                                            {!! Form::select('start_location', $locationList, $activity->location_from_id, ['class' => 'form-control', 'required']) !!}
                                            <span class="input-group-btn"></span>
                                            <span class="input-group-btn">
                                                <button class="btn btn-default" type="button" data-toggle="collapse" data-target=".collapse-start-loc" aria-expanded="false" aria-controls="collapse-start-loc">
                                                    Add new location
                                                </button>
                                            </span>
                                        </div>
                                        <div class="collapse collapse-start-loc">
                                            <p class="help-block">Location will be saved when activity is added.</p>
                                        </div>
                                    </div>
                                    <!-- End Location Form Input -->
                                    <div class="col-md-6 form-group">
                                        {!! Form::label('end_location', 'Appointment Venue', ['class' => 'control-label']) !!}
                                        <div class="input-group">
                                            {!! Form::select('end_location', $locationList, $activity->location_to_id, ['class' => 'form-control', 'required']) !!}
                                            <span class="input-group-btn"></span>
                                            <span class="input-group-btn">
                                                <button class="btn btn-default" type="button" data-toggle="collapse" data-target=".collapse-end-loc" aria-expanded="false" aria-controls="collapse-end-loc">
                                                    Add new location
                                                </button>
                                            </span>
                                        </div>
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
                                                {!! Form::label('start_location_name', 'Branch Name', ['class' => 'control-label']) !!}
                                                {!! Form::text('start_location_name', null, ['class' => 'form-control', 'placeholder' => 'e.g. Henderson Home', 'onBlur' => 'javascript:{this.value = this.value.replace(/\w\S*/g, function(txt){return txt.charAt(0).toUpperCase() + txt.substr(1).toLowerCase();});}']) !!}
                                            </div>
                                            <!-- Start Location Postal Code Form Input -->
                                            <div class="col-md-6 form-group">
                                                {!! Form::label('start_postal', 'Branch Postal Code', ['class' => 'control-label']) !!}
                                                {!! Form::text('start_postal', null, ['class' => 'form-control', 'maxlength' => '6', 'pattern' => '[0-9]{6}', 'placeholder' => 'e.g. 123456']) !!}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="collapse collapse-end-loc">
                                    <div class="panel panel-default">
                                        <div class="panel-body">
                                            <!-- End Location Name Form Input -->
                                            <div class="col-md-6 form-group">
                                                {!! Form::label('end_location_name', 'Appointment Venue Name', ['class' => 'control-label']) !!}
                                                {!! Form::text('end_location_name', null, ['class' => 'form-control', 'placeholder' => 'e.g. Singapore General Hospital', 'onBlur' => 'javascript:{this.value = this.value.replace(/\w\S*/g, function(txt){return txt.charAt(0).toUpperCase() + txt.substr(1).toLowerCase();});}']) !!}
                                            </div>
                                            <!-- End Location Postal Code Form Input -->
                                            <div class="col-md-6 form-group">
                                                {!! Form::label('end_postal', 'Appointment Venue Postal Code', ['class' => 'control-label']) !!}
                                                {!! Form::text('end_postal', null, ['class' => 'form-control', 'maxlength' => '6', 'pattern' => '[0-9]{6}', 'placeholder' => 'e.g. 123456']) !!}
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
                                <!-- Senior Name and NRIC Form Input -->
                                <div class="col-md-8 col-md-offset-2 form-group">
                                    {!! Form::label('senior', 'Senior Name & NRIC', ['class' => 'control-label']) !!}
                                    <div class="input-group">
                                        {!! Form::select('senior', $seniorList, $activity->elderly_id, ['class' => 'form-control', 'required']) !!}
                                        <span class="input-group-btn"></span>
                                        <span class="input-group-btn">
                                            <button class="btn btn-default" type="button" data-toggle="collapse" data-target=".collapse-senior" aria-expanded="false" aria-controls="collapse-senior">
                                                Add new senior
                                            </button>
                                        </span>
                                    </div>
                                    <div class="collapse collapse-senior">
                                        <p class="help-block">Senior's information will be saved when activity is added.</p>
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
                                                {!! Form::text('senior_nric', null, ['class' => 'form-control', 'size' => '9', 'pattern' => '^[STFGstfg][0-9]{7}[a-zA-Z]', 'placeholder' => 'e.g. S1234567Z', 'onBlur' => 'javascript:{this.value = this.value.toUpperCase(); }']) !!}
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
                                                {!! Form::text('senior_birth_year', null, ['class' => 'form-control', 'required', 'min' => '1900', 'placeholder' => 'e.g. 1965']) !!}
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
                                                {!! Form::label('senior_medical', 'Medical Condition (optional)', ['class' => 'control-label']) !!}
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
                    {!! Form::submit('Update activity', ['class' => 'btn btn-primary btn-lg']) !!}
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
    .input-group-btn .btn {
        border-width: 1px;
    }

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

    .selectize-input > input {
        color: #acb6c0;
        padding: 2px 0px !important;
    }

    .selectize-input.focus { border-color: #2C3E50; }
    .has-error .selectize-input, .has-error .selectize-input.focus { border-color: #e74c3c; }
    .has-success .selectize-input, .has-success .selectize-input.focus { border-color: #18bc9c; }
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
        createOnBlur: true,
        placeholder: 'e.g. English, Chinese',
        create: function(input) {
            if(/^[a-zA-Z]+$/.test(input)) {
                return {
                    value: input.charAt(0).toUpperCase() + input.slice(1).toLowerCase(),
                    text: input.charAt(0).toUpperCase() + input.slice(1).toLowerCase()
                }
            } else {
                return {
                    value: "",
                    text: ""
                }
            }
        }
    });

    // Validate date-field inputs
    $(document).on('change', '.date-field', function () {
        if($('input[name="date_year"]').valid()) {
            var dateMonth = $('select[name="date_month"]').val();
            var dateYear = $('input[name="date_year"]').val();
            var numOfDays = 32 - new Date(dateYear, dateMonth - 1, 32).getDate();

            $('input[name="date_day"]').rules('remove');
            $('input[name="date_day"]').rules('add', {
                required: true,
                digits: true,
                rangelength: [1, 2],
                min: 1,
                max: numOfDays,
                messages: {
                    required: "Day is required.",
                    digits: "Day must be a number.",
                    rangelength: "Day must be 1 or 2 digits.",
                    min: "Day must be between 1 to " + numOfDays + ".",
                    max: "Day must be between 1 to " + numOfDays + "."
                }
            });
        }
        $('input[name="date_day"]').valid();
    });

    // Validate duration_hour input
    $(document).on('change', 'input[name="duration_hour"]', function () {
        var durationHour = $('input[name="duration_hour"]').val();

        $('input[name="duration_minute"]').rules('remove');
        if(durationHour == 0) {
            $('input[name="duration_minute"]').rules('add', {
                required: true,
                rangelength: [1, 2],
                min: 30,
                max: 59,
                messages: {
                    required: "Minute is required.",
                    rangelength: "Minute must be 1 or 2 digits.",
                    min: "Minute must be between 30 to 59.",
                    max: "Minute must be between 30 to 59."
                }
            });
        } else if(durationHour > 0) {
            $('input[name="duration_minute"]').rules('add', {
                required: true,
                rangelength: [1, 2],
                min: 0,
                max: 59,
                messages: {
                    required: "Minute is required.",
                    rangelength: "Minute must be 1 or 2 digits.",
                    min: "Minute must be between 0 to 59.",
                    max: "Minute must be between 0 to 59."
                }
            });
        }
        $('input[name="duration_minute"]').valid();
    });

    // Validate duration_minute input
    $(document).on('change', 'input[name="duration_minute"]', function () {
        var durationMinute = $('input[name="duration_minute"]').val();

        $('input[name="duration_hour"]').rules('remove');
        if(durationMinute == 0) {
            $('input[name="duration_hour"]').rules('add', {
                required: true,
                rangelength: [1, 2],
                min: 1,
                max: 10,
                messages: {
                    required: "Hour is required.",
                    rangelength: "Hour must be 1 or 2 digits.",
                    min: "Hour must be between 1 to 10.",
                    max: "Hour must be between 1 to 10."
                }
            });
        } else if(durationMinute > 0) {
            $('input[name="duration_hour"]').rules('add', {
                required: true,
                rangelength: [1, 2],
                min: 0,
                max: 10,
                messages: {
                    required: "Hour is required.",
                    rangelength: "Hour must be 1 or 2 digits.",
                    min: "Hour must be between 0 to 10.",
                    max: "Hour must be between 0 to 10."
                }
            });
        }
        $('input[name="duration_hour"]').valid();
    });

    $('#start_location').on('change', function() {
        var key = $(this).val();
        if(key == "others") {
            $('.collapse-start-loc').collapse('show');
        } else {
            $('.collapse-start-loc').collapse('hide');
        }
    });

    $('button[aria-controls="collapse-start-loc"], .collapse-start-loc').on('click hide.bs.collapse', function (e) {
        var value = $('#start_location').val();
        if (e.type === 'hide' && value === "others") {
            $('#start_location').prop("selectedIndex", 0);
        }
    });

    $('.collapse-start-loc').on('show.bs.collapse', function () {
        $('#start_location').val("others");
        $('button[aria-controls="collapse-start-loc"]').html("Cancel adding location");
    });

    $('.collapse-start-loc').on('hide.bs.collapse', function () {
        $('button[aria-controls="collapse-start-loc"]').html("Add new location");
        $('#start_location_name').val('');
        $('#start_postal').val('');
    });

    $('#end_location').on('change', function() {
        var key = $(this).val();
        if(key == "others") {
            $('.collapse-end-loc').collapse('show');
        } else {
            $('.collapse-end-loc').collapse('hide');
        }
    });

    $('button[aria-controls="collapse-end-loc"], .collapse-end-loc').on('click hide.bs.collapse', function (e) {
        var value = $('#end_location').val();
        if (e.type === 'hide' && value === "others") {
            $('#end_location').prop("selectedIndex", 0);
        }
    });

    $('.collapse-end-loc').on('show.bs.collapse', function () {
        $('#end_location').val("others");
        $('button[aria-controls="collapse-end-loc"]').html("Cancel adding location");
    });

    $('.collapse-end-loc').on('hide.bs.collapse', function () {
        $('button[aria-controls="collapse-end-loc"]').html("Add new location");
        $('#end_location_name').val('');
        $('#end_postal').val('');
    });

    $('#senior').on('change', function() {
        var key = $(this).val();
        if(key == "others") {
            $('.collapse-senior').collapse('show');
        } else {
            $('.collapse-senior').collapse('hide');
        }
    });

    $('button[aria-controls="collapse-senior"], .collapse-senior').on('click hide.bs.collapse', function (e) {
        var value = $('#senior').val();
        if (e.type === 'hide' && value === "others") {
            $('#senior').prop("selectedIndex", 0);
        }
    });

    $('.collapse-senior').on('show.bs.collapse', function () {
        $('#senior').val("others");
        $('button[aria-controls="collapse-senior"]').html("Cancel adding senior");
    });

    $('.collapse-senior').on('hide.bs.collapse', function () {
        $('button[aria-controls="collapse-senior"]').html("Add new senior");
        $('#senior_nric').val('');
        $('#senior_name').val('');
        $('#senior_gender').prop("selectedIndex", 0);
        $('#senior_birth_year').val('');
        $('#languages')[0].selectize.clear();
        $('#senior_nok_name').val('');
        $('#senior_nok_contact').val('');
        $('#senior_medical').val('');
    });

    $(document).ready(function() {
        if($('#start_location').val() == "others") { $('.collapse-start-loc').collapse('show'); }
        if($('#end_location').val() == "others") { $('.collapse-end-loc').collapse('show'); }
        if($('#senior').val() == "others") { $('.collapse-senior').collapse('show'); }
    });
</script>

@endsection
