@extends('layouts.master')

@section('title', 'Add new Volunteer')

@section('content')

<div class="container-fluid margin-bottom-lg">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <h1>Add new Volunteer</h1>

            @include('errors.list')

            {!! Form::open(['route' => 'volunteers.store']) !!}

            <div class="panel-group margin-bottom-md" id="accordion" role="tablist" aria-multiselectable="true">

                <div class="panel panel-default">
                    <div class="panel-heading" role="tab" id="heading-information">
                        <h4 class="panel-title">
                            <a role="button" data-toggle="collapse" href="#collapse-information" aria-expanded="true" aria-controls="collapse-information">
                                <span class="fa fa-fw fa-user"></span>
                                <strong>Personal Information</strong>
                                <span class="icon-arrow fa fa-lg fa-chevron-up"></span>
                            </a>
                        </h4>
                    </div>
                    <div id="collapse-information" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="heading-information">
                        <div class="panel-body">
                            <div class="row">
                                <!-- NRIC Form Input -->
                                <div class="col-md-4 form-group">
                                    {!! Form::label('nric', 'NRIC', ['class' => 'control-label']) !!}
                                    {!! Form::text('nric', null, ['class' => 'form-control', 'required', 'size' => '9', 'pattern' => '[STFGstfg][0-9]{7}[a-zA-Z]', 'placeholder' => 'e.g. S1234567Z']) !!}
                                </div>
                                <!-- Name Form Input -->
                                <div class="col-md-5 form-group">
                                    {!! Form::label('name', 'Name', ['class' => 'control-label']) !!}
                                    {!! Form::text('name', null, ['class' => 'form-control', 'required']) !!}
                                </div>
                                <!-- Gender Form Input -->
                                <div class="col-md-3 form-group">
                                    {!! Form::label('gender', 'Gender', ['class' => 'control-label']) !!}
                                    {!! Form::select('gender', $genderList, null, ['class' => 'form-control', 'required']) !!}
                                </div>
                            </div>
                            <div class="row">
                                <!-- Date of Birth Form Input -->
                                <div class="col-md-4 form-group">
                                    {!! Form::label('date_of_birth', 'Date of Birth', ['class' => 'control-label']) !!}
                                    {!! Form::date('date_of_birth', null, ['class' => 'form-control', 'required', 'max' => Carbon\Carbon::now()->format('Y-m-d')]) !!}
                                </div>
                                <!-- Email Form Input -->
                                <div class="col-md-5 form-group">
                                    {!! Form::label('email', 'Email', ['class' => 'control-label']) !!}
                                    {!! Form::email('email', null, ['class' => 'form-control', 'required']) !!}
                                </div>
                                <!-- Contact Number Form Input -->
                                <div class="col-md-3 form-group">
                                    {!! Form::label('contact_no', 'Contact Number', ['class' => 'control-label']) !!}
                                    {!! Form::tel('contact_no', null, ['class' => 'form-control', 'required', 'maxlength' => '8', 'pattern' => '[0-9]{8}', 'placeholder' => 'e.g. 98765432']) !!}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="panel panel-default">
                    <div class="panel-heading" role="tab" id="heading-location">
                        <h4 class="panel-title">
                            <a role="button" data-toggle="collapse" href="#collapse-location" aria-expanded="true" aria-controls="collapse-location">
                                <span class="fa fa-fw fa-clipboard"></span>
                                <strong>Additional Information</strong>
                                <span class="icon-arrow fa fa-lg fa-chevron-up"></span>
                            </a>
                        </h4>
                    </div>
                    <div id="collapse-location" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="heading-location">
                        <div class="panel-body">
                            <div class="row">
                                <!-- Car Ownership Form Input -->
                                <div class="col-md-5 form-group">
                                    <div>{!! Form::label('car', 'Car Ownership', ['class' => 'control-label']) !!}</div>
                                    <div class="btn-group" data-toggle="buttons">
                                        <label class="btn btn-default {{ old('car') == "0" ? 'active' : null }}">
                                            <input type="radio" name="car" value="0" autocomplete="off" {{ old('car') == "0" ? 'checked' : null }}> No car
                                        </label>
                                        <label class="btn btn-default {{ old('car') == "1" ? 'active' : null }}">
                                            <input type="radio" name="car" value="1" autocomplete="off" {{ old('car') == "1" ? 'checked' : null }}> Has car
                                        </label>
                                    </div>
                                </div>
                                <!-- Occupation Form Input -->
                                <div class="col-md-7 form-group">
                                    {!! Form::label('occupation', 'Occupation', ['class' => 'control-label']) !!}
                                    {!! Form::text('occupation', null, ['class' => 'form-control', 'required']) !!}
                                </div>
                            </div>
                            <div class="row">
                                <!-- Volunteering Preference 1 Form Input -->
                                <div class="col-md-6 form-group">
                                    {!! Form::label('area_of_preference_1', 'Volunteering Preference 1', ['class' => 'control-label']) !!}
                                    {!! Form::text('area_of_preference_1', null, ['class' => 'form-control', 'required']) !!}
                                </div>
                                <!-- Volunteering Preference 2 Form Input -->
                                <div class="col-md-6 form-group">
                                    {!! Form::label('area_of_preference_2', 'Volunteering Preference 2', ['class' => 'control-label']) !!}
                                    {!! Form::text('area_of_preference_2', null, ['class' => 'form-control', 'required']) !!}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <!-- Submit Button Form Input -->
            <div class="form-group text-center">
                {!! Form::submit('Add volunteer', ['class' => 'btn btn-primary btn-lg']) !!}
            </div>

            {!! Form::close() !!}
        </div>
    </div>
</div>

@endsection

@section('page-script')

{!! $validator !!}

<style>
    .btn-group {
        border: 2px solid transparent;
        border-radius: 6px;
    }
    .has-error .btn-group, .has-error .btn-group.focus { border-color: #e74c3c; }
    .has-success .btn-group, .has-success .btn-group.focus { border-color: #18bc9c; }
</style>

@endsection