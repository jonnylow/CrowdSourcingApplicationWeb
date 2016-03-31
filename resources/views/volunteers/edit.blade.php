@extends('layouts.master')

@section('title', 'Edit a Volunteer')

@section('content')

<div class="container-fluid margin-bottom-lg">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <h1>Edit a Volunteer</h1>

            <div class="row margin-bottom-sm">
                <div class="col-md-6 col-md-offset-3">
                    @include('errors.list')
                </div>
            </div>

            {!! Form::model($volunteer, ['method' => 'PATCH', 'route' => ['volunteers.update', $volunteer->volunteer_id]]) !!}
                {!! Form::hidden('volunteer_id', $volunteer->volunteer_id) !!}

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
                                    <!-- Name Form Input -->
                                    <div class="col-md-4 form-group">
                                        {!! Form::label('name', 'Name', ['class' => 'control-label']) !!}
                                        {!! Form::text('name', $volunteer->name, ['class' => 'form-control', 'required']) !!}
                                    </div>
                                    <!-- Email Form Input -->
                                    <div class="col-md-4 form-group">
                                        {!! Form::label('email', 'Email', ['class' => 'control-label']) !!}
                                        {!! Form::email('email', $volunteer->email, ['class' => 'form-control', 'required']) !!}
                                    </div>
                                    <!-- Gender Form Input -->
                                    <div class="col-md-4 form-group">
                                        {!! Form::label('gender', 'Gender', ['class' => 'control-label']) !!}
                                        {!! Form::select('gender', $genderList, $volunteer->gender, ['class' => 'form-control', 'required']) !!}
                                    </div>
                                </div>
                                <div class="row">
                                    <!-- Date of Birth Form Input -->
                                    <div class="col-md-7 form-group">
                                        {!! Form::label('date_of_birth', 'Date of Birth', ['class' => 'control-label']) !!}
                                        <div class="inline-field">
                                            <div class="col-md-4">{!! Form::selectMonth('date_month', $volunteer->date_of_birth->month, ['class' => 'form-control date-field', 'required']) !!}</div>
                                            <div class="col-md-4">{!! Form::text('date_day', $volunteer->date_of_birth->day, ['class' => 'form-control date-field', 'required', 'min' => '1', 'max' => '31', 'placeholder' => 'Day']) !!}</div>
                                            <div class="col-md-4">{!! Form::text('date_year', $volunteer->date_of_birth->year, ['class' => 'form-control date-field', 'required', 'min' => '1900', 'max' => Carbon\Carbon::now()->year, 'placeholder' => 'Year']) !!}</div>
                                        </div>
                                    </div>
                                    <!-- Contact Number Form Input -->
                                    <div class="col-md-5 form-group">
                                        {!! Form::label('contact_no', 'Contact Number', ['class' => 'control-label']) !!}
                                        {!! Form::tel('contact_no', $volunteer->contact_no, ['class' => 'form-control', 'required', 'maxlength' => '8', 'pattern' => '^[689][0-9]{7}', 'placeholder' => 'e.g. 98765432']) !!}
                                    </div>
                                </div>
                                <div class="row">
                                    <!-- Car Ownership Form Input -->
                                    <div class="col-md-6 form-group">
                                        {!! Form::label('car', 'Car Ownership', ['class' => 'control-label']) !!}
                                        {!! Form::select('car', $carType, $volunteer->has_car ? 1 : 0, ['class' => 'form-control', 'required']) !!}
                                    </div>
                                    <!-- Minutes Volunteered Form Input -->
                                    <div class="col-md-6 form-group">
                                        {!! Form::label('minutes_volunteered', 'Total Time Volunteered (in minutes)', ['class' => 'control-label']) !!}
                                        {!! Form::text('minutes_volunteered', $volunteer->minutes_volunteered, ['class' => 'form-control', 'min' => '0', 'max' => '99999999', 'pattern' => '[0-9]+']) !!}
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
                                    <strong>Optional Information</strong>
                                    <span class="icon-arrow fa fa-lg fa-chevron-up"></span>
                                </a>
                            </h4>
                        </div>
                        <div id="collapse-location" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="heading-location">
                            <div class="panel-body">
                                <div class="row">
                                    <!-- Occupation Form Input -->
                                    <div class="col-md-6 col-md-offset-3 form-group">
                                        {!! Form::label('occupation', 'Occupation', ['class' => 'control-label']) !!}
                                        {!! Form::text('occupation', $volunteer->occupation, ['class' => 'form-control']) !!}
                                    </div>
                                </div>
                                <div class="row">
                                    <!-- Volunteering Preference 1 Form Input -->
                                    <div class="col-md-6 form-group">
                                        {!! Form::label('area_of_preference_1', 'Volunteering Preference 1', ['class' => 'control-label']) !!}
                                        {!! Form::select('area_of_preference_1', $preferenceList, $volunteer->area_of_preference_1, ['class' => 'form-control']) !!}
                                    </div>
                                    <!-- Volunteering Preference 2 Form Input -->
                                    <div class="col-md-6 form-group">
                                        {!! Form::label('area_of_preference_2', 'Volunteering Preference 2', ['class' => 'control-label']) !!}
                                        {!! Form::select('area_of_preference_2', $preferenceList, $volunteer->area_of_preference_2, ['class' => 'form-control']) !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                <!-- Submit Button Form Input -->
                <div class="form-group text-center">
                    {!! Form::submit('Update volunteer', ['class' => 'btn btn-primary btn-lg']) !!}
                </div>

            {!! Form::close() !!}
        </div>
    </div>
</div>

@endsection

@section('page-script')

{!! $validator !!}

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
    .btn-group {
        margin-top: -2px;
        border: 2px solid transparent;
        border-radius: 6px;
    }
</style>

<script>
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
</script>

@endsection