@extends('layouts.master')

@section('title', 'Edit a Staff')

@section('content')

<div class="container-fluid margin-bottom-lg">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <h1>Edit a Staff</h1>

            @include('errors.list')

            {!! Form::model($staff, ['method' => 'PATCH', 'route' => ['staff.update', $staff->staff_id]]) !!}
                {!! Form::hidden('staff_id', $staff->staff_id) !!}

                <div class="panel-group margin-bottom-md" id="accordion" role="tablist" aria-multiselectable="true">

                    <div class="panel panel-default">
                        <div class="panel-heading" role="tab" id="heading-information">
                            <h4 class="panel-title">
                                <a role="button" data-toggle="collapse" href="#collapse-information" aria-expanded="true" aria-controls="collapse-information">
                                    <span class="fa fa-fw fa-user"></span>
                                    <strong>Information</strong>
                                    <span class="icon-arrow fa fa-lg fa-chevron-up"></span>
                                </a>
                            </h4>
                        </div>
                        <div id="collapse-information" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="heading-information">
                            <div class="panel-body">
                                <div class="row">
                                    <!-- Name Form Input -->
                                    <div class="col-md-6 form-group">
                                        {!! Form::label('name', 'Name', ['class' => 'control-label']) !!}
                                        {!! Form::text('name', $staff->name, ['class' => 'form-control', 'required']) !!}
                                    </div>
                                    <!-- Email Form Input -->
                                    <div class="col-md-6 form-group">
                                        {!! Form::label('email', 'Email', ['class' => 'control-label']) !!}
                                        {!! Form::email('email', $staff->email, ['class' => 'form-control', 'required']) !!}
                                    </div>
                                </div>
                                <div class="row">
                                    @if (Auth::user()->is_admin)
                                    <!-- Staff Type Form Input -->
                                    <div class="col-md-5 form-group">
                                        {!! Form::label('type', 'Staff Type', ['class' => 'control-label']) !!}
                                        {!! Form::select('type', $staffType, $staff->is_admin ? 1 : 0, ['class' => 'form-control', 'required']) !!}
                                    </div>
                                    @endif
                                    <!-- Centres Form Input -->
                                    <div class="col-md-7 form-group">
                                        {!! Form::label('centres[]', 'Senior Centres in charge', ['class' => 'control-label']) !!}
                                        {!! Form::select('centres[]', $centreList, $staff->centres->lists('centre_id')->toArray(), ['class' => 'form-control', 'id' => 'centres', 'required', 'multiple']) !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                <!-- Submit Button Form Input -->
                <div class="form-group text-center">
                    {!! Form::submit('Update staff', ['class' => 'btn btn-primary btn-lg']) !!}
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

    .selectize-input > input {
        color: #acb6c0;
        padding: 2px 0px !important;
    }

    ::-webkit-input-placeholder { color: #acb6c0; }
    :-moz-placeholder { color: #acb6c0; }
    ::-moz-placeholder { color: #acb6c0; }
    :-ms-input-placeholder { color: #acb6c0; }

    .btn-group {
        border: 2px solid transparent;
        border-radius: 6px;
    }
    .has-error .btn-group, .has-error .btn-group.focus { border-color: #e74c3c; }
    .has-success .btn-group, .has-success .btn-group.focus { border-color: #18bc9c; }
</style>

<script>
    $("#centres").selectize({
        plugins: ['restore_on_backspace', 'remove_button'],
        delimiter: ',',
        persist: false,
        placeholder: 'e.g. Henderson Home'
    });
</script>

@endsection