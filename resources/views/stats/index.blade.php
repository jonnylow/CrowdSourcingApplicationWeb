@extends('layouts.master')

@section('title', 'Statistics')

@section('content')

<div class="container-fluid margin-bottom-lg">
    <div class="row margin-bottom-sm">
        <div class="col-md-7 form-group">
            <div class="col-md-5"><h1>Statistics for:</h1></div>
            <div class="col-md-7 centre-list">{!! Form::select('centre', $centreList, null, ['class' => 'form-control', 'id' => 'centre', 'required']) !!}</div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="col-md-6" id="mainCharts"><canvas id="mainChart" width="300" height="300"></canvas></div>
            <div class="col-md-6 table-responsive" id="subCharts">
                <table class="table table-striped table-bordered table-hover" data-toggle="table">
                    <thead>
                    <tr>
                        <th class="col-md-4" rowspan="2" data-field="centre" data-sortable="true" data-halign="center" data-align="center" data-valign="middle">Centre</th>
                        <th class="col-md-8" colspan="3" data-halign="center" data-align="center" data-valign="middle">Total number of</th>
                    </tr>
                    <tr>
                        <th data-field="activities" data-sortable="true" data-halign="center" data-align="center" data-valign="middle">Activities</th>
                        <th data-field="senior" data-sortable="true" data-halign="center" data-align="center" data-valign="middle">Seniors</th>
                        <th data-field="staff" data-sortable="true" data-halign="center" data-align="center" data-valign="middle">Staff</th>
                    </tr>
                    </thead>
                    <tbody>
                    @if (count($centreActivities))
                        @foreach($centreActivities as $centre)
                            <tr>
                                <td>{{ $centre->name }}</td>
                                <td>{{ $centre->activities()->withTrashed()->count() }}</td>
                                <td>{{ $centre->elderly()->count() }}</td>
                                <td>{{ $centre->staff()->count() }}</td>
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

@section('page-script')

<script type="text/javascript" src="{{ asset('js/chart.min.js') }}"></script>

<style>
    .centre-list { margin-top: 20px }
</style>

<script>
    var ctx = $("#mainChart");
    var mainChart = new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: ["0"],
            datasets: [{
                data: [0],
                backgroundColor: [
                    "#FFFFFF"
                ],
                hoverBackgroundColor: [
                    "#FFFFFF"
                ]
            }]
        },
        options: {
            legend: {
                display: false
            }
        }
    });

    function getMainCharts() {
        mainChart.destroy();
        var centre = $("select[name='centre']").val();
        $.ajax({
            url: '{{ asset('stats/getMainCharts') }}',
            method: "GET",
            data: {centre: centre},
            dataType: "json"
        })
        .done(function(result) {
            mainChart = new Chart(ctx, result);
        });
    }

    function getSubCharts() {
        $('#subCharts').empty();
        var centre = $("select[name='centre']").val();
        $.ajax({
            url: '{{ asset('stats/getSubCharts') }}',
            method: "GET",
            data: {centre: centre},
            dataType: "json"
        })
        .done(function(result) {
            $('#subCharts').html(result['html']);
        });
    }

    $('#mainChart').on('click', function(e) {
        var activePt = mainChart.getElementAtEvent(e);
        if (typeof activePt[0] !== 'undefined') {
            if (activePt[0]['_chart']['config']['type'] === 'doughnut') {
                var centre = activePt[0]['_model']['label'];
                $('#centre option:contains(' + centre + ')').attr('selected', 'true');
                getMainCharts();
                getSubCharts();
            }
        }
    });

    $('#centre').on('change', function() {
        getMainCharts();
        getSubCharts();
    });

    $(document).ready(function() {
        getMainCharts();
    });
</script>

@endsection

@section('auth-script')

@include('auth._redirect_if_no_auth')

@endsection
