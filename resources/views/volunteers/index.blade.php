@extends('layouts.master')

@section('title', 'Volunteers')

@section('content')

<div class="container-fluid margin-bottom-lg">
    <div class="row margin-bottom-sm">
        <div class="col-md-3"><a href="volunteers/create" class="btn btn-primary btn-lg">Add new Volunteer</a></div>
    </div>

    <div class="row margin-bottom-sm">
        <div class="col-md-6 col-md-offset-3">
            @include('errors.list')
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading"><h4>Volunteer List</h4></div>
                <div class="panel-body table-responsive">
                    <table class="table table-striped table-bordered table-hover" data-toggle="table" data-pagination="true" data-search="true" data-sort-name="nric" data-cookie="true" data-cookie-id-table="volunteers">
                        <thead>
                            <tr>
                                <th class="col-md-2" rowspan="2" data-field="name" data-sortable="true" data-searchable="true" data-halign="center" data-align="center" data-valign="middle">Name</th>
                                <th class="col-md-1" rowspan="2" data-field="age" data-sortable="true" data-sorter="numericOnly" data-searchable="true" data-halign="center" data-align="center" data-valign="middle">Age</th>
                                <th class="col-md-1" rowspan="2" data-field="contact" data-sortable="true" data-searchable="true" data-halign="center" data-align="center" data-valign="middle">Contact Number</th>
                                <th class="col-md-1" rowspan="2" data-field="rank" data-sortable="true" data-halign="center" data-align="center" data-valign="middle">Rank</th>
                                <th class="col-md-1" rowspan="2" data-field="car" data-sortable="true" data-halign="center" data-align="center" data-valign="middle">Has Car</th>
                                <th class="col-md-1" rowspan="2" data-field="training" data-sortable="true" data-halign="center" data-align="center" data-valign="middle">Training Completed</th>
                                <th class="col-md-3" colspan="2" data-halign="center" data-align="center" data-valign="middle">Activities</th>
                                <th class="col-md-1" rowspan="2" data-align="center" data-valign="middle"></th>
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
                                    <td>{{ $volunteer->name }}</td>
                                    <td>{{ $volunteer->age() }} <abbr title="years old">y/o</abbr></td>
                                    <td>{{ $volunteer->contact_no }}</td>
                                    <td>{{ $volunteer->rank->name }}</td>
                                    <td>{{ $volunteer->has_car ? "Yes" : "No" }}</td>
                                    <td>{{ ucwords($volunteer->is_approved) }}</td>
                                    <td>{{ $volunteer->numOfCompletedActivity() }}</td>
                                    <td>{{ $volunteer->numOfWithdrawnActivity() }}</td>
                                    <td>
                                        <a class="btn btn-default btn-xs" href="{{ route('volunteers.edit', $volunteer->volunteer_id) }}">
                                            <span class="fa fa-lg fa-pencil"></span> Edit
                                        </a>
                                    </td>
                                    <td>
                                        <a class="btn btn-info btn-xs" href="{{ route('volunteers.show', $volunteer->volunteer_id) }}">
                                            <span class="fa fa-lg fa-eye"></span> Details
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

@section('page-script')

<script>
    $(document).ready(function() {
        $('.bootstrap-table .fixed-table-toolbar .search input').attr('placeholder', 'Search volunteers');
    });
</script>

@endsection

@section('auth-script')

@include('auth._redirect_if_no_auth')

@endsection
