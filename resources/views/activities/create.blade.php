@extends('layouts.master')

@section('title', 'Add new activity')

@section('content')

<div class="container-fluid">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
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

            <div class="panel-group margin-bottom-md" id="accordion" role="tablist" aria-multiselectable="true">

                <div class="panel panel-default">
                    <div class="panel-heading" role="tab" id="heading-information">
                        <h4 class="panel-title">
                            <a role="button" data-toggle="collapse" href="#collapse-information" aria-expanded="true" aria-controls="collapse-information">
                                <strong><span class="glyphicon glyphicon-chevron-up"></span> Information</strong>
                            </a>
                        </h4>
                    </div>
                    <div id="collapse-information" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="heading-information">
                        <div class="panel-body">
                            <div class="row">
                                <!-- Centre Form Input -->
                                <div class="col-md-3 form-group">
                                    {!! Form::label('centre', 'For', ['class' => 'control-label']) !!}
                                    {!! Form::select('centre', $centreList, null, ['class' => 'form-control', 'required' => 'required']) !!}
                                </div>
                                <!-- Date To Start Form Input -->
                                <div class="col-md-3 form-group">
                                    {!! Form::label('date_to_start', 'Date To Start', ['class' => 'control-label']) !!}
                                    {!! Form::date('date_to_start', null, ['class' => 'form-control', 'required' => 'required', 'min' => Carbon\Carbon::now()->format('Y-m-d')]) !!}
                                </div>
                                <!-- Time To Start Form Input -->
                                <div class="col-md-3 form-group">
                                    {!! Form::label('time_to_start', 'Time To Start', ['class' => 'control-label']) !!}
                                    {!! Form::time('time_to_start', null, ['class' => 'form-control', 'required' => 'required']) !!}
                                </div>
                                <!-- Duration Form Input -->
                                <div class="col-md-3 form-group">
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
                                <strong><span class="glyphicon glyphicon-chevron-up"></span> Activity Location</strong>
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
                                        {!! Form::select('start_location', $startLocations, null, ['class' => 'form-control', 'required' => 'required']) !!}
                                        <span class="input-group-btn">
                                            <button class="btn btn-default" type="button" data-toggle="collapse" data-target="#collapse-start-loc" aria-expanded="false" aria-controls="collapse-start-loc">
                                                Not in list
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
                                                Not in list
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
                            <div class="collapse" id="collapse-end-loc">
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
                                <strong><span class="glyphicon glyphicon-chevron-up"></span> Senior Information</strong>
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
                                                Not in list
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
                                            {!! Form::text('senior_nric', null, ['class' => 'form-control', 'size' => '9', 'pattern' => '[S|T|F|G|s|t|f|g][0-9]{7}[a-z|A-Z]', 'placeholder' => 'e.g. S1234567Z']) !!}
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
                                        <!-- Senior Photo Form Input -->
                                        <div class="col-md-3 form-group">
                                            {!! Form::label('senior_photo', 'Senior Photo (optional)', ['class' => 'control-label']) !!}
                                            {!! Form::file('senior_photo', ['class' => 'form-control']) !!}
                                        </div>
                                    </div>
                                    <div class="row">
                                        <!-- Senior Languages Form Input -->
                                        <div class="col-md-4 form-group">
                                            {!! Form::label('senior_languages', 'Languages Spoken', ['class' => 'control-label']) !!}
                                            {!! Form::select('senior_languages[]', $seniorLanguages, null, ['class' => 'form-control', 'multiple' => 'multiple', 'id' => 'senior_languages']) !!}
                                        </div>
                                        <!-- Senior's Next-of-Kin Name Form Input -->
                                        <div class="col-md-4 form-group">
                                            {!! Form::label('senior_nok_name', 'Senior\'s Next-of-Kin Name', ['class' => 'control-label']) !!}
                                            {!! Form::text('senior_nok_name', null, ['class' => 'form-control']) !!}
                                        </div>
                                        <!-- Senior's Next-of-Kin Contact Number Form Input -->
                                        <div class="col-md-4 form-group">
                                            {!! Form::label('senior_nok_contact', 'Senior\'s Next-of-Kin Contact Number', ['class' => 'control-label']) !!}
                                            {!! Form::tel('senior_nok_contact', null, ['class' => 'form-control', 'maxlength' => '8', 'pattern' => '[0-9]{8}', 'placeholder' => 'e.g. 67654321']) !!}
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

@section('page-script')

<link rel="stylesheet" href="{{ asset('css/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('css/select2-bootstrap.min.css') }}">
<script src="{{ asset('js/select2.min.js') }}"></script>

<style>
    .select2-container { width: 100% !important; }
    .select2-search>input { width: 100% !important; }
    .select2-search { margin: 6px 0 !important; }
    .select2-container--bootstrap .select2-selection:focus {
        border-bottom-width: 2px;
        outline: none !important;
        border-color: #0054a0;
    }

    .select2-selection { font: inherit !important; }
    .select2-selection__rendered {
        font-size: initial !important;
        color: #666666 !important;
        padding-left: 0px !important;
    }
</style>

<script>
    $("#senior_languages").select2({
        theme: "bootstrap",
        placeholder: "e.g. English, Chinese",
        tags: true,
        tokenSeparators: [',', ' ']
    });

    $('#start_location').on('change', function() {
        var key = $(this).val();
        if(key == "others") {
            $('#collapse-start-loc').collapse('show');
        } else {
            $('#collapse-start-loc').collapse('hide');
        }
    });

    $('#collapse-start-loc').on('show.bs.collapse', function () {
        $('#start_location').val("others");
    });

    $('#collapse-start-loc').on('hide.bs.collapse', function () {
        $('#start_location').prop("selectedIndex", 0);
    });

    $('#end_location').on('change', function() {
        var key = $(this).val();
        if(key == "others") {
            $('#collapse-end-loc').collapse('show');
        } else {
            $('#collapse-end-loc').collapse('hide');
        }
    });

    $('#collapse-end-loc').on('show.bs.collapse', function () {
        $('#end_location').val("others");
    });

    $('#collapse-end-loc').on('hide.bs.collapse', function () {
        $('#end_location').prop("selectedIndex", 0);
    });

    $('#senior').on('change', function() {
        var key = $(this).val();
        if(key == "others") {
            $('#collapse-senior').collapse('show');
        } else {
            $('#collapse-senior').collapse('hide');
        }
    });

    $('#collapse-senior').on('show.bs.collapse', function () {
        $('#senior').val("others");
    });

    $('#collapse-senior').on('hide.bs.collapse', function () {
        $('#senior').prop("selectedIndex", 0);
    });

    $(document).ready(function() {
        if($('#start_location').val() == "others") { $('#collapse-start-loc').collapse('show'); }
        if($('#end_location').val() == "others") { $('#collapse-end-loc').collapse('show'); }
        if($('#senior').val() == "others") { $('#collapse-senior').collapse('show'); }
    });
</script>

@endsection