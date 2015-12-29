<?php
//require 'PHPMailerAutoload.php';


$dbhost = 'localhost';
$dbuser = 'root';
$dbpass = 'bmw199999';
$conn = mysql_connect($dbhost, $dbuser);
if(! $conn )
{
  die('Could not connect: ' . mysql_error());
}
$sql = 'SELECT * FROM tbl_interview_student_job_title where interview_date = CURDATE() + 1';

mysql_select_db('colcnstprod');
$retval = mysql_query( $sql, $conn );
if(! $retval )
{
  die('Could not get data: ' . mysql_error());
}
while($row = mysql_fetch_array($retval, MYSQL_ASSOC))
{
$studentID = $row['stu_job_id'];
$employerID = $row['employer_id'];
$interviewDate = $row['interview_date'];
echo "$studentID";
    echo "EMP ID :{$row['stu_job_id']}  <br> ".
         "EMP NAME : {$row['interview_date']} <br> ".
         "EMP SALARY : {$row['employer_id']} <br> ".
         "--------------------------------<br>";
		 $studentID = $row['stu_job_id'];
} 
echo "Fetched data successfully\n";

//$mail = new PHPMailer;
//$mail = new PHPMailer('passwordReset');
$mail = new YiiMailer('passwordReset', array('tempPassword' =>$tempPassword));
//$mail = new YiiMailer('passwordReset');
$mail->isSMTP();
$mail->Host = 'smtp.teksavvy.com';
 $mail->Port = 25;
//$mail->SMTPAuth = true;
//$mail->Username = 'makbar25@gmail.com';
//$mail->Password = 'bmw199999';
//$mail->SMTPSecure = 'tls';
$mail->From = 'makbar24@hotmail.com';
$mail->FromName = 'Admin';
$mail->addAddress('makbar24@hotmail.com', 'Mohammed Akbar');
//$mail->addReplyTo('raj.amalw@gmail.com', 'Raj Amal W');
$mail->WordWrap = 50;
$mail->isHTML(true);
$mail->Subject = 'Interview notifier - You have interview tomorrow';
$mail->Body    = "Hi  student Id: , <br>
You have an interview with employee id:<br>.

This is a system generated interview notifier <br>. 
Good luck <br>

Thank you <br>

College Corner Stone <br>
Admin
";
if(!$mail->send()) {
   echo 'Message could not be sent.';
   echo 'Mailer Error: ' . $mail->ErrorInfo;
   exit;
}
echo 'Message has been sent';



mysql_close($conn);

?>