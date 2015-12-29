<?php

class AuthController extends DefaultAuthController
{
	public $layout='//layouts/column1';	
	
	public function actionIndex()
	{
		$this->actionLogin();
	}
	
	public function actionLogin()
	{
		$ret=$this->_login();
		
		if ($ret===false) 
		{
			$this->redirect(Yii::app()->createAbsoluteUrl($this->getModule()->returnUrl));
		}
		elseif ($ret===true)
		{
			$this->redirect(Yii::app()->createAbsoluteUrl($this->getModule()->returnUrl));
		}
		elseif(is_string($ret))
		{
			echo $ret;
		}
	}
	
}