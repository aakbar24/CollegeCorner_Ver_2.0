<?php
/**
 * This form model is used for updating the user account.
 * @author Wenbin
 *
 *@property User $user
 */
class AccountForm extends CFormModel
{
	public $user;

	public $currentPassword;
	public $newPassword;
	public $confirmPassword;
	
	public function rules()
	{
		return array(
				array('user','checkUser'),
				array('currentPassword', 'required'),
				
				array('currentPassword', 'checkCurrentPassword'),
				array('newPassword','checkNewPassword'),
				// confirm password needs to be checked against new password
				array('confirmPassword', 'confirmPassword'),
		);
	}
	
	public function checkCurrentPassword($attribute, $params)
	{
		if (!$this->hasErrors('currentPassword'))
		{
			if (crypt($this->attributes[$attribute],$this->user->password)!==$this->user->password) {
				$this->addError($attribute, 'Current Password does not match.');
			}
		}
	}
	
	public function checkNewPassword($attribute, $params)
	{
		if($this->confirmPassword!==null && $this->confirmPassword!=='')
		{
			if($this->newPassword===null||$this->newPassword==='')
				$this->addError('newPassword','New Password cannot be empty.');
		}
	}
	
	public function checkUser($attribute,$params)
	{
		$ret=$this->user->validate();
		if (!$ret) {
			$this->addErrors($this->user->getErrors());
		}
	}
	
	public function confirmPassword($attribute,$params) {
		
		if (!$this->hasErrors('currentPassword') && !$this->hasErrors('newPassword')) {
			
			if ($this->newPassword!==null && $this->newPassword!=='')
			{
				if ($this->confirmPassword===null || $this->confirmPassword==='')
				{
					$this->addError('confirmPassword','Confirm Password cannot be empty.');
				}
				else if ($this->confirmPassword!==$this->newPassword)
				{
					$this->addError($attribute,'Confirm Password does not match the new password.');
				}
			}
		}
	}
	
	/**
	 * Saves the changes of the current user account. 
	 * @return boolean true if the update is successful, otherwise, false
	 */
	public function save()
	{
		if (!$this->hasErrors()) 
		{
			if ($this->newPassword!==null && $this->newPassword!=='') 
			{
				$this->user->password=$this->newPassword;
				$this->user->isNewPassword=true;
			}
			return $this->user->save();
		}
		else 
		{
			return false;
		}
	}
	
	/**
	 * Declares attribute labels.
	 */
	public function attributeLabels()
	{
		return array(
				'currentPassword'=>Yii::t('model', 'accountForm.currentPassword'),
				'newPassword'=>Yii::t('model', 'accountForm.newPassword'),
				'confirmPassword'=>Yii::t('model', 'accountForm.confirmPassword'),
				
		);
	}
}