<b>You have requested to reset your password using the password recovery service.</b>

<br />

<p>You may now <?php echo CHtml::link("log in", Yii::app()->getBaseUrl(true).'/auth/login'); ?> with your Username / E-Mail and the temporary Password.</p>

<ul>
	<li>You Temporary password: <?php echo $tempPassword; ?></li>
</ul>
<br/>
<p>
	To protect your account security, please update your password immediately after login in with the temporary password.
</p>
<hr/>
<div>
    Note: this email is sent from an automated email address, please do not reply to this address.
</div>