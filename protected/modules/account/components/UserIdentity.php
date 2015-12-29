<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 * 
 * @property User $_user 
 */
class UserIdentity extends CUserIdentity
{
	const ERROR_INVALID_USER_GROUP=50;
	private $_id;
	private $_email;
	private $_user;
	
	/**
	 * Authenticates a user with either a username or email.
	 * @return int error code.
	 * 
	 */
	public function authenticate()
	{
		//query the db with the input username by checking the username and email
		$user=User::model()->with('userGroup')->together()->find('is_active="1" AND (username=:username OR email=:username)',array(':username'=>$this->username));
		
		if ($user === null) {
			$this->errorCode = self::ERROR_UNKNOWN_IDENTITY;
		}else {
			//validate the password 
			if( crypt($this->password, $user->password) !== $user->password) {
				$this->errorCode=self::ERROR_PASSWORD_INVALID;
			}
			else {
				
				$this->errorCode=self::ERROR_NONE;
				$this->username=$user->username;
				$this->_id=$user->user_id;
				$this->_email=$user->email;
				$this->_user=$user;
				
				//persists the user info to the session
				$user->setState($this);
				if (Yii::app()->endName=='front') {
					//saves the profile sidebar nav items according to user group
					if ($user->user_group_id==Student::USER_GROUP_ID) {
						$this->setState('mainNavItems', Student::getMainNavItems());
						$this->setState('returnUrl', Yii::app()->createAbsoluteUrl('account/profile/index'));
					}
					else if ($user->user_group_id==Employer::USER_GROUP_ID) {
						$this->setState('mainNavItems', Employer::getMainNavItems());
						$this->setState('returnUrl', Yii::app()->createAbsoluteUrl('resume/employer/index'));
					}else {
						$this->errorCode=self::ERROR_INVALID_USER_GROUP;
					}
				}
				else{
					if (!UserGroup::allowBackendAccess($user->user_group_id)) {
						$this->errorCode=self::ERROR_INVALID_USER_GROUP;
					}
					else {
						$this->_checkBackendAccessGroup();
					}
					
				}
			}	
		}
		
		return $this->errorCode;
	}
	
	public function getId()
	{
		return $this->_id;
	}
	
	private function _checkBackendAccessGroup(){
		if ($this->_user->userGroup->isAdmin()) {
			$this->setState('mainNavItems', Admin::getMainNavItems());
			$this->setState('returnUrl', Yii::app()->backendUrl);
			$this->setState('backendAccess', true);
		}elseif (intval($this->_user->user_group_id)==CollegeAdmin::USER_GROUP_ID){
			$this->setState('mainNavItems', CollegeAdmin::getMainNavItems());
			$this->setState('returnUrl', Yii::app()->backendUrl);
			$this->setState('backendAccess', true);
		}
	}
	
}