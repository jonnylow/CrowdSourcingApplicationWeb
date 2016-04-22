{{-- Email for staff when a volunteer registered an account on CareGuide mobile --}}
<p>A new {{ $volunteer->email }} CareGuide volunteer account has been registered.</p>
<p>The account is awaiting for approval and you can contact the volunteer for his orientation at:</p>
<ul>
    <li>Name: {{ $volunteer->name }}</li>
    <li>Contact: {{ $volunteer->contact_no }}</li>
</ul>
<br>
<p>Should you have any questions, please contact us at <a href="mailto:{{ env('MAIL_CONTACT') }}">{{ env('MAIL_CONTACT') }}</a>.</p>
<p>This is a system generated email so please do not reply to this email.</p>
