@extends('layouts.master')

@section('title', $volunteer->name)

@section('content')

<div class="container-fluid margin-bottom-lg">
    <div class="row margin-bottom-xs">
        <div class="col-md-10 col-md-offset-1">
            <div class="{{ $volunteer->is_approved == 'approved' ? 'col-md-12' : 'col-md-7' }}">
                <h1>
                    {{ $volunteer->name }}
                    <small>
                        @if($volunteer->is_approved == 'approved')
                            <span class="label label-success">
                                <span class="fa fa-lg fa-check"></span> Training is completed
                            </span>
                        @elseif($volunteer->is_approved == 'rejected')
                            <span class="label label-danger">
                                <span class="fa fa-lg fa-times"></span> Volunteer is rejected
                            </span>
                        @else
                            <span class="label label-info">
                                <span class="fa fa-lg fa-hourglass-start"></span> Waiting for approval
                            </span>
                        @endif
                    </small>
                </h1>
            </div>
            @if($volunteer->is_approved !== 'approved')
                <div class="col-md-5 pull-down">
                    <div class="btn-toolbar pull-right">
                        @if($volunteer->is_approved === 'pending')
                            <div class="btn-group margin-bottom-xs">
                                {!! Form::open(['method' => 'PATCH', 'route' => ['volunteers.reject', $volunteer->volunteer_id]]) !!}
                                <a class="btn btn-danger btn-md" type="submit" data-toggle="modal" data-target="#confirmModal" data-size="modal-sm"
                                   data-type="question" data-title="Reject Volunteer" data-message="Are you sure you want to reject {{ $volunteer->name }}?"
                                   data-yes="Reject" data-no="Cancel">Reject Volunteer</a>
                                {!! Form::close() !!}
                            </div>
                        @endif
                        <div class="btn-group margin-bottom-xs">
                            {!! Form::open(['method' => 'PATCH', 'route' => ['volunteers.approve', $volunteer->volunteer_id]]) !!}
                            <a class="btn btn-success btn-md" type="submit" data-toggle="modal" data-target="#confirmModal" data-size="modal-sm"
                               data-type="question" data-title="Approve Volunteer" data-message="{{ $volunteer->name }} has completed training?"
                               data-yes="Yes" data-no="No">Approve Volunteer</a>
                            {!! Form::close() !!}
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="row margin-bottom-sm">
                <div class="col-md-6 col-md-offset-3">
                    @include('errors.list')
                </div>
            </div>

            <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">

                <div class="panel panel-default">
                    <div class="panel-heading" role="tab" id="heading-information">
                        <h4 class="panel-title vertical-center">
                            <a role="button" data-toggle="collapse" href="#collapse-information" aria-expanded="true" aria-controls="collapse-information">
                                <span class="fa fa-fw fa-user"></span>
                                <strong>Personal Information</strong>
                                <span class="icon-arrow fa fa-lg fa-chevron-up"></span>
                            </a>
                        </h4>
                        <a class="btn btn-primary btn-xs pull-right" href="{{ route('volunteers.edit', $volunteer->volunteer_id) }}">
                            <span class="fa fa-lg fa-pencil"></span> Edit Volunteer
                        </a>
                        <div class="clearfix"></div>
                    </div>
                    <div id="collapse-information" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="heading-information">
                        <div class="panel-body">
                            <dl class="dl-horizontal">
                                <dt>Date of Birth:</dt><dd>{{ $volunteer->date_of_birth->format('j M Y') }}</dd>
                                <dt>Age:</dt><dd>{{ $volunteer->age() }} <abbr title="years old">y/o</abbr></dd>
                                <dt>Gender:</dt><dd>{{ is_null($volunteer->gender) ? '' : ($volunteer->gender == 'M' ? 'Male' : 'Female') }}</dd>
                                <dt>Email:</dt><dd>{{ $volunteer->email }}</dd>
                                <dt>Contact No:</dt><dd>{{ $volunteer->contact_no }}</dd>
                                <dt>Has Car:</dt><dd>{{ $volunteer->has_car == true ? 'Yes' : 'No' }}</dd>
                                <dt>Occupation:</dt><dd>{{ $volunteer->occupation or '' }}</dd>
                                <dt>Volunteering Preference 1:</dt><dd>{{ $volunteer->area_of_preference_1 or '' }}</dd>
                                <dt>Volunteering Preference 2:</dt><dd>{{ $volunteer->area_of_preference_2 or '' }}</dd>
                            </dl>
                        </div>
                    </div>
                </div>

                <div class="panel panel-default">
                    <div class="panel-heading" role="tab" id="heading-additional">
                        <h4 class="panel-title">
                            <a role="button" data-toggle="collapse" href="#collapse-additional" aria-expanded="true" aria-controls="collapse-additional">
                                <span class="fa fa-fw fa-clipboard"></span>
                                <strong>Additional Information</strong>
                                <span class="icon-arrow fa fa-lg fa-chevron-up"></span>
                            </a>
                        </h4>
                    </div>
                    <div id="collapse-additional" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="heading-additional">
                        <div class="panel-body">
                            <dl class="dl-horizontal">
                                <dt>Rank:</dt><dd>{{ $volunteer->rank->name }}</dd>
                                <dt>Rank Points:</dt><dd>{{ $volunteer->rankPoints() }}</dd>
                                <dt>Total Time Volunteered:</dt><dd>{{ $volunteer->timeVolunteered() }}</dd>
                                <dt>Completed Activities:</dt><dd>{{ $volunteer->numOfCompletedActivity() }}</dd>
                                <dt>Withdrawn Activities:</dt><dd>{{ $volunteer->numOfWithdrawnActivity() }}</dd>
                            </dl>
                        </div>
                    </div>
                </div>

                <div class="panel panel-default">
                    <div class="panel-heading" role="tab" id="heading-volunteer">
                        <h4 class="panel-title">
                            <a role="button" data-toggle="collapse" href="#collapse-volunteer" aria-expanded="true" aria-controls="collapse-volunteer">
                                <span class="fa fa-fw fa-history"></span>
                                <strong>Activity History</strong>
                                <span class="icon-arrow fa fa-lg fa-chevron-up"></span>
                            </a>
                        </h4>
                    </div>
                    <div id="collapse-volunteer" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="heading-volunteer">
                        <div class="panel-body table-responsive">
                            <table class="table table-striped table-bordered table-hover" data-toggle="table" data-pagination="true" data-search="true">
                                <thead>
                                    <tr>
                                        <th class="col-md-1" data-align="center" data-valign="middle"></th>
                                        <th class="col-md-2" data-field="start_date" data-sortable="true" data-searchable="true" data-halign="center" data-align="center" data-valign="middle">Start Date</th>
                                        <th class="col-md-1" data-field="start_time" data-sortable="true" data-searchable="true" data-halign="center" data-align="center" data-valign="middle">Start Time</th>
                                        <th class="col-md-1" data-field="end_time" data-sortable="true" data-searchable="true" data-halign="center" data-align="center" data-valign="middle">End Time</th>
                                        <th class="col-md-2" data-field="senior_name" data-sortable="true" data-searchable="true" data-halign="center" data-align="center" data-valign="middle">Senior's Name</th>
                                        <th class="col-md-2" data-field="start_location" data-sortable="true" data-halign="center" data-align="center" data-valign="middle">Branch</th>
                                        <th class="col-md-2" data-field="end_location" data-sortable="true" data-halign="center" data-align="center" data-valign="middle">Appointment Venue</th>
                                        <th class="col-md-2" data-field="status" data-sortable="true" data-halign="center" data-align="center" data-valign="middle">Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @if (count($volunteer->activities))
                                    @foreach ($volunteer->activities as $activity)
                                        <tr>
                                            <td><a class="btn btn-info btn-xs" href="{{ route('activities.show', $activity->activity_id) }}">Details</a></td>
                                            <td>{{ $activity->datetime_start->format('D, j M Y') }}</td>
                                            <td>{{ $activity->datetime_start->format('g:i a') }}</td>
                                            <td>{{ $activity->datetime_start->addMinutes($activity->expected_duration_minutes)->format('g:i a') }}</td>
                                            <td>{{ $activity->elderly->name }}</td>
                                            <td>{{ $activity->departureCentre->name }}</td>
                                            <td>{{ $activity->arrivalCentre->name }}</td>
                                            <td>{{ ucwords($activity->pivot->approval) }}</td>
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

@include('partials.confirm')

@endsection

@section('page-script')

<style>
    @media (min-width: 1000px) {
        .dl-horizontal dt { width: 200px; }
        .dl-horizontal dd { margin-left: 220px; }
    }
</style>

@endsection

@section('partials-script')

@include('partials.confirm')

@endsection

@section('auth-script')

@include('auth._redirect_if_no_auth')

@endsection
