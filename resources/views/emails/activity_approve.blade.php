{{-- Email for volunteer who is approved for an activity --}}
<p>The application for your CareGuide activity on {{ $activity->datetime_start->format('D, j M Y, g:i a') }} has been <strong>accepted</strong>.</p>
<br>
<p>Please be at {{ $activity->departureCentre->name }} by {{ $activity->datetime_start->format('D, j M Y, g:i a') }}.</p>
<br>
<p>Should you have any questions, please contact us at <a href="mailto:{{ env('MAIL_CONTACT') }}">{{ env('MAIL_CONTACT') }}</a>.</p>
<p>This is a system generated email so please do not reply to this email.</p>
