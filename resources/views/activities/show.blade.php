@extends('layouts.master')

@section('title', $activity->name)

@section('content')

<div class="container-fluid">
    <div class="row margin-bottom-xs">
        <div class="col-md-12">
            <div class="col-md-3 hidden-sm hidden-xs text-left"><h1>{{ $activity->location_from }}</h1></div>
            <div class="col-md-1 hidden-sm hidden-xs text-center"><h1><span class="glyphicon glyphicon-arrow-right"></span></h1></div>
            <div class="col-md-4 hidden-sm hidden-xs text-center"><h1>{{ $activity->location_to }}</h1></div>
            <div class="col-md-1 hidden-sm hidden-xs text-center"><h1><span class="glyphicon glyphicon-arrow-right"></span></h1></div>
            <div class="col-md-3 hidden-sm hidden-xs text-right"><h1>{{ $activity->location_from }}</h1></div>
            <div class="hidden-lg hidden-md"><h3>Activity Progress:</h3></div>
        </div>
        <div class="col-md-12">
            <div class="progress">
                @if (\App\Http\Controllers\Activities\ActivitiesController::getActivityStatus($activity->activity_id) <= 0)
                    <p class="text-center text-uppercase"><strong>Activity not started</strong></p>
                @else
                    <div class="progress-bar color2" style="width:{{ \App\Http\Controllers\Activities\ActivitiesController::getActivityStatus($activity->activity_id) }}%">
                        <span class="sr-only">{{ \App\Http\Controllers\Activities\ActivitiesController::getActivityStatus($activity->activity_id) }}%</span>
                        <p class="text-center text-uppercase"><strong>
                        @if (\App\Http\Controllers\Activities\ActivitiesController::getActivityStatus($activity->activity_id) <= 25)
                            Heading to check-up...
                        @elseif (\App\Http\Controllers\Activities\ActivitiesController::getActivityStatus($activity->activity_id) <= 50)
                            At check-up...
                        @elseif (\App\Http\Controllers\Activities\ActivitiesController::getActivityStatus($activity->activity_id) <= 75)
                            Heading back to centre...
                        @elseif (\App\Http\Controllers\Activities\ActivitiesController::getActivityStatus($activity->activity_id) == 100)
                            Back at centre...
                        @endif
                        </strong></p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <div class="row margin-bottom-xs">
        <div class="col-md-10 col-md-offset-1">
            @if (Session::has('success'))
                <div class="alert alert-success alert-dismissible fade in" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    @if (Session::has('success'))
                        {{ Session::get('success') }}
                    @endif
                </div>
            @endif
            <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">

                <div class="panel panel-default">
                    <div class="panel-heading" role="tab" id="heading-information">
                        <h4 class="panel-title">
                            <a role="button" data-toggle="collapse" href="#collapse-information" aria-expanded="true" aria-controls="collapse-information">
                                <strong><span class="glyphicon glyphicon-calendar"></span> Activity Information</strong>
                            </a>
                        </h4>
                    </div>
                    <div id="collapse-information" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="heading-information">
                        <div class="panel-body">
                            <dl class="dl-horizontal">
                                <dt>Start Date:</dt><dd>{{ $activity->datetime_start->format('D, j M Y') }}</dd>
                                <dt>Start Time:</dt><dd>{{ $activity->datetime_start->format('g:i a') }}</dd>
                                <dt>Expected End Time:</dt><dd>{{ $activity->datetime_start->addMinutes($activity->expected_duration_minutes)->format('g:i a') }}</dd>
                                <dt>Senior's Name:</dt><dd>{{ $activity->elderly->name }} <a href="javascript:alert('Senior Information')"><span class="badge">Details</span></a></dd>
                                <br>
                                <dt>Additional Info:</dt><dd>{{ $activity->more_information }}</dd>
                            </dl>
                        </div>
                    </div>
                </div>

                <div class="panel panel-default">
                    <div class="panel-heading" role="tab" id="heading-address">
                        <h4 class="panel-title">
                            <a role="button" data-toggle="collapse" href="#collapse-address" aria-expanded="false" aria-controls="collapse-address">
                                <strong><span class="glyphicon glyphicon-map-marker"></span> Venue Addresses</strong>
                            </a>
                        </h4>
                    </div>
                    <div id="collapse-address" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading-address">
                        <div class="panel-body">
                            <dl class="dl-horizontal">
                                <dt>Start From:</dt>
                                <dd><address><strong>{{ $activity->location_from }}</strong><br>{{  $activity->location_from_address }}</address></dd>
                                <dt>Check-up At:</dt>
                                <dd><address><strong>{{ $activity->location_to }}</strong><br>{{  $activity->location_to_address }}</address></dd>
                            </dl>
                        </div>
                    </div>
                </div>

                <div class="panel panel-default">
                    <div class="panel-heading" role="tab" id="heading-volunteer">
                        <h4 class="panel-title">
                            <a role="button" data-toggle="collapse" href="#collapse-volunteer" aria-expanded="true" aria-controls="collapse-volunteer">
                                <strong><span class="glyphicon glyphicon-heart"></span> Volunteer Sign-ups</strong>
                            </a>
                        </h4>
                    </div>
                    <div id="collapse-volunteer" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="heading-volunteer">
                        <div class="panel-body table-responsive">
                            <table class="table table-striped table-bordered table-hover" data-toggle="table" data-pagination="true" data-search="true">
                                <thead>
                                    <tr>
                                        <th class="col-md-1" data-align="center" data-valign="middle"></th>
                                        <th class="col-md-3" data-field="volunteer_name" data-sortable="true" data-searchable="true" data-halign="center" data-align="center" data-valign="middle">Applicant Name</th>
                                        <th class="col-md-1" data-field="gender" data-sortable="true" data-searchable="true" data-halign="center" data-align="center" data-valign="middle">Gender</th>
                                        <th class="col-md-1" data-field="age" data-sortable="true" data-searchable="true" data-halign="center" data-align="center" data-valign="middle">Age</th>
                                        <th class="col-md-2" data-field="rank" data-sortable="true" data-searchable="true" data-halign="center" data-align="center" data-valign="middle">Rank</th>
                                        <th class="col-md-2" data-field="status" data-sortable="true" data-halign="center" data-align="center" data-valign="middle">Status</th>
                                        <th class="col-md-1" data-align="center" data-valign="middle"></th>
                                        <th class="col-md-1" data-align="center" data-valign="middle"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                @if ($activity->volunteers->count() > 0)
                                    @foreach ($volunteers = $activity->volunteers as $volunteer)
                                        <tr>
                                            <td><a class="btn btn-info btn-xs" href="#">Details</a></td>
                                            <td>{{ $volunteer->name }}</td>
                                            <td>{{ $volunteer->gender }}</td>
                                            <td>{{ $volunteer->age() }} <abbr title="years old">y/o</abbr></td>
                                            <td>{{ $volunteer->rank or "NA" }}</td>
                                            <td>{{ ucwords($volunteer->pivot->approval) }}</td>
                                            <td>
                                                <a class="btn btn-danger btn-xs {{ $volunteer->pivot->approval == "withdrawn" || $volunteer->pivot->approval == "rejected" || $activity->datetime_start->isPast() ? 'disabled' : '' }}" href="{{ action('Activities\ActivitiesController@approval' ,[$activity->activity_id, $volunteer->volunteer_id, 'reject']) }}">
                                                    <span class="glyphicon glyphicon-remove"></span> Reject
                                                </a>
                                            </td>
                                            <td>
                                                <a class="btn btn-success btn-xs {{ $volunteer->pivot->approval == "withdrawn" || $volunteer->pivot->approval == "rejected" || $activity->datetime_start->isPast() ? 'disabled' : '' }}" href="{{ action('Activities\ActivitiesController@approval' ,[$activity->activity_id, $volunteer->volunteer_id, 'approve']) }}">
                                                    <span class="glyphicon glyphicon-ok"></span> Approve
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

@endsection
