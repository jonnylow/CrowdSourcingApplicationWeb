@extends('layouts.master')

@section('title', 'Seniors')

@section('content')

<div class="container-fluid margin-bottom-lg">
    <div class="row margin-bottom-sm">
        <div class="col-md-3"><a href="elderly/create" class="btn btn-primary btn-lg">Add new Senior</a></div>
    </div>

    <div class="row margin-bottom-sm">
        <div class="col-md-6 col-md-offset-3">
            @include('errors.list')
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading"><h4>Senior List</h4></div>
                <div class="panel-body table-responsive">
                    <table class="table table-striped table-bordered table-hover" data-toggle="table" data-pagination="true" data-search="true">
                        <thead>
                            <tr>
                                <th class="col-md-1" rowspan="2" data-align="center" data-valign="middle"></th>
                                <th class="col-md-1" rowspan="2" data-field="nric" data-sortable="true" data-searchable="true" data-halign="center" data-align="center" data-valign="middle">NRIC</th>
                                <th class="col-md-2" rowspan="2" data-field="name" data-sortable="true" data-searchable="true" data-halign="center" data-align="center" data-valign="middle">Name</th>
                                <th class="col-md-1" rowspan="2" data-field="gender" data-sortable="true" data-searchable="true" data-halign="center" data-align="center" data-valign="middle">Gender</th>
                                <th class="col-md-1" rowspan="2" data-field="centre" data-sortable="true" data-searchable="true" data-halign="center" data-align="center" data-valign="middle">Centre</th>
                                <th class="col-md-2" rowspan="2" data-field="languages" data-sortable="true" data-searchable="true" data-halign="center" data-align="center" data-valign="middle">Languages</th>
                                <th class="col-md-2" colspan="2" data-halign="center" data-align="center" data-valign="middle">Next-of-Kin</th>
                                <th class="col-md-1" rowspan="2" data-align="center" data-valign="middle"></th>
                                <th class="col-md-1" rowspan="2" data-align="center" data-valign="middle"></th>
                            </tr>
                            <tr>
                                <th class="col-md-2" data-field="nok_name" data-sortable="true" data-searchable="true" data-halign="center" data-align="center" data-valign="middle">Name</th>
                                <th class="col-md-1" data-field="nok_contact" data-sortable="true" data-searchable="true" data-halign="center" data-align="center" data-valign="middle">Contact</th>
                            </tr>
                        </thead>
                        <tbody>
                        @if (count($elderlyInCentres))
                            @foreach ($elderlyInCentres as $elderly)
                                <tr>
                                    <td><a class="btn btn-info btn-xs" href="{{ route('elderly.show', $elderly->elderly_id) }}">Details</a></td>
                                    <td>{{ $elderly->nric }}</td>
                                    <td>{{ $elderly->name }}</td>
                                    <td>{{ $elderly->gender == 'M' ? 'Male' : 'Female' }}</td>
                                    <td>{{ $elderly->centre->name }}</td>
                                    <td>{{ $elderly->languages->lists('language')->sort()->implode(', ') }}</td>
                                    <td>{{ $elderly->next_of_kin_name }}</td>
                                    <td>{{ $elderly->next_of_kin_contact }}</td>
                                    <td>
                                        <a class="btn btn-default btn-xs" href="{{ route('elderly.edit', $elderly->elderly_id) }}">
                                            <span class="fa fa-lg fa-pencil"></span> Edit
                                        </a>
                                    </td>
                                    <td>
                                        {!! Form::open(['method' => 'DELETE', 'route' => ['elderly.destroy', $elderly->elderly_id]]) !!}
                                        <a class="btn btn-danger btn-xs" type="submit" data-toggle="modal" data-target="#confirmModal" data-size="modal-sm"
                                           data-type="warning" data-title="Remove Senior" data-message="Are you sure you want to remove {{ $elderly->name }}?"
                                           data-yes="Remove" data-no="Cancel">
                                            <span class="fa fa-lg fa-trash"></span> Remove
                                        </a>
                                        {!! Form::close() !!}
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

@section('partials-script')

@include('partials.confirm')

@endsection

@section('auth-script')

@include('auth._redirect_if_no_auth')

@endsection
