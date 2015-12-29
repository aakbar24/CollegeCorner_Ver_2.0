<?php

function my_encrypt ($orig_str)
{
	  $pieces = explode("@", $orig_str);
	  
	  for ($p=0; $p<=1; $p++) {

         $temp_str=$pieces[$p];
         
         $n=strlen($temp_str);
         for ($i=0; $i<$n; $i++) 
         {
	           if      ($temp_str[$i]=='y') $temp_str[$i]='a';
	           else if ($temp_str[$i]=='z') $temp_str[$i]='b';
        	   else if (($temp_str[$i]>='a') && ($temp_str[$i]<='x'))
	                     $temp_str[$i]=chr(ord($temp_str[$i])+2);
	                     
	           if      ($temp_str[$i]=='Y') $temp_str[$i]='A';
	           else if ($temp_str[$i]=='Z') $temp_str[$i]='B';
        	   else if (($temp_str[$i]>='A') && ($temp_str[$i]<='X'))
	                     $temp_str[$i]=chr(ord($temp_str[$i])+2);

	           if      ($temp_str[$i]=='8') $temp_str[$i]='0';
	           else if ($temp_str[$i]=='9') $temp_str[$i]='1';
        	   else if (($temp_str[$i]>='0') && ($temp_str[$i]<='7'))
	                     $temp_str[$i]=chr(ord($temp_str[$i])+2);
	       }
	        
         $pieces[$p]=$temp_str;
    }
    
    return($pieces[1] . 'hotchuk666403' . $pieces[0]);

}


// ***************************************************************
// ***************************************************************

//$EmpEmail000='test_email@test_host.com.tr';

$Activate_Str = my_encrypt($EmpEmail000);

$MAIL_to      = $EmpEmail000;
$MAIL_subject = "College CornerStone - Employer account activation";
$MAIL_header  = "MIME-version: 1.0 \r\n" .
                "Content-type: text/html; charset=iso-8859-1 \r\n" .
                "From: Admin - College CornerStone <non-reply@collegecornerstone.com>";
$MAIL_message =
"<html> " .
"<body> " .
"<br> " .
"<div> " .
"    <h3>Thank you for your patience. Your company will be activated whenever you " .
"        <a href='http://collegecornerstone.com/assets/416832cc/app85473.php?pwd=" . $Activate_Str . "'><b>click this link.</b></a>" .
"    </h3>" .
"    <br>" .
"    <h3><font color=blue>Collegecornerstone.com welcomes you as an employer. Please feel free to use at any time. Best wishes !</font></h3> " .
"    <br>" .
"    <p>After activation you may log in with your <strong>Username / E-Mail and Password</strong>.</p> " .
"    <br> " .
"    <p style=\"text-decoration: underline;\">College Cornerstone can offer an employer the following benefits: </p> " . 
"    <ul> " .
"       <li>Seek out student volunteers who can add strength and new possibilities to your business.</li> " .
"       <li>Browse student resumes</li> " .
"       <li>Display any certifications associated with your line of work.</li> " .
"       <li>Set-up and advertise your very own workshop to <b>thousands</b> of students. <b>We'll take care of all the dirty work!</b></li> " .
"       <li>Much more! Log into your account and explore!</li> " .
"    </ul> " . 
"</div> " .
"<br> " .
"<hr> " .
"<div> " .
"    Note: This email is sent from an automated email address, please do not reply to this address. " .
"</div> " .
"</body> " .
"</html> ";


mail($MAIL_to, $MAIL_subject, $MAIL_message, $MAIL_header);

// echo $MAIL_message;


// ***************************************************************
// ***************************************************************

?>

