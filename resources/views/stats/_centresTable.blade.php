{{-- Subchart view partial when all centres are selected --}}
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

<script type="text/javascript" src="{{ asset('js/bootstrap-table.min.js') }}"></script>
