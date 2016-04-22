{{-- Email for volunteer whose account is approved or rejected --}}
<p>The application for your {{ $volunteer->email }} CareGuide account has been <strong>{{ $volunteer->is_approved }}</strong>.</p>
<br>
<p>Should you have any questions, please contact us at <a href="mailto:{{ env('MAIL_CONTACT') }}">{{ env('MAIL_CONTACT') }}</a>.</p>
<p>This is a system generated email so please do not reply to this email.</p>
