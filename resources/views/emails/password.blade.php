<p>To initiate the password reset process for your {{ $user->getEmailForPasswordReset() }} CareGuide account, click the link below:</p>
<br>
<a href="{{ $link = url('password/reset', $token).'?email='.urlencode($user->getEmailForPasswordReset()) }}">{{ $link }}</a>
<br>
<p>If you've received this email in error, it's likely that another user entered your email by mistake while trying to reset a password.</p>
<p>If you didn't initiate the request, you don't need to take any further action and can safely disregard this email.</p>
<br>
<p>Should you ever encounter problems, please contact us at <a href="mailto:imchosen6@gmail.com">imchosen6@gmail.com</a>.</p>
<p>This is a system generated email so please do not reply to this email.</p>
