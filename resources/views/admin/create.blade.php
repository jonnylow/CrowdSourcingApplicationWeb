@extends('layouts.master')

@section('title', 'Add new staff')

@section('content')

<div class="container-fluid">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <h1>Add new staff</h1>

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

            {!! Form::open(['route' => 'admin.store']) !!}

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
                                <!-- Name Form Input -->
                                <div class="col-md-4 form-group">
                                    {!! Form::label('name', 'Name', ['class' => 'control-label']) !!}
                                    {!! Form::text('name', null, ['class' => 'form-control', 'required' => 'required']) !!}
                                </div>
                                <!-- Email Form Input -->
                                <div class="col-md-4 form-group">
                                    {!! Form::label('email', 'Email', ['class' => 'control-label']) !!}
                                    {!! Form::email('email', null, ['class' => 'form-control', 'required' => 'required']) !!}
                                </div>
                                <!-- Senior Gender Form Input -->
                                <div class="col-md-4 form-group">
                                    {!! Form::label('admin', 'Staff Type', ['class' => 'control-label']) !!}
                                    <div class="btn-group" data-toggle="buttons">
                                        <label class="btn btn-primary active">
                                            <input type="radio" name="admin" id="false" autocomplete="off" checked> Regular
                                        </label>
                                        <label class="btn btn-primary">
                                            <input type="radio" name="admin" id="true" autocomplete="off"> Admin
                                        </label>
                                    </div>
                                </div>

                            </div>
                            <!-- Centres Form Input -->
                            <div class="col-md-12 form-group">
                                {!! Form::label('centres', 'Centres in charge', ['class' => 'control-label']) !!}
                                {!! Form::select('centres[]', $centreList, null, ['class' => 'form-control', 'required' => 'required', 'multiple' => 'multiple', 'id' => 'centres']) !!}
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <!-- Submit Button Form Input -->
            <div class="form-group text-center">
                {!! Form::submit('Add new staff', ['class' => 'btn btn-default btn-md']) !!}
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
    $("#centres").select2({
        theme: "bootstrap",
        placeholder: "e.g. Henderson, Dakota Crescent",
        tags: true,
        tokenSeparators: [',', ' ']
    });
</script>

@endsection