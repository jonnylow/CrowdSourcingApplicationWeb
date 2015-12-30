@extends('layouts.master')

@section('title', 'Activities Page')

@section('content')

<div class="container-fluid">
    <div class="row">
        <div class="col-md-3 margin-bottom-sm"><a href="activities/create" class="btn btn-default btn-md">Add new activity</a></div>

        <div class="col-md-9">
            <div class="col-md-4 alert" role="alert">
                <div class="col-md-8"><a href="#" class="alert-link">...</a></div>
                <div class="col-md-4 text-center"><h1><span class="label label-default">0</span></h1></div>
            </div>
            <div class="col-md-4 col-md-offset-1 alert" role="alert">
                <div class="col-md-8"><a href="#" class="alert-link">...</a></div>
                <div class="col-md-4 text-center"><h1><span class="label label-default">0</span></h1></div>
            </div>
        </div>
    </div>

    <div class="row margin-bottom-lg">
        <div class="col-md-12">
            <ul class="nav nav-tabs">
                <li><a href="#past" aria-controls="past" role="tab" data-toggle="tab"><strong>Past Activities</strong></a></li>
                <li class="active"><a href="#today" aria-controls="today" role="tab" data-toggle="tab"><strong>Today's Activities</strong></a></li>
                <li><a href="#upcoming" aria-controls="upcoming" role="tab" data-toggle="tab"><strong>Upcoming Activities</strong></a></li>
            </ul>

                <div class="tab-content">
                    <div role="tabpanel" class="tab-pane table-responsive fade" id="past">
                        <table class="table table-striped table-bordered table-hover" data-toggle="table" data-pagination="true" data-search="true">
                            <thead>
                                <tr>
                                    <th class="col-md-2" data-field="location_from" data-sortable="true" data-searchable="true" data-halign="center" data-align="center" data-valign="middle">From</th>
                                    <th class="col-md-2" data-field="location_to" data-sortable="true" data-searchable="true" data-halign="center" data-align="center" data-valign="middle">To</th>
                                    <th class="col-md-2" data-field="datetime_start" data-sortable="true" data-searchable="true" data-halign="center" data-align="center" data-valign="middle">Start Date & Time</th>
                                    <th class="col-md-2" data-field="senior" data-sortable="true" data-searchable="true" data-halign="center" data-align="center" data-valign="middle">Senior's Name</th>
                                    <th class="col-md-2" data-field="status" data-sortable="true" data-searchable="true" data-halign="center" data-align="center" data-valign="middle">Status</th>
                                    <th class="col-md-1" data-align="center" data-valign="middle"></th>
                                    <th class="col-md-1" data-align="center" data-valign="middle"></th>
                                </tr>
                            </thead>
                            <tbody>
                            @if (count($past))
                                @foreach ($past as $activity)
                                    <tr>
                                        <td>{{ $activity->departureCentre->name }}</td>
                                        <td>{{ $activity->arrivalCentre->name }}</td>
                                        <td>{{ $activity->datetime_start->format('D, j M Y, g:i a') }}</td>
                                        <td>{{ $activity->elderly->name }}</td>
                                        <td>{{ \App\Http\Controllers\Activities\ActivitiesController::getApplicantStatus($activity->activity_id) }} </td>
                                        <td>
                                            <a class="btn btn-warning btn-xs disabled" href="{{ route('activities.edit' ,[$activity->activity_id]) }}">
                                                <span class="glyphicon glyphicon-pencil"></span> Edit
                                            </a>
                                        </td>
                                        <td>
                                            <a class="btn btn-primary btn-xs" href="{{ route('activities.show' ,[$activity->activity_id]) }}">
                                                <span class="glyphicon glyphicon-eye-open"></span> View
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                            </tbody>
                        </table>
                    </div>

                    <div role="tabpanel" class="tab-pane table-responsive fade in active" id="today">
                        <table class="table table-striped table-bordered table-hover" data-toggle="table" data-pagination="true" data-search="true">
                            <thead>
                                <tr>
                                    <th class="col-md-2" data-field="location_from" data-sortable="true" data-searchable="true" data-halign="center" data-align="center" data-valign="middle">From</th>
                                    <th class="col-md-2" data-field="location_to" data-sortable="true" data-searchable="true" data-halign="center" data-align="center" data-valign="middle">To</th>
                                    <th class="col-md-2" data-field="datetime_start" data-sortable="true" data-searchable="true" data-halign="center" data-align="center" data-valign="middle">Start Date & Time</th>
                                    <th class="col-md-2" data-field="senior" data-sortable="true" data-searchable="true" data-halign="center" data-align="center" data-valign="middle">Senior's Name</th>
                                    <th class="col-md-2" data-field="status" data-sortable="true" data-searchable="true" data-halign="center" data-align="center" data-valign="middle">Status</th>
                                    <th class="col-md-1" data-align="center" data-valign="middle"></th>
                                    <th class="col-md-1" data-align="center" data-valign="middle"></th>
                                </tr>
                            </thead>
                            <tbody>
                            @if (count($today))
                                @foreach ($today as $activity)
                                    <tr>
                                        <td>{{ $activity->departureCentre->name }}</td>
                                        <td>{{ $activity->arrivalCentre->name }}</td>
                                        <td>{{ $activity->datetime_start->format('D, j M Y, g:i a') }}</td>
                                        <td>{{ $activity->elderly->name }}</td>
                                        <td>{{ \App\Http\Controllers\Activities\ActivitiesController::getApplicantStatus($activity->activity_id) }} </td>
                                        <td>
                                            <a class="btn btn-warning btn-xs" href="{{ route('activities.edit' ,[$activity->activity_id]) }}">
                                                <span class="glyphicon glyphicon-pencil"></span> Edit
                                            </a>
                                        </td>
                                        <td>
                                            <a class="btn btn-primary btn-xs" href="{{ route('activities.show' ,[$activity->activity_id]) }}">
                                                <span class="glyphicon glyphicon-eye-open"></span> View
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                            </tbody>
                        </table>
                    </div>

                    <div role="tabpanel" class="tab-pane table-responsive fade" id="upcoming">
                        <table class="table table-striped table-bordered table-hover" data-toggle="table" data-pagination="true" data-search="true">
                            <thead>
                                <tr>
                                    <th class="col-md-2" data-field="location_from" data-sortable="true" data-searchable="true" data-halign="center" data-align="center" data-valign="middle">From</th>
                                    <th class="col-md-2" data-field="location_to" data-sortable="true" data-searchable="true" data-halign="center" data-align="center" data-valign="middle">To</th>
                                    <th class="col-md-2" data-field="datetime_start" data-sortable="true" data-searchable="true" data-halign="center" data-align="center" data-valign="middle">Start Date & Time</th>
                                    <th class="col-md-2" data-field="senior" data-sortable="true" data-searchable="true" data-halign="center" data-align="center" data-valign="middle">Senior's Name</th>
                                    <th class="col-md-2" data-field="status" data-sortable="true" data-searchable="true" data-halign="center" data-align="center" data-valign="middle">Status</th>
                                    <th class="col-md-1" data-align="center" data-valign="middle"></th>
                                    <th class="col-md-1" data-align="center" data-valign="middle"></th>
                                </tr>
                            </thead>
                            <tbody>
                            @if (count($upcoming))
                                @foreach ($upcoming as $activity)
                                    <tr>
                                        <td>{{ $activity->departureCentre->name }}</td>
                                        <td>{{ $activity->arrivalCentre->name }}</td>
                                        <td>{{ $activity->datetime_start->format('D, j M Y, g:i a') }}</td>
                                        <td>{{ $activity->elderly->name }}</td>
                                        <td>{{ \App\Http\Controllers\Activities\ActivitiesController::getApplicantStatus($activity->activity_id) }} </td>
                                        <td>
                                            <a class="btn btn-warning btn-xs" href="{{ route('activities.edit' ,[$activity->activity_id]) }}">
                                                <span class="glyphicon glyphicon-pencil"></span> Edit
                                            </a>
                                        </td>
                                        <td>
                                            <a class="btn btn-primary btn-xs" href="{{ route('activities.show' ,[$activity->activity_id]) }}">
                                                <span class="glyphicon glyphicon-eye-open"></span> View
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

@endsection
