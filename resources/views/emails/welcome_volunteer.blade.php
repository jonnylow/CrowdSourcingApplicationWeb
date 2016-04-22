{{-- Email for volunteer whose account is created on CareGuide web --}}
<p>
    <strong>Welcome to CareGuide!</strong>
    You can login to your account using our app on <a href="https://appsto.re/sg/aDIjab.i">App Store</a> and <a href="https://play.google.com/store/apps/details?id=com.CareGuide">Google Play Store</a>.
</p>
<p>Your account credentials are:</p>
<ul>
    <li>Username: {{ $volunteer->email }}</li>
    <li>Password: {{ $randomString }}</li>
</ul>
<p>Should you ever encounter problems with your account, please contact us at <a href="mailto:{{ env('MAIL_CONTACT') }}">{{ env('MAIL_CONTACT') }}</a>.</p>
<p>This is a system generated email so please do not reply to this email.</p>
