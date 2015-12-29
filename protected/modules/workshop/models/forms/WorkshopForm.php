<?php

/**
 * @property Workshop $workshop
 * @property PostItem $postItem
 */


class WorkshopForm extends CFormModel{
	public $postItem;
	public $workshop;
	public $form=true;

    public $workshopFile;
	
	public function __construct($scenario='',$id=null,$checkApproved=false){
		if ($scenario=='view' && $id!=null) {
			$this->workshop=Workshop::getWorkshop($id,$checkApproved);//model()->with('postItem')->findByPk($id);
            $this->workshopFile = $this->workshop->workshop_file;
			if ($this->workshop!=null) {
				$this->postItem=$this->workshop->postItem;
			}else{
				throw new CHttpException(400,'Cannot found the event post.');
			}
		}else{
			$this->_new();
		}
		
	}
	
	private function _new(){
		$this->postItem=new PostItem();
		$this->postItem->post_type_id=Workshop::POST_TYPE;
		$this->workshop=new Workshop();
	}
	
	public function rules()
	{
		return array(
				array('postItem','checkPostItem'),
				array('workshop','checkWorkshop'),
				array('form','safe'),
                array('workshopFile','file','allowEmpty'=>true, 'safe'=>true, 'maxSize'=>3146666,'types'=>array('txt','doc','docx','rtf', 'pdf', 'zip', 'rar')),
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
        if ($this->workshop->is_running)
            $this->workshop->scenario = 'running';

        $ret=$this->workshop->validate();

		if (!$ret) {
			$this->addErrors($this->workshop->getErrors());
		}
	}
	
	public function save()
	{
        if (Yii::app()->user->isEmployer())
            $this->workshop->company = Employer::model()->findByPk(Yii::app()->user->id)->company_name;

		//start a transaction
		$transaction=Yii::app()->db->beginTransaction();
		try {

			if ($this->postItem->save()) {
				if ($this->workshop->save(false,null,$this->postItem)) {
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
		return array(
            'isPublic'=>Yii::t('model', 'eventForm.isPublic'),
            'workshopFile' => Yii::t('model', 'workshop.workshop_file'),);
	}
	
	public function postedByAdmin(){
		return $this->postItem->user->user_group_id==Admin::USER_GROUP_ID || $this->postItem->user->user_group_id==SuperAdmin::USER_GROUP_ID;
	}
}