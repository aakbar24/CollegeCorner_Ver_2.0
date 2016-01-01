<?php

/**
 * This is the base controller for the authentication and authorization.
 * It allows different -ends to share some particular actions by extending from this class. 
 * @author Wenbin
 *
 */

class DefaultAuthController extends Controller
{
	
	/**
	 * Declares class-based actions.
	 */
	public function actions()
	{
		return array(
				// captcha action renders the CAPTCHA image displayed on the contact page
				'captcha'=>array(
						'class'=>'CCaptchaAction',
						'backColor'=>0xFFFFFF,
				),
		);
	}
	
	/**
	 * A universal login function
	 * @return mixed -true if login is successful
	 * 				 -false if user already logged in
	 * 				 -string the rendered view page in text
	 */
	protected function _login()
	{
		if (Yii::app()->user->isGuest) {
			$model=new LoginForm;
			
			// if it is ajax validation request
			
			if(isset($_POST['ajax']) && $_POST['ajax']==='login-form')
			{
			//echo CActiveForm::validate($model);
			//Yii::app()->end();
                         $errors = CActiveForm::validate($model);
                         if ($errors != '[]')
                             {
                                   echo $errors;
                                   Yii::app()->end();
                                }
			}
			
			// collect user input data
			if(isset($_POST['LoginForm']))
			{
				$model->attributes=$_POST['LoginForm'];
				// validate user input and redirect to the previous page if valid
				if( $model->login())
				{
					echo "user is there";
					return true;					
				}
			}
			//use the login view in the common folder
			return $this->render('application.modules.account.views.common.login',array('model'=>$model),true);
		}
		else {
			return false;
		}
	}
	
	/**
	 * Logs out the current user and redirect to homepage.
	 */
	public function actionLogout()
	{
		Yii::app()->user->logout();
		//$this->redirect(Yii::app()->createAbsoluteUrl($this->getModule()->returnUrl));
                //site
              $this->redirect(Yii::app()->createAbsoluteUrl('site/index'));
	}
	
	public function actionForgot()
	{
		$model=new ForgotPasswordForm();
	
		if (isset($_POST['ForgotPasswordForm']) ){
			$model->attributes=$_POST['ForgotPasswordForm'];
			//$this->refresh();
			
			if($model->validate())
			{
				$tempPassword=Randomness::randomString(16,true);
				$model=User::model()->findByAttributes(array('email'=>$model->email));
				$model->isNewPassword=true;
				$model->password=$tempPassword;
			
				if ($model->save()){
				
					//use 'passwordrest' view from views/mail
					$mail = new YiiMailer('passwordReset', array('tempPassword' =>$tempPassword));
					
					//$mail->setSmtp('smtp.gmail.com', 465, 'ssl', true, 'your_email@gmail.com', 'your_password');
					//render HTML mail, layout is set from config file or with $mail->setLayout('layoutName')
					//$mail->render();smtp.secureserver.net
					$mail->IsSMTP();
					$mail->Host = 'smtp.teksavvy.com';
					//$mail->SMTPAuth = true;
					//$mail->Host = 'smtpout.secureserver.net';
					$mail->Port = 25;
					//$mail ->Username ='makbar@collegecornerstone.com';
					//$mail -> Password ='123456';
					//set properties as usually with PHPMailer
					$mail->From = Yii::app()->params['nonReplyEmail'];
					$mail->FromName = Yii::app()->name;
					$mail->Subject = Yii::app()->name.' - Password Reset';
					$mail->AddAddress(YII_DEBUG?Yii::app()->params['adminEmail']:$model->email);
					//$mail->AddAddress(YII_DEBUG?Yii::app()->params['adminEmail']);
                    //$mail->AddAddress('makbar24@hotmail.com');
					//send
						
					if ($mail->Send()) {
						$mail->ClearAddresses();
						Yii::app()->user->setFlash('success-', Yii::t('app', 'msg.success.password_reset'));
					} else {
						Yii::app()->user->setFlash('error-','Error while sending email: '.$mail->ErrorInfo);
					}
					$this->refresh(true);
				}
				

			
			}
			
		}
		$this->render('application.modules.account.views.common.forgot',array('model'=>$model));
		


	}



	
}
//}
