@extends('layouts.master')

@section('title', 'Cancelled Activities')

@section('content')

<div class="container-fluid margin-bottom-lg">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading"><h4>Cancelled Activity List</h4></div>
                <div class="panel-body table-responsive">
                    <table class="table table-striped table-bordered table-hover" data-toggle="table" data-pagination="true" data-search="true" data-cookie="true" data-cookie-id-table="cancelledActivities">
                        <thead>
                        <tr>
                            <th class="col-md-2" data-field="location_from" data-sortable="true" data-searchable="true" data-halign="center" data-align="center" data-valign="middle">Branch</th>
                            <th class="col-md-2" data-field="location_to" data-sortable="true" data-searchable="true" data-halign="center" data-align="center" data-valign="middle">Appointment Venue</th>
                            <th class="col-md-3" data-field="datetime_start" data-sortable="true" data-searchable="true" data-halign="center" data-align="center" data-valign="middle">Start Date & Time</th>
                            <th class="col-md-2" data-field="senior" data-sortable="true" data-searchable="true" data-halign="center" data-align="center" data-valign="middle">Senior's Name</th>
                            <th class="col-md-3" data-field="cancelled_date" data-sortable="true" data-searchable="true" data-halign="center" data-align="center" data-valign="middle">Cancelled Date</th>
                        </tr>
                        </thead>
                        <tbody>
                        @if (count($activities))
                            @foreach ($activities as $activity)
                                <tr>
                                    <td>{{ $activity->departureCentre->name }}</td>
                                    <td>{{ $activity->arrivalCentre->name }}</td>
                                    <td>{{ $activity->datetime_start->format('D, j M Y, g:i a') }}</td>
                                    <td>{{ $activity->elderly()->withTrashed()->first()->name }}</td>
                                    <td>{{ $activity->deleted_at->format('D, j M Y, g:i a') }} </td>
                                </tr>
                            @endforeach
                        @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div> <!-- /.row -->
</div> <!-- /.container-fluid -->

@endsection

@section('page-script')

<script>
    $(document).ready(function() {
        $('.fixed-table-toolbar .search input').attr('placeholder', 'Search cancelled activities');
    });
</script>

@endsection

@section('auth-script')

@include('auth._redirect_if_no_auth')

@endsection
