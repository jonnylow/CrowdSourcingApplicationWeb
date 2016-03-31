@extends('layouts.master')

@section('title', $elderly->name)

@section('content')

<div class="container-fluid margin-bottom-lg">
    <div class="row margin-bottom-xs">
        <div class="col-md-10 col-md-offset-1">
            <div class="col-md-12">
                <h1>{{ $elderly->name }}</h1>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="row margin-bottom-sm">
                <div class="col-md-6 col-md-offset-3">
                    @include('errors.list')
                </div>
            </div>

            <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">

                <div class="panel panel-default">
                    <div class="panel-heading" role="tab" id="heading-information">
                        <h4 class="panel-title vertical-center">
                            <a role="button" data-toggle="collapse" href="#collapse-information" aria-expanded="true" aria-controls="collapse-information">
                                <span class="fa fa-fw fa-user"></span>
                                <strong>Information</strong>
                                <span class="icon-arrow fa fa-lg fa-chevron-up"></span>
                            </a>
                        </h4>
                        <a class="btn btn-primary btn-xs pull-right" href="{{ route('elderly.edit', $elderly->elderly_id) }}">
                            <span class="fa fa-lg fa-pencil"></span> Edit Senior
                        </a>
                        <div class="clearfix"></div>
                    </div>
                    <div id="collapse-information" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="heading-information">
                        <div class="panel-body">
                            <dl class="dl-horizontal">
                                <dt>NRIC:</dt><dd>{{ $elderly->nric }}</dd>
                                <dt>Age:</dt><dd>{{ $elderly->age() }} <abbr title="years old">y/o</abbr></dd>
                                <dt>Gender:</dt><dd>{{ $elderly->gender == 'M' ? 'Male' : 'Female' }}</dd>
                                <dt>Languages spoken:</dt><dd>{{ $elderly->languages->lists('language')->sort()->implode(', ') }}</dd>
                                <dt>Medical Condition:</dt><dd>{{ $elderly->medical_condition }}</dd>
                                <br>
                                <dt><abbr title="Next-of-Kin's">NOK's</abbr> Name:</dt><dd>{{ $elderly->next_of_kin_name }}</dd>
                                <dt><abbr title="Next-of-Kin's">NOK's</abbr> Contact:</dt><dd>{{ $elderly->next_of_kin_contact }}</dd>

                            </dl>
                        </div>
                    </div>
                </div>

                <div class="panel panel-default">
                    <div class="panel-heading" role="tab" id="heading-volunteer">
                        <h4 class="panel-title">
                            <a role="button" data-toggle="collapse" href="#collapse-volunteer" aria-expanded="true" aria-controls="collapse-volunteer">
                                <span class="fa fa-fw fa-history"></span>
                                <strong>Activity History</strong>
                                <span class="icon-arrow fa fa-lg fa-chevron-up"></span>
                            </a>
                        </h4>
                    </div>
                    <div id="collapse-volunteer" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="heading-volunteer">
                        <div class="panel-body table-responsive">
                            <table class="table table-striped table-bordered table-hover" data-toggle="table" data-pagination="true" data-search="true">
                                <thead>
                                    <tr>
                                        <th class="col-md-1" data-align="center" data-valign="middle"></th>
                                        <th class="col-md-2" data-field="start_date" data-sortable="true" data-searchable="true" data-halign="center" data-align="center" data-valign="middle">Start Date</th>
                                        <th class="col-md-1" data-field="start_time" data-sortable="true" data-searchable="true" data-halign="center" data-align="center" data-valign="middle">Start Time</th>
                                        <th class="col-md-1" data-field="end_time" data-sortable="true" data-searchable="true" data-halign="center" data-align="center" data-valign="middle">End Time</th>
                                        <th class="col-md-2" data-field="start_location" data-sortable="true" data-halign="center" data-align="center" data-valign="middle">Start Location</th>
                                        <th class="col-md-2" data-field="end_location" data-sortable="true" data-halign="center" data-align="center" data-valign="middle">End Location</th>
                                        <th class="col-md-3" data-field="volunteer" data-sortable="true" data-halign="center" data-align="center" data-valign="middle">Accompanying Volunteer</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @if (count($elderly->activities))
                                    @foreach ($elderly->activities as $activity)
                                        <tr>
                                            <td><a class="btn btn-info btn-xs" href="{{ route('activities.show', $activity->activity_id) }}">Details</a></td>
                                            <td>{{ $activity->datetime_start->format('D, j M Y') }}</td>
                                            <td>{{ $activity->datetime_start->format('g:i a') }}</td>
                                            <td>{{ $activity->datetime_start->addMinutes($activity->expected_duration_minutes)->format('g:i a') }}</td>
                                            <td>{{ $activity->departureCentre->name }}</td>
                                            <td>{{ $activity->arrivalCentre->name }}</td>
                                            <td>{{ $activity->getApprovedVolunteer() ? $activity->getApprovedVolunteer()->name : '' }}</td>
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
    </div>
</div>

@include('partials.confirm')

@endsection

@section('partials-script')

@include('partials.confirm')

@endsection
