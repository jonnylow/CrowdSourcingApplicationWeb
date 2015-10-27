@extends('layouts.master')

@section('title', $activity->name)

@section('content')

<div class="container-fluid">
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
            <div class="col-md-3">
                <div class="row"><h1>{{ $activity->name }}</h1></div>
                <div class="row">
                    <div class="alert alert-info text-center">
                        <h5>Current Status: {{ \App\Http\Controllers\Activities\ActivitiesController::getActivityStatus($activity->activity_id) }}</h5>
                    </div>
                </div>
            </div>

            <div class="col-md-7 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading"><h5>Activity Information</h5></div>

                    <ul class="list-group">
                        <li class="list-group-item">
                            <dl class="dl-horizontal">
                                <dt>Start Date:</dt><dd>{{ $activity->datetime_start->format('D, j M Y') }}</dd>
                                <dt>Start Time:</dt><dd>{{ $activity->datetime_start->format('g:i a') }}</dd>
                                <dt>Expected End Time:</dt><dd>{{ $activity->datetime_start->addMinutes($activity->expected_duration_minutes)->format('g:i a') }}</dd>
                                <dt>Additional Info:</dt><dd>{{ $activity->more_information }}</dd>
                            </dl>
                        </li>
                        <li class="list-group-item">
                            <dl class="dl-horizontal">
                                <dt>From:</dt><dd>{{ $activity->location_from }}</dd>
                                <dt>To:</dt><dd>{{ $activity->location_to }}</dd>
                            </dl>
                        </li>
                        <li class="list-group-item">
                            <dl class="dl-horizontal">
                                <dt>Senior Name:</dt><dd>{{ $activity->elderly_name }}</dd>
                                <dt><abbr title="Next-of-Kin">NOK's</abbr> Name:</dt><dd>{{ $activity->next_of_kin_name }}</dd>
                                <dt><abbr title="Next-of-Kin">NOK's</abbr> Contact:</dt><dd>{{ $activity->next_of_kin_contact }}</dd>
                            </dl>
                        </li>
                    </ul>

                    <div class="panel-footer"><small>Last update by {{ $activity->vwoUser->name }} on {{ $activity->updated_at->format('D, j M Y, g:i a') }}</small></div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading"><h5>Volunteer Sign-up Application</h5></div>
                <div class="panel-body table-responsive">
                    <table class="table table-striped table-bordered table-hover" data-toggle="table" data-pagination="true" data-search="true">
                        <thead>
                            <tr>
                                <th class="col-md-2" rowspan="2" data-field="volunteer_name" data-sortable="true" data-searchable="true" data-halign="center" data-align="center" data-valign="middle">Applicant Name</th>
                                <th class="col-md-1" rowspan="2" data-field="gender" data-sortable="true" data-searchable="true" data-halign="center" data-align="center" data-valign="middle">Gender</th>
                                <th class="col-md-1" rowspan="2" data-field="age" data-sortable="true" data-searchable="true" data-halign="center" data-align="center" data-valign="middle">Age</th>
                                <th class="col-md-1" rowspan="2" data-field="hours_volunteered" data-sortable="true" data-halign="center" data-align="center" data-valign="middle">Hours Volunteered</th>
                                <th class="col-md-4" colspan="2" data-halign="center" data-align="center" data-valign="middle">Area of Preferences</th>
                                <th class="col-md-1" rowspan="2" data-field="status" data-sortable="true" data-halign="center" data-align="center" data-valign="middle">Status</th>
                                <th class="col-md-1" rowspan="2" data-align="center" data-valign="middle"></th>
                                <th class="col-md-1" rowspan="2" data-align="center" data-valign="middle"></th>
                            </tr>
                            <tr>
                                <th data-field="preference_1" data-sortable="true" data-searchable="true" data-halign="center" data-align="center" data-valign="middle">Preference 1</th>
                                <th data-field="preference_2" data-sortable="true" data-searchable="true" data-halign="center" data-align="center" data-valign="middle">Preference 2</th>
                            </tr>
                        </thead>
                        <tbody>
                        @if ($activity->volunteers->count() > 0)
                            @foreach ($volunteers = $activity->volunteers as $volunteer)
                            <tr>
                                <td>{{ $volunteer->name }}</td>
                                <td>{{ $volunteer->gender }}</td>
                                <td>{{ $volunteer->age() }} <abbr title="years old">y/o</abbr></td>
                                <td>{{ $volunteer->minutes_volunteered }}</td>
                                <td>{{ $volunteer->area_of_preference_1 }}</td>
                                <td>{{ $volunteer->area_of_preference_2 }}</td>
                                <td>{{ ucwords($volunteer->pivot->approval) }}</td>
                                <td>
                                    <a class="btn btn-danger btn-xs {{ $volunteer->pivot->approval == "withdrawn" || $volunteer->pivot->approval == "rejected" || $activity->tasks->groupBy('approval')->has('approved') || $activity->datetime_start->isPast() ? 'disabled' : '' }}" href="{{ action('Activities\ActivitiesController@approval' ,[$activity->activity_id, $volunteer->volunteer_id, 'reject']) }}">
                                        <span class="glyphicon glyphicon-remove"></span> Reject
                                    </a>
                                </td>
                                <td>
                                    <a class="btn btn-success btn-xs {{ $volunteer->pivot->approval == "withdrawn" || $volunteer->pivot->approval == "rejected" || $activity->tasks->groupBy('approval')->has('approved') || $activity->datetime_start->isPast() ? 'disabled' : '' }}" href="{{ action('Activities\ActivitiesController@approval' ,[$activity->activity_id, $volunteer->volunteer_id, 'approve']) }}">
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

@endsection
