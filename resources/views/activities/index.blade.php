@extends('layouts.master')

@section('title', 'Activities')

@section('content')

<div class="container-fluid margin-bottom-lg">
    <div class="row margin-bottom-sm">
        <div class="col-md-3"><a href="activities/create" class="btn btn-primary btn-lg">Add new Activity</a></div>
    </div>

    <div class="row margin-bottom-sm">
        <div class="col-md-6 col-md-offset-3">
            @include('errors.list')
        </div>
    </div>

    <div class="row">
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
                                <th class="col-md-2" data-field="location_from" data-sortable="true" data-searchable="true" data-halign="center" data-align="center" data-valign="middle">Branch</th>
                                <th class="col-md-2" data-field="location_to" data-sortable="true" data-searchable="true" data-halign="center" data-align="center" data-valign="middle">Appointment Venue</th>
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
                                    <td>{!! $activity->getApplicationStatus() !!}</td>
                                    <td>
                                        <div data-toggle="tooltip" data-placement="top" title="{{ $activity->getTooltipStatus() }}">
                                            <a class="btn btn-default btn-xs disabled" href="#">
                                                <span class="fa fa-lg fa-pencil"></span> Edit
                                            </a>
                                        </div>
                                    </td>
                                    <td>
                                        <a class="btn btn-info btn-xs" href="{{ route('activities.show', $activity->activity_id) }}">
                                            <span class="fa fa-lg fa-eye"></span> Details
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
                                <th class="col-md-2" data-field="location_from" data-sortable="true" data-searchable="true" data-halign="center" data-align="center" data-valign="middle">Branch</th>
                                <th class="col-md-2" data-field="location_to" data-sortable="true" data-searchable="true" data-halign="center" data-align="center" data-valign="middle">Appointment Venue</th>
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
                                    <td>{!! $activity->getApplicationStatus() !!}</td>
                                    <td>
                                        <div data-toggle="tooltip" data-placement="top" title="{{ $activity->getTooltipStatus() }}">
                                            <a class="btn btn-default btn-xs disabled" href="#">
                                                <span class="fa fa-lg fa-pencil"></span> Edit
                                            </a>
                                        </div>
                                    </td>
                                    <td>
                                        <a class="btn btn-info btn-xs" href="{{ route('activities.show', $activity->activity_id) }}">
                                            <span class="fa fa-lg fa-eye"></span> Details
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
                                <th class="col-md-2" data-field="location_from" data-sortable="true" data-searchable="true" data-halign="center" data-align="center" data-valign="middle">Branch</th>
                                <th class="col-md-2" data-field="location_to" data-sortable="true" data-searchable="true" data-halign="center" data-align="center" data-valign="middle">Appointment Venue</th>
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
                                    <td>{!! $activity->getApplicationStatus() !!}</td>
                                    <td>
                                        @if (str_contains($activity->getApplicationStatus(), 'No application'))
                                            <a class="btn btn-default btn-xs" href="{{ route('activities.edit', $activity->activity_id) }}">
                                                <span class="fa fa-lg fa-pencil"></span> Edit
                                            </a>
                                        @else
                                            <div data-toggle="tooltip" data-placement="top" title="{{ $activity->getTooltipStatus() }}">
                                                <a class="btn btn-default btn-xs disabled" href="#">
                                                    <span class="fa fa-lg fa-pencil"></span> Edit
                                                </a>
                                            </div>
                                        @endif
                                    </td>
                                    <td>
                                        <a class="btn btn-info btn-xs" href="{{ route('activities.show', $activity->activity_id) }}">
                                            <span class="fa fa-lg fa-eye"></span> Details
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

@section('auth-script')

@include('auth._redirect_if_no_auth')

@endsection
