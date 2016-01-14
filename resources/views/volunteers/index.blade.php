@extends('layouts.master')

@section('title', 'Volunteers')

@section('content')

    <div class="container-fluid">
        <div class="row margin-bottom-md">
            <div class="col-md-3"><a href="volunteers/create" class="btn btn-primary btn-lg">Add new Volunteer</a></div>
        </div>

        <div class="row margin-bottom-lg">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading"><h4>Volunteer List</h4></div>
                    <div class="panel-body table-responsive">
                        <table class="table table-striped table-bordered table-hover" data-toggle="table" data-pagination="true" data-search="true" data-sort-name="nric">
                            <thead>
                            <tr>
                                <th class="col-md-2" rowspan="2" data-field="nric" data-sortable="true" data-searchable="true" data-halign="center" data-align="center" data-valign="middle">NRIC</th>
                                <th class="col-md-2" rowspan="2" data-field="name" data-sortable="true" data-searchable="true" data-halign="center" data-align="center" data-valign="middle">Name</th>
                                <th class="col-md-1" rowspan="2" data-field="rank" data-sortable="true" data-halign="center" data-align="center" data-valign="middle">Rank</th>
                                <th class="col-md-2" rowspan="2" data-field="contact" data-sortable="true" data-searchable="true" data-halign="center" data-align="center" data-valign="middle">Contact Number</th>
                                <th class="col-md-1" rowspan="2" data-field="training" data-sortable="true" data-halign="center" data-align="center" data-valign="middle">Training Completed</th>
                                <th class="col-md-3" colspan="2" data-halign="center" data-align="center" data-valign="middle">Activities</th>
                                <th class="col-md-1" rowspan="2" data-align="center" data-valign="middle"></th>
                            </tr>
                            <tr>
                                <th class="col-md-1" data-field="completed" data-sortable="true" data-halign="center" data-align="center" data-valign="middle">Completed</th>
                                <th class="col-md-1" data-field="withdrawn" data-sortable="true" data-halign="center" data-align="center" data-valign="middle">Withdrawn</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if (count($volunteers))
                                @foreach ($volunteers as $volunteer)
                                    <tr>
                                        <td>{{ $volunteer->nric }}</td>
                                        <td>{{ $volunteer->name }}</td>
                                        <td>{{ $volunteer->rank->name }}</td>
                                        <td>{{ $volunteer->contact_no }}</td>
                                        <td>{{ $volunteer->is_approved ? "Yes" : "No" }}</td>
                                        <td>{{ $volunteer->numOfCompletedActivity() }}</td>
                                        <td>{{ $volunteer->numOfWithdrawnActivity() }}</td>
                                        <td>
                                            <a class="btn btn-info btn-xs" href="{{ route('volunteers.show' ,[$volunteer->volunteer_id]) }}">
                                                Details
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
