@extends('layouts.master')

@section('title', $activity->departureCentre->name . ' &lrarr; ' . $activity->arrivalCentre->name)

@section('content')

<div class="container-fluid margin-bottom-lg">
    <div class="row margin-bottom-xs">
        <div class="col-md-12">
            <div class="col-md-3 hidden-sm hidden-xs text-left"><h1>{{ $activity->departureCentre->name }}</h1></div>
            <div class="col-md-1 hidden-sm hidden-xs text-center"><h1><span class="glyphicon glyphicon-arrow-right"></span></h1></div>
            <div class="col-md-4 hidden-sm hidden-xs text-center"><h1>{{ $activity->arrivalCentre->name }}</h1></div>
            <div class="col-md-1 hidden-sm hidden-xs text-center"><h1><span class="glyphicon glyphicon-arrow-right"></span></h1></div>
            <div class="col-md-3 hidden-sm hidden-xs text-right"><h1>{{ $activity->departureCentre->name }}</h1></div>
            <div class="hidden-lg hidden-md"><h3>Activity Progress:</h3></div>
        </div>
        <div class="col-md-12">
            <div class="progress">
                @if ($activity->getProgress() <= 0)
                    <p class="text-center text-uppercase"><strong>Activity not started</strong></p>
                @else
                    <div class="progress-bar progress-bar-success" style="width:{{ $activity->getProgress() }}%">
                        <span class="sr-only">{{ $activity->getProgress() }}%</span>
                        <p class="text-center text-uppercase"><strong>
                        @if ($activity->getProgress() <= 25)
                            Heading to check-up...
                        @elseif ($activity->getProgress() <= 50)
                            At check-up...
                        @elseif ($activity->getProgress() <= 75)
                            Heading back to centre...
                        @elseif ($activity->getProgress() == 100)
                            Back at centre...
                        @endif
                        </strong></p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            @include('errors.list')

            <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">

                <div class="panel panel-default">
                    <div class="panel-heading" role="tab" id="heading-information">
                        <h4 class="panel-title">
                            <a role="button" data-toggle="collapse" href="#collapse-information" aria-expanded="true" aria-controls="collapse-information">
                                <span class="fa fa-fw fa-calendar"></span>
                                <strong>Activity Information</strong>
                                <span class="icon-arrow fa fa-lg fa-chevron-up"></span>
                            </a>
                        </h4>
                    </div>
                    <div id="collapse-information" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="heading-information">
                        <div class="panel-body">
                            <dl class="dl-horizontal">
                                <dt>Start Date:</dt>
                                <dd>
                                    {{ $activity->datetime_start->format('D, j M Y') }}
                                    @if ($activity->datetime_start->isFuture() && $activity->getProgress() <= 0)
                                        {!! Form::open(['method' => 'DELETE', 'route' => ['activities.destroy', $activity->activity_id], 'id' => 'form-activity-cancel']) !!}
                                        <a href="#" type="submit" data-toggle="modal" data-target="#confirmModal" data-size="modal-sm"
                                           data-type="warning" data-title="Cancel Activity" data-message="Are you sure you want to cancel this activity?"
                                           data-yes="Yes" data-no="No">
                                            <span class="badge alert-danger">Cancel Activity</span>
                                        </a>
                                        {!! Form::close() !!}
                                    @endif
                                </dd>
                                <dt>Start Time:</dt><dd>{{ $activity->datetime_start->format('g:i a') }}</dd>
                                <dt>Expected End Time:</dt><dd>{{ $activity->datetime_start->addMinutes($activity->expected_duration_minutes)->format('g:i a') }}</dd>
                                <dt>Duration:</dt><dd>{{ $activity->durationString() }}</dd>
                                <dt>Senior's Name:</dt><dd>{{ $activity->elderly->name }} <a href="{{ route('elderly.show', $activity->elderly_id) }}"><span class="badge alert-info">Details</span></a></dd>
                                <br>
                                <dt>Additional Info:</dt><dd>{{ $activity->more_information }}</dd>
                            </dl>
                        </div>
                    </div>
                </div>

                <div class="panel panel-default">
                    <div class="panel-heading" role="tab" id="heading-address">
                        <h4 class="panel-title">
                            <a role="button" data-toggle="collapse" href="#collapse-address" aria-expanded="true" aria-controls="collapse-address">
                                <span class="fa fa-fw fa-map-marker"></span>
                                <strong>Venue Addresses</strong>
                                <span class="icon-arrow fa fa-lg fa-chevron-up"></span>
                            </a>
                        </h4>
                    </div>
                    <div id="collapse-address" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="heading-address">
                        <div class="panel-body">
                            <dl class="dl-horizontal">
                                <dt>Start From:</dt>
                                <dd><address><strong>{{ $activity->departureCentre->name }}</strong><br>{{ $activity->departureCentre->address }}</address></dd>
                                <dt>Check-up At:</dt>
                                <dd><address><strong>{{ $activity->arrivalCentre->name }}</strong><br>{{  $activity->arrivalCentre->address }}</address></dd>
                            </dl>
                        </div>
                    </div>
                </div>

                <div class="panel panel-default">
                    <div class="panel-heading" role="tab" id="heading-volunteer">
                        <h4 class="panel-title">
                            <a role="button" data-toggle="collapse" href="#collapse-volunteer" aria-expanded="true" aria-controls="collapse-volunteer">
                                <span class="fa fa-fw fa-heart"></span>
                                <strong>Volunteer Sign-ups</strong>
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
                                        <th class="col-md-3" data-field="volunteer_name" data-sortable="true" data-searchable="true" data-halign="center" data-align="center" data-valign="middle">Applicant Name</th>
                                        <th class="col-md-1" data-field="gender" data-sortable="true" data-searchable="true" data-halign="center" data-align="center" data-valign="middle">Gender</th>
                                        <th class="col-md-1" data-field="age" data-sortable="true" data-searchable="true" data-halign="center" data-align="center" data-valign="middle">Age</th>
                                        <th class="col-md-1" data-field="rank" data-sortable="true" data-searchable="true" data-halign="center" data-align="center" data-valign="middle">Rank</th>
                                        <th class="col-md-2" data-field="status" data-sortable="true" data-halign="center" data-align="center" data-valign="middle">Status</th>
                                        <th class="col-md-2" data-field="applied_time" data-sortable="true" data-halign="center" data-align="center" data-valign="middle">Applied on</th>
                                        <th class="col-md-1" data-align="center" data-valign="middle"></th>
                                        <th class="col-md-1" data-align="center" data-valign="middle"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                @if ($activity->volunteers->count() > 0)
                                    @foreach ($activity->volunteers as $volunteer)
                                        <tr>
                                            <td><a class="btn btn-info btn-xs" href="{{ route('volunteers.show', $volunteer->volunteer_id) }}">Details</a></td>
                                            <td>{{ $volunteer->name }}</td>
                                            <td>{{ $volunteer->gender == 'M' ? 'Male' : 'Female' }}</td>
                                            <td>{{ $volunteer->age() }} <abbr title="years old">y/o</abbr></td>
                                            <td>{{ $volunteer->rank->name }}</td>
                                            <td>{{ ucwords($volunteer->pivot->approval) }}</td>
                                            <td>{{ $volunteer->pivot->created_at ? $volunteer->pivot->created_at->format('j M Y, g:i a') : 'NA' }}</td>
                                            <td>
                                                @if($volunteer->pivot->approval == "withdrawn" || $volunteer->pivot->approval == "rejected" ||
                                                    $activity->datetime_start->isPast() || $activity->hasApprovedVolunteer())
                                                    <a class="btn btn-danger btn-xs disabled"><span class="fa fa-lg fa-times"></span> Reject</a>
                                                @else
                                                    {!! Form::open(['method' => 'PATCH', 'route' => ['activities.reject.volunteer', $activity->activity_id, $volunteer->volunteer_id]]) !!}
                                                        <a class="btn btn-danger btn-xs" type="submit" data-toggle="modal" data-target="#confirmModal" data-size="modal-sm"
                                                           data-type="textbox" data-title="Reject Volunteer" data-message="Reason for rejecting {{ $volunteer->name }}:"
                                                           data-yes="Reject" data-no="Cancel">
                                                            <span class="fa fa-lg fa-times"></span> Reject
                                                        </a>
                                                        {!! Form::hidden('comment', null, ['class' => 'form-control']) !!}
                                                    {!! Form::close() !!}
                                                @endif
                                            </td>
                                            <td>
                                                @if($volunteer->pivot->approval == "withdrawn" || $volunteer->pivot->approval == "rejected" ||
                                                    $activity->datetime_start->isPast() || $activity->hasApprovedVolunteer())
                                                    <a class="btn btn-success btn-xs disabled"><span class="fa fa-lg fa-check"></span> Approve</a>
                                                @else
                                                    {!! Form::open(['method' => 'PATCH', 'route' => ['activities.approve.volunteer', $activity->activity_id, $volunteer->volunteer_id]]) !!}
                                                        <a class="btn btn-success btn-xs" type="submit" data-toggle="modal" data-target="#confirmModal" data-size="modal-sm"
                                                           data-type="question" data-title="Approve Volunteer" data-message="Are you sure you want to approve {{ $volunteer->name }}? This will reject all other volunteers."
                                                           data-yes="Approve" data-no="Cancel">
                                                            <span class="fa fa-lg fa-check"></span> Approve
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
    </div>
