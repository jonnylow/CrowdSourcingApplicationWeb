@extends('layouts.master')

@section('title', 'Add new Senior')

@section('content')

<div class="container-fluid">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <h1>Add new Senior</h1>

            @include('errors.list')

            {!! Form::open(['route' => 'elderly.store', 'files' => true]) !!}

            <div class="panel-group margin-bottom-md" id="accordion" role="tablist" aria-multiselectable="true">

                <div class="panel panel-default">
                    <div class="panel-heading" role="tab" id="heading-information">
                        <h4 class="panel-title">
                            <a role="button" data-toggle="collapse" href="#collapse-information" aria-expanded="true" aria-controls="collapse-information">
                                <span class="fa fa-fw fa-user"></span>
                                <strong>Senior Information</strong>
                                <span class="icon-arrow fa fa-lg fa-chevron-up"></span>
                            </a>
                        </h4>
                    </div>
                    <div id="collapse-information" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="heading-information">
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-md-10">
                                    <div class="row">
                                        <!-- Centre Form Input -->
                                        <div class="col-md-4 form-group">
                                            {!! Form::label('centre', 'For', ['class' => 'control-label']) !!}
                                            {!! Form::select('centre', $centreList, null, ['class' => 'form-control', 'required']) !!}
                                        </div>
                                        <!-- NRIC Form Input -->
                                        <div class="col-md-4 form-group">
                                            {!! Form::label('nric', 'NRIC', ['class' => 'control-label']) !!}
                                            {!! Form::text('nric', null, ['class' => 'form-control', 'required', 'size' => '9', 'pattern' => '[S|T|F|G|s|t|f|g][0-9]{7}[a-z|A-Z]', 'placeholder' => 'e.g. S1234567Z']) !!}
                                        </div>
                                        <!-- Name Form Input -->
                                        <div class="col-md-4 form-group">
                                            {!! Form::label('name', 'Name', ['class' => 'control-label']) !!}
                                            {!! Form::text('name', null, ['class' => 'form-control', 'required']) !!}
                                        </div>
                                    </div>

                                    <div class="row">
                                        <!-- Gender Form Input -->
                                        <div class="col-md-3 form-group">
                                            {!! Form::label('gender', 'Gender', ['class' => 'control-label']) !!}
                                            {!! Form::select('gender', $genderList, null, ['class' => 'form-control', 'required']) !!}
                                        </div>
                                        <!-- Birth Year Form Input -->
                                        <div class="col-md-4 form-group">
                                            {!! Form::label('birth_year', 'Birth Year', ['class' => 'control-label']) !!}
                                            {!! Form::number('birth_year', null, ['class' => 'form-control', 'maxlength' => '4', 'pattern' => '^[1-2][0-9]{3}', 'placeholder' => 'e.g. 1965']) !!}
                                        </div>
                                        <!-- Languages Form Input -->
                                        <div class="col-md-5 form-group">
                                            {!! Form::label('languages[]', 'Languages Spoken', ['class' => 'control-label']) !!}
                                            {!! Form::select('languages[]', $languages, null, ['class' => 'form-control', 'id' => 'languages', 'required', 'multiple']) !!}
                                        </div>
                                    </div>

                                    <div class="row">
                                        <!-- Medical Condition Form Input -->
                                        <div class="col-md-12 form-group">
                                            {!! Form::label('medical_condition', 'Medical Condition', ['class' => 'control-label']) !!}
                                            {!! Form::textarea('medical_condition', null, ['class' => 'form-control', 'rows' => '5', 'placeholder' => 'Optional']) !!}
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-2">
                                    <!-- Photo Form Input -->
                                    <div class="form-group">
                                        {!! Form::label('photo', 'Photo', ['class' => 'control-label']) !!}
                                        <div class="kv-avatar center-block">
                                            {!! Form::file('photo', ['class' => 'form-control', 'accept' => '.jpeg,.jpg,.png,.gif,.tiff', 'id' => 'photo']) !!}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="panel panel-default">
                    <div class="panel-heading" role="tab" id="heading-nok-information">
                        <h4 class="panel-title">
                            <a role="button" data-toggle="collapse" href="#collapse-nok-information" aria-expanded="true" aria-controls="collapse-nok-information">
                                <span class="fa fa-fw fa-users"></span>
                                <strong>Next-of-Kin Information</strong>
                                <span class="icon-arrow fa fa-lg fa-chevron-up"></span>
                            </a>
                        </h4>
                    </div>
                    <div id="collapse-nok-information" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="heading-nok-information">
                        <div class="panel-body">
                            <!-- Next-of-Kin Name Form Input -->
                            <div class="col-md-6 form-group">
                                {!! Form::label('nok_name', 'Next-of-Kin Name', ['class' => 'control-label']) !!}
                                {!! Form::text('nok_name', null, ['class' => 'form-control', 'required']) !!}
                            </div>
                            <!-- Next-of-Kin Contact Number Form Input -->
                            <div class="col-md-6 form-group">
                                {!! Form::label('nok_contact', 'Next-of-Kin Contact Number', ['class' => 'control-label']) !!}
                                {!! Form::tel('nok_contact', null, ['class' => 'form-control', 'required', 'maxlength' => '8', 'pattern' => '[0-9]{8}', 'placeholder' => 'e.g. 67654321']) !!}
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <!-- Submit Button Form Input -->
            <div class="form-group text-center">
                {!! Form::submit('Add new Senior', ['class' => 'btn btn-primary btn-lg']) !!}
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
<link rel="stylesheet" href="{{ asset('css/fileinput.min.css') }}">
<script type="text/javascript" src="{{ asset('js/fileinput.min.js') }}"></script>

<style>
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

    .kv-avatar .file-preview-frame,.kv-avatar .file-preview-frame:hover {
        margin: 0;
        padding: 0;
        border: none;
        box-shadow: none;
        text-align: center;
    }
    .kv-avatar .file-input {
        display: table-cell;
        width: 220px;
        height: 250px;
        max-width: 220px;
        max-height: 250px;
    }
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

    $("#photo").fileinput({
        overwriteInitial: true,
        maxFileSize: 1024,
        showClose: false,
        showCaption: false,
        browseLabel: '',
        removeLabel: '',
        browseIcon: '<span class="fa fa-fw fa-lg fa-folder-open"></span>',
        removeIcon: '<span class="fa fa-fw fa-lg fa-times"></span>',
        removeTitle: 'Remove picture',
        defaultPreviewContent: '<h1 class="text-center"><span class="fa fa-5x fa-user"></span></h1>',
        layoutTemplates: {main2: '{preview} {remove} {browse}'},
        allowedFileExtensions: ["jpeg", "jpg", "png", "gif", "tiff"]
    });
</script>

@endsection