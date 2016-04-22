{{-- Email for staff when feedback is received from CareGuide mobile --}}
<p>Hi!</p>
<br>
<p>You have a new feedback from  {{ $email }}.</p>
<br>
<p>This is the feedback as follows :{{ $feedback }} </p>
<br>
<p>Should you ever encounter problems, please contact us at <a href="mailto:{{ env('MAIL_CONTACT') }}">{{ env('MAIL_CONTACT') }}</a>.</p>
<p>This is a system generated email so please do not reply to this email.</p>
