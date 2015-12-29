<?php
/**
 * This form model is used for creating a new Thread.
 *
 *@property Thread $thread
 *@property PostItem $postItem
 *@property integer $collegeName 
 */
class ThreadForm extends CFormModel
{
	public $thread;
	public $postItem;
        public $collegeName;
        
        public function __construct($collegeId) {
            $this->thread = new Thread;
            $this->postItem = new PostItem;
            $this->postItem->post_type_id = 7;      // type Thread
            $this->thread->college_id = $collegeId;
            
            $this->collegeName = College::model()->findByPk($collegeId)->college_name;
        }
	
	public function rules()
	{
		return array(
				array('thread','checkThread'),
                                array('postItem','checkPostItem'),

		);
	}
	
	public function checkThread($attribute, $params)
	{
	        $ret=$this->thread->validate();
		if (!$ret) {
			$this->addErrors($this->thread->getErrors());
		}
	}
        
        public function checkPostItem($attribute, $params)
	{
	        $ret=$this->postItem->validate();
		if (!$ret) {
			$this->addErrors($this->postItem->getErrors());
		}
	}
	
	/**
	 * Saves the changes of the current user account. 
	 * @return boolean true if the update is successful, otherwise, false
	 */
	public function save()
	{
		//start a transaction
		$transaction=Yii::app()->db->beginTransaction();
		try {
			if ($this->postItem->save()) {
                            $this->thread->save(true,null,$this->postItem);
			}
		
			$transaction->commit();
			return true;
                        
		} catch (Exception $e) {
			$transaction->rollback();
			return false;
		}
	}
	
	/**
	 * Declares attribute labels.
	 */
	public function attributeLabels()
	{
		return array(
				'collegeName'=>'College',
				
		);
	}
}