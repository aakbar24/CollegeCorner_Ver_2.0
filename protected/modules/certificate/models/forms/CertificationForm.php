<?php
class CertificationForm extends CFormModel{
	public $postItem;
	public $certification;
	public $form=true;
	
	public function __construct($scenario='',$id=null,$checkApproved=false){
		if ($scenario=='view' && $id!=null) {
			$this->certification=Certification::model()->with('postItem')->findByPk($id);
			if ($this->certification!=null) {
				$this->postItem=$this->certification->postItem;
			}else{
				throw new CHttpException(400,'Cannot found the certification post.');
			}
		}else{
			$this->_new();
		}
		
	}
	
	private function _new(){
		$this->postItem=new PostItem();
		$this->postItem->post_type_id=Certification::POST_TYPE;
		$this->certification=new Certification();
	}
	
	public function rules()
	{
		return array(
				array('postItem','checkPostItem'),
				array('certification','checkCertification'),
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
	
	public function checkCertification($attribute, $params)
	{
		$ret=$this->certification->validate();
		if (!$ret) {
			$this->addErrors($this->certification->getErrors());
		}
	}
	
	public function save()
	{
		//start a transaction
		$transaction=Yii::app()->db->beginTransaction();
		try {
			/* if (!$this->isPublic) {
				if(Yii::app()->user->isCollegeAdmin()){
					$collegeAdmin=CollegeAdmin::model()->findByPk(Yii::app()->user->id);
				}else{
					$collegeAdmin=CollegeAdmin::model()->findByPk($this->postItem->user_id);
				}
				$this->event->college_id=$collegeAdmin->college_id;
			}else{
				if(!$this->event->isNewRecord && Yii::app()->user->isCollegeAdmin()){
					$this->event->college_id=null;
				}
			} */
			
			if ($this->postItem->save()) {
				if ($this->certification->save(true,null,$this->postItem)) {
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