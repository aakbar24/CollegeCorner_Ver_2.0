<?php
class Emailer{

    /** @var $user User
     * @return bool
     */

    public static function emailEmployerVerified($user)
    {
        $employer = Employer::model()->findByPk($user->user_id);

        $mail = new YiiMailer('employerVerified', array('employer' =>$employer, 'user'=>$user));

        $mail->render();

        $mail->From = Yii::app()->params['nonReplyEmail'];
        $mail->FromName = Yii::app()->name;
        $mail->Subject = Yii::app()->name.' - Employer account verified';
        $mail->AddAddress(YII_DEBUG?Yii::app()->params['adminEmail']:$user->email);


        if ($mail->Send()) {
            $mail->ClearAddresses();
            Yii::log("Mail sent via " . Yii::app()->params['nonReplyEmail'], 'log');
            Yii::log("Mail sent successfully to " . (YII_DEBUG?Yii::app()->params['adminEmail']:$user->email), 'log');
            return true;
        } else {
            Yii::log("Email error: " . $mail->getError(), 'log');
            return false;
        }
    }

    public static function emailStudentVerified($user)
    {
        $student = Student::model()->findByPk($user->user_id);

        $mail = new YiiMailer('studentVerified', array('student' =>$student, 'user'=>$user));

        $mail->render();

        $mail->From = Yii::app()->params['nonReplyEmail'];
        $mail->FromName = Yii::app()->name;
        $mail->Subject = Yii::app()->name.' - Student account now active';
        $mail->AddAddress(YII_DEBUG?Yii::app()->params['adminEmail']:$user->email);


        if ($mail->Send()) {
            $mail->ClearAddresses();
            Yii::log("Mail sent via " . Yii::app()->params['nonReplyEmail'], 'log');
            Yii::log("Mail sent successfully to " . (YII_DEBUG?Yii::app()->params['adminEmail']:$user->email), 'log');
            return true;
        } else {
            Yii::log("Email error: " . $mail->getError(), 'log');
            return false;
        }
    }

    public static function emailStudentActivation($user, $hash)
    {
        $student = Student::model()->with('college', 'program', 'educationLevel')->findByPk($user->user_id);

        $mail = new YiiMailer('studentActivation', array('student' =>$student, 'user'=>$user, 'hash'=>$hash));

        $mail->render();

        $mail->From = Yii::app()->params['nonReplyEmail'];
        $mail->FromName = Yii::app()->name;
        $mail->Subject = Yii::app()->name.' - Student account verification';
        $mail->AddAddress(YII_DEBUG?Yii::app()->params['adminEmail']:$user->email);


        if ($mail->Send()) {
            $mail->ClearAddresses();
            Yii::log("Mail sent via " . Yii::app()->params['nonReplyEmail'], 'log');
            Yii::log("Mail sent successfully to " . (YII_DEBUG?Yii::app()->params['adminEmail']:$user->email), 'log');
            return true;
        } else {
            Yii::log("Email error: " . $mail->getError(), 'log');
            return false;
        }
    }

}