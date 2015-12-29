<?php
/**
 * This model is used for employer registration form.
 * @author Wenbin
 *
 *@property User $user
 *@property Student $employer 
 */
class EmployerRegisterForm extends RegisterForm
{
	public $employer;

	public function __construct()
	{
		parent::__construct();
		
		$this->user->user_group_id=Employer::USER_GROUP_ID;
		$this->employer=new Employer();
	}
	
	public function rules()
	{
		return CMap::mergeArray(parent::rules(), array(
				array('employer','checkEmployer'),
				));
	}
	
	public function checkEmployer($attribute,$params)
	{
		$ret=$this->employer->validate();
		if (!$ret) {
			$this->addErrors($this->employer->getErrors());
		}
	}
	
	public function save()
	{
		//start a transaction
		$transaction=Yii::app()->db->beginTransaction();
		try {

            if ($this->user->isNewRecord)
                $this->user->is_verified = 0;

		
			//try to save the data to db
			$ret=parent::save();
			
			if ($ret) {
				$ret=$this->employer->save(true,null,$this->user);
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