<?php /** @var $employer Employer */
      /** @var $user User */?>

<br />

<div>
    <h3>Thank you for your patience. Your company "<?php echo $employer->company_name; ?>" has been verified.</h3>
    <h3><font color=blue>Collegecornerstone.com welcomes you as an employer. Please feel free to use at any time. Best wishes !</font><h3>

    <div>
        <table border="1" cellspacing="0" cellpadding="3" style="font:12px Arial;">
            <tr>
                <th colspan="2">Employer Account Details</th>
            </tr>
            <tr><td>Username:</td><td><?php echo $user->username;?></td></tr>
            <tr><td>Contact:</td><td><?php echo $user->first_name . " " . $user->last_name;?></td></tr>
            <tr><td>Email:</td><td><?php echo $user->email;?></td></tr>
        </table>
    </div>

    <p>You may now <?php echo CHtml::link("log in", Yii::app()->getBaseUrl(true).'/auth/login'); ?> with your <strong>Username / E-Mail and Password</strong>.</p>

    <br />

    <p style="text-decoration: underline;">College Cornerstone can offer an employer the following benefits: </p>

    <ul>
        <li>Seek out student volunteers who can add strength and new possibilities to your business.</li>
        <li>Browse student resumes</li>
        <li>Display any certifications associated with your line of work.</li>
        <li>Set-up and advertise your very own workshop to <b>thousands</b> of students. <b>We'll take care of all the dirty work!</b></li>
        <li>Much more! Log into your account and explore!</li>
    </ul>
</div>

<br />

<hr/>

<div>
    Note: this email is sent from an automated email address, please do not reply to this address.
</div>
