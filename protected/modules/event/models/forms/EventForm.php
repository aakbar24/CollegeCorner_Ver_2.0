<?php
class EventForm extends CFormModel{
	public $postItem;
	public $event;
	public $isPublic=true;
	public $form=true;
	
	public function __construct($scenario='',$id=null){
		if ($scenario=='view' && $id!=null) {
			$this->event=Event::getEvent($id);
			if ($this->event!=null) {
				$this->postItem=$this->event->postItem;
				if(Yii::app()->user->isCollegeAdmin()){
					$this->isPublic=$this->event->college_id==null;
				}
				
			}else{
				throw new CHttpException(400,'Cannot found the event post.');
			}
		}else{
			$this->_new();
		}
		
	}
	
	private function _new(){
		$this->postItem=new PostItem();
		$this->postItem->post_type_id=Event::POST_TYPE;
		$this->event=new Event();
	}
	
	public function rules()
	{
		return array(
				array('postItem','checkPostItem'),
				array('event','checkEvent'),
				array('isPublic','boolean'),
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
	
	public function checkEvent($attribute, $params)
	{
		$ret=$this->event->validate();
		if (!$ret) {
			$this->addErrors($this->event->getErrors());
		}
	}
	
	public function save()
	{
		//start a transaction
		$transaction=Yii::app()->db->beginTransaction();
		try {
			if (!$this->isPublic) {
				if(Yii::app()->user->isCollegeAdmin()){
					$collegeAdmin=CollegeAdmin::model()->findByPk(Yii::app()->user->id);
				}else{
					$collegeAdmin=CollegeAdmin::model()->findByPk($this->postItem->user_id);
				}
				$this->event->college_id=$collegeAdmin->college_id;
			}else{
				if(!$this->event->isNewRecord && $this->postedByCollegeAdmin()){
					$this->event->college_id=null;
				}
			}
			
			if ($this->postItem->save()) {
				if ($this->event->save(true,null,$this->postItem)) {
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
	
	public function attributeLabels(){
		return array('isPublic'=>Yii::t('model', 'eventForm.isPublic'));
	}
	
	public function postedByCollegeAdmin(){
		return $this->postItem->user->user_group_id==CollegeAdmin::USER_GROUP_ID;
	}
}