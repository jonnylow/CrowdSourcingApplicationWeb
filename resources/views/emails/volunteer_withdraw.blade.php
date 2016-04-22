{{-- Email for staff when a volunteer withdraws from an activity --}}
<p> {{ $volunteer->email }} has withdrawn from an activity.</p>
<br>
<p>The withdrawn activity is :</p>
<ul>
    <li>Activity ID: {{ $withdrawnActivity->activity_id }}</li>
    <li>Date/Time of Activity: {{ $withdrawnActivity->datetime_start }}</li>
    <li>View it here:<a href="{{ $link = url('activities', [$withdrawnActivity->activity_id]) }}">{{ $link }}</a></li>
</ul>
<p>Should you have any questions, please contact us at <a href="mailto:{{ env('MAIL_CONTACT') }}">{{ env('MAIL_CONTACT') }}</a>.</p>
<p>This is a system generated email so please do not reply to this email.</p>
