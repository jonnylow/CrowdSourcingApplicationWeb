@extends('layouts.master')

@section('title', 'Activities Page')

@section('content')

<div class="container-fluid">
    <div class="row margin-bottom-md">
        <div class="col-md-3"><a href="activities/create" class="btn btn-default btn-md">Add new activity</a></div>
    </div>

    <div class="row margin-bottom-lg">
        <div class="col-md-12">
            <div class="panel">
                <div class="panel-heading">
                    <ul class="nav nav-tabs nav-justified">
                        <li><a href="#past" aria-controls="past" role="tab" data-toggle="tab">Past Activities</a></li>
                        <li><a href="#today" aria-controls="today" role="tab" data-toggle="tab">Today's Activities</a></li>
                        <li><a href="#upcoming" aria-controls="upcoming" role="tab" data-toggle="tab">Upcoming Activities</a></li>
                    </ul>
                </div>
                <div class="panel-body tab-content">

                    <div role="tabpanel" class="tab-pane table-responsive" id="past">
                        <table class="table table-striped table-bordered table-hover" data-toggle="table" data-pagination="true" data-search="true">
                            <thead>
                                <tr>
                                    <th class="col-md-3" data-field="activity" data-sortable="true" data-halign="center" data-align="center" data-valign="middle">Activity Name</th>
                                    <th class="col-md-3" data-field="start_date" data-sortable="true" data-halign="center" data-align="center" data-valign="middle">Start Date & Time</th>
                                    <th class="col-md-2" data-field="senior" data-sortable="true" data-halign="center" data-align="center" data-valign="middle">Senior's Name</th>
                                    <th class="col-md-2" data-field="status" data-sortable="true" data-halign="center" data-align="center" data-valign="middle">Status</th>
                                    <th class="col-md-1" data-align="center" data-valign="middle"></th>
                                    <th class="col-md-1" data-align="center" data-valign="middle"></th>
                                </tr>
                            </thead>
                            <tbody>
                            @if (count($past))
                                @foreach ($past as $activity)
                                    <tr>
                                        <td>{{ $activity->name }}</td>
                                        <td>{{ $activity->datetime_start->format('D, j M Y, g:ia') }}</td>
                                        <td>{{ $activity->elderly_name }}</td>
                                        <td>{{ \App\Http\Controllers\Activities\ActivitiesController::getStatus($activity) }}</td>
                                        <td>
                                            <a class="btn btn-primary btn-xs" href="javascript:alert('Work in Progress')">
                                                <span class="glyphicon glyphicon-pencil"></span> Edit
                                            </a>
                                        </td>
                                        <td>
                                            <a class="btn btn-info btn-xs" href="{{ route('activities.show' ,[$activity->activity_id]) }}">
                                                <span class="glyphicon glyphicon-eye-open"></span> View
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                            </tbody>
                        </table>
                    </div>

                    <div role="tabpanel" class="tab-pane table-responsive active" id="today">
                        <table class="table table-striped table-bordered table-hover" data-toggle="table" data-pagination="true" data-search="true">
                            <thead>
                                <tr>
                                    <th class="col-md-3" data-field="activity" data-sortable="true" data-halign="center" data-align="center" data-valign="middle">Activity Name</th>
                                    <th class="col-md-3" data-field="start_date" data-sortable="true" data-halign="center" data-align="center" data-valign="middle">Start Date & Time</th>
                                    <th class="col-md-2" data-field="senior" data-sortable="true" data-halign="center" data-align="center" data-valign="middle">Senior's Name</th>
                                    <th class="col-md-2" data-field="status" data-sortable="true" data-halign="center" data-align="center" data-valign="middle">Status</th>
                                    <th class="col-md-1" data-align="center" data-valign="middle"></th>
                                    <th class="col-md-1" data-align="center" data-valign="middle"></th>
                                </tr>
                            </thead>
                            <tbody>
                            @if (count($today))
                                @foreach ($today as $activity)
                                    <tr>
                                        <td>{{ $activity->name }}</td>
                                        <td>{{ $activity->datetime_start->format('D, j M Y, g:ia') }}</td>
                                        <td>{{ $activity->elderly_name }}</td>
                                        <td>{{ \App\Http\Controllers\Activities\ActivitiesController::getStatus($activity) }}</td>
                                        <td>
                                            <a class="btn btn-primary btn-xs" href="javascript:alert('Work in Progress')">
                                                <span class="glyphicon glyphicon-pencil"></span> Edit
                                            </a>
                                        </td>
                                        <td>
                                            <a class="btn btn-info btn-xs" href="{{ route('activities.show' ,[$activity->activity_id]) }}">
                                                <span class="glyphicon glyphicon-eye-open"></span> View
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                            </tbody>
                        </table>
                    </div>

                    <div role="tabpanel" class="tab-pane table-responsive" id="upcoming">
                        <table class="table table-striped table-bordered table-hover" data-toggle="table" data-pagination="true" data-search="true">
                            <thead>
                                <tr>
                                    <th class="col-md-3" data-field="activity" data-sortable="true" data-searchable="true" data-halign="center" data-align="center" data-valign="middle">Activity Name</th>
                                    <th class="col-md-3" data-field="start_date" data-sortable="true" data-searchable="true" data-halign="center" data-align="center" data-valign="middle">Start Date & Time</th>
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
                                    <td>{{ $activity->name }}</td>
                                    <td>{{ $activity->datetime_start->format('D, j M Y, g:ia') }}</td>
                                    <td>{{ $activity->elderly_name }}</td>
                                    <td>{{ \App\Http\Controllers\Activities\ActivitiesController::getStatus($activity) }}</td>
                                    <td>
                                        <a class="btn btn-primary btn-xs" href="javascript:alert('Work in Progress')">
                                            <span class="glyphicon glyphicon-pencil"></span> Edit
                                        </a>
                                    </td>
                                    <td>
                                        <a class="btn btn-info btn-xs" href="{{ route('activities.show' ,[$activity->activity_id]) }}">
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
