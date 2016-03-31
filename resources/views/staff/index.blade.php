@extends('layouts.master')

@section('title', 'Staff')

@section('content')

<div class="container-fluid margin-bottom-lg">
    <div class="row margin-bottom-sm">
        <div class="col-md-3"><a href="staff/create" class="btn btn-primary btn-lg">Add new Staff</a></div>
    </div>

    <div class="row margin-bottom-sm">
        <div class="col-md-6 col-md-offset-3">
            @include('errors.list')
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading"><h4>Staff List</h4></div>
                <div class="panel-body table-responsive">
                    <table class="table table-striped table-bordered table-hover" data-toggle="table" data-pagination="true" data-search="true" data-sort-name="name" data-cookie="true" data-cookie-id-table="staff">
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
                                    <td>{{ $staff->is_admin ? "Administrator" : "Regular Staff" }}</td>
                                    <td>{{ $staff->centres->lists('name')->sort()->implode(', ') }}</td>
                                    <td>
                                        @if (Auth::user()->staff_id === $staff->staff_id && ! Auth::user()->is_admin)
                                            <div data-toggle="tooltip" data-placement="top" title="You cannot edit your own profile.">
                                                <a class="btn btn-default btn-xs disabled" href="#">
                                                    <span class="fa fa-lg fa-pencil"></span> Edit
                                                </a>
                                            </div>
                                        @else
                                            <a class="btn btn-default btn-xs" href="{{ route('staff.edit', $staff->staff_id) }}">
                                                <span class="fa fa-lg fa-pencil"></span> Edit
                                            </a>
                                        @endif
                                    </td>
                                    <td>
                                        @if (Auth::user()->staff_id === $staff->staff_id)
                                            <div data-toggle="tooltip" data-placement="top" title="You cannot remove your own profile.">
                                                <a class="btn btn-danger btn-xs disabled" href="#">
                                                    <span class="fa fa-lg fa-trash"></span> Remove
                                                </a>
                                            </div>
                                        @else
                                            {!! Form::open(['method' => 'DELETE', 'route' => ['staff.destroy', $staff->staff_id]]) !!}
                                                <a class="btn btn-danger btn-xs" type="submit" data-toggle="modal" data-target="#confirmModal" data-size="modal-sm"
                                                   data-type="warning" data-title="Remove Staff" data-message="Are you sure you want to remove {{ $staff->name }}?"
                                                   data-yes="Remove" data-no="Cancel">
                                                    <span class="fa fa-lg fa-trash"></span> Remove
                                                </a>
                                            {!! Form::close() !!}
                                        @endif
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

@include('partials.confirm')

@endsection

@section('page-script')

<script>
    $(document).ready(function() {
        $('.bootstrap-table .fixed-table-toolbar .search input').attr('placeholder', 'Search staff');
    });
</script>

@endsection

@section('partials-script')

@include('partials.confirm')

@endsection

@section('auth-script')

@include('auth._redirect_if_no_auth')

@endsection
