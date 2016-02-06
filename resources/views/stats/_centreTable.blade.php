<table class="table table-striped table-bordered table-hover" data-toggle="table">
    <thead>
        <tr>
            <th class="col-md-12" colspan="4" data-halign="center" data-align="center" data-valign="middle">
                Number of Upcoming Activities that are
            </th>
        </tr>
        <tr>
            <th class="col-md-3" data-field="unfilled" data-halign="center" data-align="center" data-valign="middle">
                <abbr title="Activities with no volunteer sign-up">Unfilled</abbr>
            </th>
            <th class="col-md-3" data-field="urgent" data-halign="center" data-align="center" data-valign="middle">
                <abbr title="Activities starting in a week but still unfilled">Urgent</abbr>
            </th>
            <th class="col-md-3" data-field="awaiting" data-halign="center" data-align="center" data-valign="middle">
                <abbr title="Activities with volunteer still waiting for approval">Awaiting Approval</abbr>
            </th>
            <th class="col-md-3" data-field="approved" data-halign="center" data-align="center" data-valign="middle">
                <abbr title="Activities with approved volunteer">Approved</abbr>
            </th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>{{ $unfilled->count() }}</td>
            <td>{{ $urgent->count() }}</td>
            <td>{{ $awaitingApproval->count() }}</td>
            <td>{{ $approved->count() }}</td>
        </tr>
    </tbody>
</table>

<script type="text/javascript" src="{{ asset('js/bootstrap-table.min.js') }}"></script>
