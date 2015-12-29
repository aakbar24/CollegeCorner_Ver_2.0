<br />
<div>
	<table border="1" cellspacing="0" cellpadding="3" style="font:12px Arial;">
		<tr>
		<th colspan="2">Details of the interview:</th>
		</tr>
		<tr><td>Resume Id:</td><td><?php echo $interviewObj->stu_job_id;?></td></tr>
		<tr><td>Interview Date:</td><td><?php echo $interviewObj->interview_date;?></td></tr>
	</table>
</div>
<br/>
<div>

	<span>Here is the message from <b><?php echo $senderName;?> (<?php echo $senderObj->user->email;?>) </b>
	</span>:<br />
	<div style="border: 1px solid lightgray; margin: 3px; padding: 3px;">
		<?php echo $message;?>
	</div>
</div>

<hr/>

<div>
Note: this email is sent from an automated email address, please do not reply to this address.
</div>
