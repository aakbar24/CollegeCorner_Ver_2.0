<?php
require 'PHPMailerAutoload.php';
$mail = new PHPMailer;
$mail->isSMTP();
$mail->Host = 'smtp.teksavvy.com';
 $mail->Port = 25;
//$mail->SMTPAuth = true;
//$mail->Username = 'makbar25@gmail.com';
//$mail->Password = 'bmw199999';
//$mail->SMTPSecure = 'tls';
$mail->From = 'makbar25@gmail.com';
$mail->FromName = 'Admin';
$mail->addAddress('makbar24@hotmail.com', 'Raj Amal W');
//$mail->addReplyTo('raj.amalw@gmail.com', 'Raj Amal W');
$mail->WordWrap = 50;
$mail->isHTML(true);
$mail->Subject = 'Using PHPMailer';
$mail->Body    = 'Hi Iam using PHPMailer library to sent SMTP mail from localhost';
if(!$mail->send()) {
   echo 'Message could not be sent.';
   echo 'Mailer Error: ' . $mail->ErrorInfo;
   exit;
}
echo 'Message has been sent';