<?php
/**
 * This model is used for password reset form.
 * @author Wenbin
 *
 *@property String $email
 *@property String $verifyCode
 */
class ForgotPasswordForm extends CFormModel
{
	public $email;
	public $verifyCode;

	/**
	 * Declares the validation rules.
	 */
	public function rules()
	{
		return array(
			// name, email, subject and body are required
			array('email, verifyCode', 'required'),
			// email has to be a valid email address
			array('email', 'email'),
			array('email', 'checkExists','class'=>'User','conditions'=>'email=:email','params'=>array(':email'=>'email')),
			// verifyCode needs to be entered correctly
			array('verifyCode', 'captcha', 'allowEmpty'=>!CCaptcha::checkRequirements()),
		);
	}

	public function checkExists($attribute, $params)
	{
		if (!$this->hasErrors($attribute)) {
			if (isset($params['class']) && isset($params['conditions'])) {
				$conditionParams=array();
				if (isset($params['params'])) {
					foreach ($params['params'] as $key=>$value) {
						$conditionParams[$key]=$this->attributes[$value];
					}
				}
				$exists=CActiveRecord::model($params['class'])->exists($params['conditions'],$conditionParams);
				if (!$exists) {
					$this->addError($attribute, isset($params['msg'])?$params['msg']:$this->getAttributeLabel($attribute).' does not exist');
				}
			}
		}	
	}
	
	/**
	 * Declares customized attribute labels.
	 * If not declared here, an attribute would have a label that is
	 * the same as its name with the first letter in upper case.
	 */
	public function attributeLabels()
	{
		return array(
			'email'=>Yii::t('model', 'forgot.email'),
			'verifyCode'=>Yii::t('model', 'forgot.captcha'),
		);
	}
}