<?php
/**
 * An extended WebUser class that dynamically generate the navigation menu according to user group of the logged in user. 
 * @author Wenbin
 *
 */
class WebUser extends CWebUser{
	
	public function getUserProfileMenu($controller)
	{
		if ($this->isGuest) 
		{
			return false;
		}
		else
		{
			$userGroup=intval($this->getState('user_group_id',0));
			if ($userGroup === Student::USER_GROUP_ID) 
			{
				return Student::getProfileNavItems($controller);
			}
			elseif ($userGroup===Employer::USER_GROUP_ID)
			{
				return Employer::getProfileNavItems($controller);
			}
			else
			{
				return array();
			}
		}
	}
	
	public function getDashboardItems($controller){
		if ($this->isBackendUser()) {
			$userGroup=intval($this->getState('user_group_id',0));
			if ($userGroup === Admin::USER_GROUP_ID)
			{
				return Admin::getDashboardItems($controller);
			}
			else if ($userGroup === SuperAdmin::USER_GROUP_ID)
			{
				return SuperAdmin::getDashboardItems($controller);
			}
			else if ($userGroup === CollegeAdmin::USER_GROUP_ID)
			{
				return CollegeAdmin::getDashboardItems($controller);
			}
			else
			{
				return array();
			}
		}
		return false;
	}
	
	public function getAdminMenu($controller){
		if ($this->isBackendUser()) {
			$userGroup=intval($this->getState('user_group_id',0));
			if ($userGroup === Admin::USER_GROUP_ID)
			{
				return Admin::getAdminMenu($controller);
			}
			else if ($userGroup === SuperAdmin::USER_GROUP_ID)
			{
				return SuperAdmin::getAdminMenu($controller);
			}
			else
			{
				return array();
			}
		}
		return false;
	}
	
	public function isBackendUser(){
		return Yii::app()->user->getState('backendAccess',false);
	}
	
	public function isAdmin(){
		return !$this->isGuest && Yii::app()->user->user_group_id==Admin::USER_GROUP_ID;
	}
	
	public function isSuperAdmin(){
		return !$this->isGuest && Yii::app()->user->user_group_id==SuperAdmin::USER_GROUP_ID;
	}
	
	public function isCollegeAdmin(){
		return !$this->isGuest && Yii::app()->user->user_group_id==CollegeAdmin::USER_GROUP_ID;
	}
	
	public function isStudent(){
		return !$this->isGuest && Yii::app()->user->user_group_id==Student::USER_GROUP_ID;
	}
	
	public function isEmployer(){
		return !$this->isGuest && Yii::app()->user->user_group_id==Employer::USER_GROUP_ID;
	}
}
?>