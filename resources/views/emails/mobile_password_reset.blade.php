{{-- Email for volunteer whose password is updated on CareGuide mobile --}}
<p>Hi {{ $volunteer->name }}</p>
<br>
<p>The password for your {{ $volunteer->email }} CareGuide account was recently changed.</p>
<br>
<p>If you have initiated this request, you don't need to take any further action and can safely disregard this email.</p>
<br>
<p>Should you ever encounter problems, please contact us at <a href="mailto:{{ env('MAIL_CONTACT') }}">{{ env('MAIL_CONTACT') }}</a>.</p>
<p>This is a system generated email so please do not reply to this email.</p>