</div>

@include('partials.confirm')

@endsection

@section('page-script')

<script>
    var currentProgress = 0;

    if ($('div.progress').find('div.progress-bar').length)
        currentProgress = parseFloat($('div.progress-bar>span').html()) / 100.0;

    (function poll() {
        setTimeout(function () {
            $.ajax({
                type: 'GET',
                dataType: 'json',
                url: '{{ asset('/activities/' . $activity->activity_id . '/progress') }}',
                success: function (data) {
                    var progress = parseInt(data.progress);

                    if(progress > 0 && currentProgress < progress) {
                        currentProgress = progress;
                        var label = "Activity not started";

                        if (progress <= 25)
                            label = "Heading to check-up...";
                        else if (progress <= 50)
                            label = "At check-up...";
                        else if (progress <= 75)
                            label = " Heading back to centre...";
                        else if (progress == 100)
                            label = "Back at centre...";

                        if ($('div.progress').find('div.progress-bar').length) {
                            $('div.progress-bar').css('width', progress + "%");
                            $('div.progress-bar>span').html(progress + "%");
                            $('div.progress-bar>p>strong').html(label);
                        } else {
                            $('#form-activity-cancel').remove();
                            $('div.progress').empty();
                            $('div.progress').append('<div class="progress-bar progress-bar-success" style="width:' + progress + '%"></div>');
                            $('div.progress-bar').append('<span class="sr-only">' + progress + '%</span>');
                            $('div.progress-bar').append('<p class="text-center text-uppercase"><strong>' + label + '</strong></p>');
                        }
                    }
                },
                complete: poll
            });
        }, 15000);
    })();
</script>

@endsection

@section('partials-script')

@include('partials.confirm')

@endsection
