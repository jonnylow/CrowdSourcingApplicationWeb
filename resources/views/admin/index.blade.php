@extends('layouts.master')

@section('title', 'Admin Page')

@section('content')

<div class="container-fluid">
    <div class="row margin-bottom-md">
        <div class="col-md-3"><a href="admin/create" class="btn btn-default btn-md">Add new staff</a></div>
    </div>

    <div class="row margin-bottom-lg">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading"><h4>Staff List</h4></div>
                <div class="panel-body table-responsive">
                    <table class="table table-striped table-bordered table-hover" data-toggle="table" data-pagination="true" data-search="true">
                        <thead>
                            <tr>
                                <th class="col-md-2" data-field="name" data-sortable="true" data-searchable="true" data-halign="center" data-align="center" data-valign="middle">Name</th>
                                <th class="col-md-3" data-field="email" data-sortable="true" data-searchable="true" data-halign="center" data-align="center" data-valign="middle">Email</th>
                                <th class="col-md-2" data-field="admin" data-sortable="true" data-searchable="true" data-halign="center" data-align="center" data-valign="middle">Staff Type</th>
                                <th class="col-md-3" data-field="centres" data-sortable="true" data-searchable="true" data-halign="center" data-align="center" data-valign="middle">Centres</th>
                                <th class="col-md-1" data-align="center" data-valign="middle"></th>
                                <th class="col-md-1" data-align="center" data-valign="middle"></th>
                            </tr>
                        </thead>
                        <tbody>
                        @if (count($centreStaff))
                            @foreach ($centreStaff as $staff)
                                <tr>
                                    <td>{{ $staff->name }}</td>
                                    <td>{{ $staff->email }}</td>
                                    <td>{{ $staff->is_admin }}</td>
                                    <td>{{ $staff->centres->lists('name')->sort()->implode(', ') }}</td>
                                    <td>
                                        <a class="btn btn-info btn-xs" href="{{ route('admin.edit' ,[$staff->staff_id]) }}">
                                            <span class="glyphicon glyphicon-pencil"></span> Edit
                                        </a>
                                    </td>
                                    <td>
                                        <a class="btn btn-danger btn-xs" href="{{ route('admin.destroy' ,[$staff->staff_id]) }}">
                                            <span class="glyphicon glyphicon-remove"></span> Delete
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
