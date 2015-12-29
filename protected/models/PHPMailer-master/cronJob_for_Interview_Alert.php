
<?php
//require 'PHPMailerAutoload.php';

require("class.phpmailer.php");
require("class.smtp.php");
//$dbhost = 'colcnstprod.db.10437204.hostedresource.com1';
//$dbuser = 'colcnstprod';
//$dbpass = 'T6x5!@Wk';


$dbhost = 'localhost';
$dbuser = 'root';
//$dbname = 'collegestone';
$dbpass = '';

$conn = mysql_connect($dbhost, $dbuser,$dbpass);
if(!$conn )
{
  die('Could not connect: ' . mysql_error());
}
else{
	echo "connected ";
}
//$sql = 'SELECT * FROM tbl_interview_student_job_title where interview_date = CURDATE() + 1';
//NOW() - INTERVAL 24 HOUR)

//$sql = 'SELECT * FROM tbl_interview_student_job_title where interview_date =(NOW() + INTERVAL 48 HOUR)';

$sql = 'SELECT tbl_interview_student_job_title.stu_job_id,tbl_interview_student_job_title.employer_id,tbl_interview_student_job_title.interview_date,tbl_user.user_id,tbl_user.email,
tbl_user.user_group_id,tbl_user.first_name,tbl_user.last_name,tbl_employer.company_name,tbl_employer.address
FROM tbl_interview_student_job_title, tbl_user, tbl_employer
WHERE tbl_interview_student_job_title.interview_date < (NOW() + INTERVAL 48 HOUR)
AND(
tbl_interview_student_job_title.stu_job_id = tbl_user.user_id
OR
tbl_interview_student_job_title.employer_id = tbl_user.user_id)
AND
tbl_interview_student_job_title.employer_id = tbl_employer.user_id;
';


mysql_select_db('collegestone');
$retval = mysql_query( $sql, $conn );
if(! $retval )
{
  die('Could not get data: ' . mysql_error());
}
/*
while($row = mysql_fetch_array($retval, MYSQL_ASSOC))
{
$studentID = $row['stu_job_id'];
$employerID = $row['employer_id'];
$interviewDate = $row['interview_date'];
$email = $row['email'];
echo "$studentID";
    echo "EMP ID :{$row['stu_job_id']}  <br> ".
         "EMP NAME : {$row['interview_date']} <br> ".
         "EMP SALARY : {$row['employer_id']} <br> ".
		 "student email : {$row['email']} <br>".
         "--------------------------------<br>";
		 $studentID = $row['stu_job_id'];
} 
*/
echo "Fetched data successfully\n";

$mail = new PHPMailer;
//$mail = new PHPMailer('passwordReset');
$mail->isSMTP();
$mail->Host = 'smtp.teksavvy.com';
//$mail->Port = 587;
//$mail->SMTPAuth = true;
//$mail->Username = 'makbar24@gmail.com';
//$mail->Password = 'honda2004';
//$mail->SMTPSecure = 'tls';
//$mail->SMTPAuth = true;
//$mail->Host = 'smtpout.secureserver.net';
$mail->Port = 25;
//$mail ->Username ='makbar@collegecornerstone.com';
//$mail -> Password ='123456';
$i =1;
while($row = mysql_fetch_array($retval , MYSQL_ASSOC))
{
$timestamp = $row['interview_date'];
//echo '<br>';
$date = date('Y-m-d',strtotime($timestamp));
//echo '<br>';
$time = date('H:i:s',strtotime($timestamp));
$eemail = $row['email'];
$userGroup = $row['user_group_id'];
$firstName = $row['first_name'];
$firstName = $row['last_name'];
$companyName = $row['company_name'];
$companyAddress = $row['address'];
echo $row['email'];
echo '<br>';
//echo inside;
$mail->From = 'sabrinaalam@hotmail.com';
$mail->FromName = 'College Corner Stone';
$mail->ClearAddresses();
$mail->addAddress($eemail);
//$mail->addReplyTo('raj.amalw@gmail.com', 'Raj Amal W');
$mail->WordWrap = 50;
$mail->isHTML(true);
//$mail->Subject = 'Interview notifier - You have interview on '. $date . 'at '.$time ;
if($userGroup  == 1)
{
$mail->Body    = 
//Hi  student Id: , <br>
//You have an interview with employee id:<br>.

//This is a system generated interview notifier <br>. 
//Good luck <br>

//Thank you <br>

//College Corner Stone <br>
//Admin

"
<p style=\"color:#4D90FE;font-size:22px;border-bottom: 2px solid #4D90F\">

				College CornerStonew
				<hr>
   </b>
<b>Dear $firstName  </b>, 
<b>You have scheduled Interview on $timestamp .</b>

<p>
	To protect your account security, please update your password immediately after login in with the temporary password.
</p>
<hr/>
<div>
    Note: this email is sent from an automated email address, please do not reply to this address.
</div>
";
}
else 
{
$mail->Body    = 
"
<p style=\"color:#4D90FE;font-size:22px;border-bottom: 2px solid #4D90F\">

				College CornerStonew
				<hr>
   </b>
<b>Dear $firstName  </b>, 
<b>You have scheduled Interview on $timestamp  with company $companyName.</b>
<b> at $companyAddress </b>
<b>Google Map </b>

http://maps.google.com/?q=$companyAddress




<p>
	To protect your account security, please update your password immediately after login in with the temporary password.
</p>
<hr/>
<div>
    Note: this email is sent from an automated email address, please do not reply to this address.
</div>
";

}



//$mail->Body    = 'Employee';
if(!$mail->send($eemail)) {
echo $eemail;
 echo 'Message could not be sent.';
 echo 'Mailer Error: ' . $mail->ErrorInfo;
   exit;
}
//$mail->send($eemail);
echo 'Message has been sent';
//echo '<br>';
//mail($eemail) ;
echo $i;
$i++;
} // end of while loop
mysql_close($conn);

?>