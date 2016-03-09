<p>You have a new activity application from  {{ $user->email }}. Please log in to review the volunteer.</p>
<br>
<p>The applied activity is :</p>
<ul>
    <li>Activity ID: {{ $appliedActivity->activity_id }}</li>
    <li>Date/Time of Activity: {{ $appliedActivity->datetime_start }}</li>
   	<li>Approve it here:<a href="{{ $link = url('activities', [$appliedActivity->activity_id]) }}">{{ $link }}</a></li>
</ul>
<p>Should you have any questions, please contact us at <a href="mailto:imchosen6@gmail.com">imchosen6@gmail.com</a>.</p>
<p>This is a system generated email so please do not reply to this email.</p>
