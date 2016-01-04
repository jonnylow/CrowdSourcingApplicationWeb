@extends('layouts.master')

@section('title', 'Seniors Page')

@section('content')

<div class="container-fluid">
    <div class="row margin-bottom-md">
        <div class="col-md-3"><a href="elderly/create" class="btn btn-default btn-md">Add new senior</a></div>
    </div>

    <div class="row margin-bottom-lg">
        <div class="col-md-12">
            <div class="table-responsive">
                <table class="table table-striped table-bordered table-hover" data-toggle="table" data-pagination="true" data-search="true">
                    <thead>
                        <tr>
                            <th class="col-md-1" rowspan="2" data-field="nric" data-sortable="true" data-searchable="true" data-halign="center" data-align="center" data-valign="middle">NRIC</th>
                            <th class="col-md-2" rowspan="2" data-field="name" data-sortable="true" data-searchable="true" data-halign="center" data-align="center" data-valign="middle">Name</th>
                            <th class="col-md-1" rowspan="2" data-field="gender" data-sortable="true" data-searchable="true" data-halign="center" data-align="center" data-valign="middle">Gender</th>
                            <th class="col-md-1" rowspan="2" data-field="centre" data-sortable="true" data-searchable="true" data-halign="center" data-align="center" data-valign="middle">Centre</th>
                            <th class="col-md-2" rowspan="2" data-field="languages" data-sortable="true" data-searchable="true" data-halign="center" data-align="center" data-valign="middle">Languages</th>
                            <th class="col-md-3" colspan="2" data-halign="center" data-align="center" data-valign="middle">Next-of-Kin</th>
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
                                <td>{{ $elderly->nric }}</td>
                                <td>{{ $elderly->name }}</td>
                                <td>{{ $elderly->gender }}</td>
                                <td>{{ $elderly->centre->name }}</td>
                                <td>{{ $elderly->languages->lists('language')->sort()->implode(', ') }}</td>
                                <td>{{ $elderly->next_of_kin_name }}</td>
                                <td>{{ $elderly->next_of_kin_contact }}</td>
                                <td>
                                    <a class="btn btn-info btn-xs" href="{{ route('elderly.edit' ,[$elderly->elderly_id]) }}">
                                        <span class="glyphicon glyphicon-pencil"></span> Edit
                                    </a>
                                </td>
                                <td>
                                    <a class="btn btn-danger btn-xs" href="{{ route('elderly.destroy' ,[$elderly->elderly_id]) }}">
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

@endsection
