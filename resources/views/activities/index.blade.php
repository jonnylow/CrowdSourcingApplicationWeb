@extends('layouts.master')

@section('title', 'Activities')

@section('content')

<div class="container-fluid">
    <div class="row">
        <div class="col-md-3 margin-bottom-sm"><a href="activities/create" class="btn btn-primary btn-lg">Add new Activity</a></div>

        <div class="col-md-9">
            <div class="col-md-4 alert" role="alert">
                <div class="col-md-9 text-center">
                    <a href="#" class="alert-link">
                        <h3>
                            <p><strong>Unfilled Activities</strong></p>
                            <p><small>upcoming within 7 days</small></p>
                        </h3>
                    </a>
                </div>
                <div class="col-md-3 text-center widget"><h1>?</h1></div>
            </div>
            <div class="col-md-4 col-md-offset-1 alert" role="alert">
                <div class="col-md-9 text-center">
                    <a href="#" class="alert-link">
                        <h3>
                            <p><strong>Overrun Activities</strong></p>
                            <p><small>that exceeded duration</small></p>
                        </h3>
                    </a>
                </div>
                <div class="col-md-3 text-center widget"><h1>?</h1></div>
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
                                        <a class="btn btn-default btn-xs disabled" href="{{ route('activities.edit' ,[$activity->activity_id]) }}">
                                            <span class="fa fa-lg fa-pencil"></span> Edit
                                        </a>
                                    </td>
                                    <td>
                                        <a class="btn btn-default btn-xs" href="{{ route('activities.show' ,[$activity->activity_id]) }}">
                                            <span class="fa fa-lg fa-eye"></span> View
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                        </tbody>
                    </table>
                </div> <!-- /.tab-pane .table-responsive -->

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
                                        <a class="btn btn-default btn-xs" href="{{ route('activities.edit' ,[$activity->activity_id]) }}">
                                            <span class="fa fa-lg fa-pencil"></span> Edit
                                        </a>
                                    </td>
                                    <td>
                                        <a class="btn btn-default btn-xs" href="{{ route('activities.show' ,[$activity->activity_id]) }}">
                                            <span class="fa fa-lg fa-eye"></span> View
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                        </tbody>
                    </table>
                </div> <!-- /.tab-pane .table-responsive -->

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
                                        <a class="btn btn-default btn-xs" href="{{ route('activities.edit' ,[$activity->activity_id]) }}">
                                            <span class="fa fa-lg fa-pencil"></span> Edit
                                        </a>
                                    </td>
                                    <td>
                                        <a class="btn btn-default btn-xs" href="{{ route('activities.show' ,[$activity->activity_id]) }}">
                                            <span class="fa fa-lg fa-eye"></span> View
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                        </tbody>
                    </table>
                </div> <!-- /.tab-pane .table-responsive -->
            </div> <!-- /.tab-content -->
        </div>
    </div> <!-- /.row -->
</div> <!-- /.container-fluid -->

@endsection

@section('page-script')

<script>
    $(document).ready(function() {
        $('#past .fixed-table-toolbar .search input').attr('placeholder', 'Search past activities');
        $('#today .fixed-table-toolbar .search input').attr('placeholder', 'Search today\'s activities');
        $('#upcoming .fixed-table-toolbar .search input').attr('placeholder', 'Search upcoming activities');
    });
</script>

@endsection