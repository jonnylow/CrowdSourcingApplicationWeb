@extends('layouts.master')

@section('title', 'Activities Page')

@section('content')

<div class="container-fluid">
    <div class="row margin-bottom-md">
        <div class="col-md-3"><a href="activities/create" class="btn btn-default btn-md">Add new activity</a></div>
    </div>

    <div class="row margin-bottom-lg">
        <div class="col-md-12">
            <div class="panel panel-primary">
                <div class="panel-heading"><span class="glyphicon glyphicon-list-alt"></span> Upcoming Activities</div>
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover text-center" data-toggle="table" data-sort-name="activity" data-sort-order="desc">
                        <thead>
                            <tr>
                                <th class="col-md-4" data-field="activity" data-sortable="true">Activity Name</th>
                                <th class="col-md-2" data-field="start_date" data-sortable="true">Start Date & Time</th>
                                <th class="col-md-2" data-field="senior" data-sortable="true">Senior's Name</th>
                                <th class="col-md-2" data-field="status" data-sortable="true">Status</th>
                                <th class="col-md-1">Manage Activity</th>
                                <th class="col-md-1">View Volunteer(s)</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Test</td>
                                <td>Test</td>
                                <td>Test</td>
                                <td>Test</td>
                                <td><button type="" class="btn btn-default btn-xs">Edit activity</button></td>
                                <td><button type="" class="btn btn-default btn-xs">View list</button></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

</div>

@endsection
