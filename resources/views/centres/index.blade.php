@extends('layouts.master')

@section('title', 'Locations')

@section('content')

<div class="container-fluid margin-bottom-lg">
    <div class="row margin-bottom-sm">
        <div class="col-md-3"><a href="centres/create" class="btn btn-primary btn-lg">Add new Location</a></div>
    </div>

    <div class="row margin-bottom-sm">
        <div class="col-md-6 col-md-offset-3">
            @include('errors.list')
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading"><h4>Location List</h4></div>
                <div class="panel-body table-responsive">
                    <table class="table table-striped table-bordered table-hover" data-toggle="table" data-pagination="true" data-search="true" data-sort-name="name" data-cookie="true" data-cookie-id-table="locations">
                        <thead>
                            <tr>
                                <th class="col-md-4" data-field="name" data-sortable="true" data-searchable="true" data-halign="center" data-align="center" data-valign="middle">Location Name</th>
                                <th class="col-md-5" data-field="address" data-sortable="true" data-searchable="true" data-halign="center" data-align="center" data-valign="middle">Address</th>
                                <th class="col-md-2" data-field="postal" data-sortable="true" data-searchable="true" data-halign="center" data-align="center" data-valign="middle">Postal Code</th>
                                <th class="col-md-1" data-align="center" data-valign="middle"></th>
                            </tr>
                        </thead>
                        <tbody>
                        @if (count($centres))
                            @foreach ($centres as $centre)
                                <tr>
                                    <td>{{ $centre->name }}</td>
                                    <td>{{ $centre->address }}</td>
                                    <td>{{ $centre->postal_code }}</td>
                                    <td>
                                        <a class="btn btn-default btn-xs" href="{{ route('centres.edit', $centre->centre_id) }}">
                                            <span class="fa fa-lg fa-pencil"></span> Edit
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
        $('.bootstrap-table .fixed-table-toolbar .search input').attr('placeholder', 'Search locations');
    });
</script>

@endsection

@section('auth-script')

@include('auth._redirect_if_no_auth')

@endsection
