<?php

/**
 * @property PostItem $postItem
 * @property WorkshopPlanned $workshopPlanned
 */

class PlannedWorkshopForm extends CFormModel{
	public $postItem;
	public $workshopPlanned;
	public $form=true;
	
	public function __construct($scenario='',$id=null,$checkApproved=false){
		if ($scenario=='view' && $id!=null) {
			$this->workshopPlanned= WorkshopPlanned::model()->with('postItem')->findByPk($id);
			if ($this->workshopPlanned!=null) {
				$this->postItem=$this->workshopPlanned->postItem;
			}else{
				throw new CHttpException(400,'Cannot find the planned workshop.');
			}
		}else{
			$this->_new();
		}
		
	}
	
	private function _new(){
		$this->postItem=new PostItem();
		$this->postItem->post_type_id=WorkshopPlanned::POST_TYPE;
		$this->workshopPlanned=new WorkshopPlanned();
	}
	
	public function rules()
	{
		return array(
				array('postItem','checkPostItem'),
				array('workshop','checkWorkshop'),
				array('form','safe'),
		);
	}
	
	public function checkPostItem($attribute, $params)
	{
		$ret=$this->postItem->validate();
		if (!$ret) {
			$this->addErrors($this->postItem->getErrors());
		}
	}
	
	public function checkWorkshop($attribute, $params)
	{
		$ret=$this->workshopPlanned->validate();
		if (!$ret) {
			$this->addErrors($this->workshopPlanned->getErrors());
		}
	}
	
	public function save()
	{
		//start a transaction
		$transaction=Yii::app()->db->beginTransaction();
		try {

			if ($this->postItem->save()) {
				if ($this->workshopPlanned->save(true,null,$this->postItem)) {
					$transaction->commit();
					return true;
				}
			}
	
			$transaction->rollback();
			return false;
			
		} catch (Exception $e) {
			$transaction->rollback();
			return false;
		}
	}

	
	public function postedByAdmin(){
		return $this->postItem->user->user_group_id==Admin::USER_GROUP_ID || $this->postItem->user->user_group_id==SuperAdmin::USER_GROUP_ID;
	}
}