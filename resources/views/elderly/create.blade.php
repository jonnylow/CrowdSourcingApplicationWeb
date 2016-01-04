@extends('layouts.master')

@section('title', 'Add new senior')

@section('content')

<div class="container-fluid">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <h1>Add new senior</h1>

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

            {!! Form::open(['route' => 'elderly.store']) !!}

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
                                <div class="col-md-4 form-group">
                                    {!! Form::label('centre', 'For', ['class' => 'control-label']) !!}
                                    {!! Form::select('centre', $centreList, null, ['class' => 'form-control', 'required' => 'required']) !!}
                                </div>
                                <!-- Senior NRIC Form Input -->
                                <div class="col-md-3 form-group">
                                    {!! Form::label('nric', 'NRIC', ['class' => 'control-label']) !!}
                                    {!! Form::text('nric', null, ['class' => 'form-control', 'required' => 'required', 'size' => '9', 'pattern' => '[S|T|F|G|s|t|f|g][0-9]{7}[a-z|A-Z]', 'placeholder' => 'e.g. S1234567Z']) !!}
                                </div>
                                <!-- Senior Name Form Input -->
                                <div class="col-md-4 form-group">
                                    {!! Form::label('name', 'Name', ['class' => 'control-label']) !!}
                                    {!! Form::text('name', null, ['class' => 'form-control', 'required' => 'required']) !!}
                                </div>
                                <!-- Senior Gender Form Input -->
                                <div class="col-md-1 form-group">
                                    {!! Form::label('gender', 'Gender', ['class' => 'control-label']) !!}
                                    {!! Form::select('gender', $genderList, null, ['class' => 'form-control', 'required' => 'required']) !!}
                                </div>
                            </div>
                            <div class="row">
                                <!-- Senior Languages Form Input -->
                                <div class="col-md-6 form-group">
                                    {!! Form::label('languages', 'Languages Spoken', ['class' => 'control-label']) !!}
                                    {!! Form::select('languages[]', $languages, null, ['class' => 'form-control', 'required' => 'required', 'multiple' => 'multiple', 'id' => 'senior_languages']) !!}
                                </div>
                                <!-- Senior Photo Form Input -->
                                <div class="col-md-6 form-group">
                                    {!! Form::label('photo', 'Photo', ['class' => 'control-label']) !!}
                                    {!! Form::file('photo', ['class' => 'form-control']) !!}
                                </div>
                            </div>

                            <!-- Medical Condition Form Input -->
                            <div class="form-group">
                                {!! Form::label('medical_condition', 'Medical Condition', ['class' => 'control-label']) !!}
                                {!! Form::textarea('medical_condition', null, ['class' => 'form-control', 'rows' => '5', 'placeholder' => 'Optional']) !!}
                            </div>
                        </div>
                    </div>
                </div>

                <div class="panel panel-default">
                    <div class="panel-heading" role="tab" id="heading-nok-information">
                        <h4 class="panel-title">
                            <a role="button" data-toggle="collapse" href="#collapse-nok-information" aria-expanded="true" aria-controls="collapse-nok-information">
                                <strong><span class="glyphicon glyphicon-chevron-up"></span> Next-of-Kin Information</strong>
                            </a>
                        </h4>
                    </div>
                    <div id="collapse-nok-information" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="heading-nok-information">
                        <div class="panel-body">
                            <!-- Senior's Next-of-Kin Name Form Input -->
                            <div class="col-md-6 form-group">
                                {!! Form::label('nok_name', 'Next-of-Kin Name', ['class' => 'control-label']) !!}
                                {!! Form::text('nok_name', null, ['class' => 'form-control', 'required' => 'required']) !!}
                            </div>
                            <!-- Senior's Next-of-Kin Contact Number Form Input -->
                            <div class="col-md-6 form-group">
                                {!! Form::label('nok_contact', 'Next-of-Kin Contact Number', ['class' => 'control-label']) !!}
                                {!! Form::tel('nok_contact', null, ['class' => 'form-control', 'required' => 'required', 'maxlength' => '8', 'pattern' => '[0-9]{8}', 'placeholder' => 'e.g. 67654321']) !!}
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <!-- Submit Button Form Input -->
            <div class="form-group text-center">
                {!! Form::submit('Add new senior', ['class' => 'btn btn-default btn-md']) !!}
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

    $('#accordion .panel-collapse').on('shown.bs.collapse', function () {
        $(this).prev().find(".glyphicon").removeClass("glyphicon-chevron-down").addClass("glyphicon-chevron-up");
    }).children().on('shown.bs.collapse', function (e) {
        e.stopPropagation(); // Stop the inner collapsible panel from toggling the icon
    });

    $('#accordion .panel-collapse').on('hidden.bs.collapse', function () {
        $(this).prev().find(".glyphicon").removeClass("glyphicon-chevron-up").addClass("glyphicon-chevron-down");
    }).children().on('hidden.bs.collapse', function (e) {
        e.stopPropagation(); // Stop the inner collapsible panel from toggling the icon
    });;

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
</script>

@endsection