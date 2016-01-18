<p><strong>Welcome to CareGuide!</strong>
    @if(isset($staff))
        You can login to your account at <a href="{{ asset('/') }}">{{ asset('/') }}</a>.
    @elseif(isset($volunteer))
        You can login to your account using our app on <a href="#">Google Play Store</a> and <a href="#">Apple App Store</a>.
    @endif
</p>
<p>Your account credentials are:</p>
<ul>
    <li>Username: {{ isset($staff) ? $staff->email : isset($volunteer) ? $volunteer->email : '' }}</li>
    <li>Password: {{ $randomString }}</li>
</ul>
<p>Should you ever encounter problems with your account, please contact us at xxx@xxx.xx.</p>
<p>This is a system generated email</p>
