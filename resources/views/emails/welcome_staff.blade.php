<p>
    <strong>Welcome to CareGuide!</strong>
    You can login to your account at <a href="{{ asset('/') }}">{{ asset('/') }}</a>.
</p>
<p>Your account credentials are:</p>
<ul>
    <li>Username: {{ $staff->email }}</li>
    <li>Password: {{ $randomString }}</li>
</ul>
<p>Should you ever encounter problems with your account, please contact us at xxx@xxx.xx.</p>
<p>This is a system generated email</p>