<?php
class CollegeAdminRegisterForm extends RegisterForm{
	public $collegeAdmin;
	
	public function __construct()
	{
		parent::__construct();
		$this->user->user_group_id=CollegeAdmin::USER_GROUP_ID;
		$this->collegeAdmin=new CollegeAdmin();
	}
	
	public function rules()
	{
		return CMap::mergeArray(parent::rules(), array(
				array('collegeAdmin','checkCollegeAdmin'),
		));
	}
	
	public function checkCollegeAdmin($attribute,$params)
	{
		$ret=$this->collegeAdmin->validate();
		if (!$ret) {
			$this->addErrors($this->collegeAdmin->getErrors());
		}
	}
	
	public function save()
	{
		//start a transaction
		$transaction=Yii::app()->db->beginTransaction();
		try {
	
			//try to save the data to db
			$ret=parent::save();
				
			if ($ret) {
				$ret=$this->collegeAdmin->save(true,null,$this->user);
			}
	
			$transaction->commit();
			//Yii::app()->user->setFlash('success',sprintf(Constants::SUCCESS_SURVEY_SUBMITTED,$model->getSurvey()->title));
			return $ret;
		} catch (Exception $e) {
			//if something happens, simply set the error message and redirect as normal
			$transaction->rollback();
			//Yii::app()->user->setFlash('error','Unable to create your account.');
			return false;
		}
	
	}
}