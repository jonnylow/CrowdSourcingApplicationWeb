{{-- Email for staff whose account is created on CareGuide web --}}
<p>
    <strong>Welcome to CareGuide!</strong>
    You can login to your account at <a href="{{ asset('/') }}">{{ asset('/') }}</a>.
</p>
<p>Your account credentials are:</p>
<ul>
    <li>Username: {{ $staff->email }}</li>
    <li>Password: {{ $randomString }}</li>
</ul>
<p>Should you ever encounter problems with your account, please contact us at <a href="mailto:{{ env('MAIL_CONTACT') }}">{{ env('MAIL_CONTACT') }}</a>.</p>
<p>This is a system generated email so please do not reply to this email.</p>
