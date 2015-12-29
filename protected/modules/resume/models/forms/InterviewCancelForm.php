<?php
class InterviewCancelForm extends CFormModel {
	public $from;
	public $to;
	public $type;
	public $subject;
	public $body;
	public $stu_job_id;
	
	private $fromObj;
	private $toObj;
	private $interviewObj;
	
	const TYPE_STU=1;
	const TYPE_EMP=2;

	public function __construct($type){
		$this->type=$type;
	}
	
	public function rules(){
		return array(
				array('stu_job_id, from, to, subject, body, type','required'),
				array('stu_job_id, from, to', 'numerical','integerOnly'=>true),
				array('subject','length', 'max'=>150),
				array('body','length', 'max'=>1000),
			);
	}
	
	public function attributeLabels(){
		return array(
				'subject' => Yii::t('model', 'interviewCancelForm.subject'),
				'body' => Yii::t('model', 'interviewCancelForm.body'),
		);
	}
	
	public function send(){
		if($this->_setFromAndTo()){
			$senderName=$this->fromObj->user->getName();
			$description=$senderName." has cancelled the interview on ".$this->interviewObj->interview_date;
			$mail = new YiiMailer('interviewCancelNotification',
					array(
							'senderName'=>$senderName ,
							'description'=>$description,
							'message'=>$this->body,
							'interviewObj'=>$this->interviewObj,
							'senderObj'=>$this->fromObj,
							)
					);
			//render HTML mail, layout is set from config file or with $mail->setLayout('layoutName')
			$mail->render();
			//set properties as usually with PHPMailer		
			$mail->From = Yii::app()->params['nonReplyEmail'];
			$mail->FromName = $senderName;
			$mail->Subject = Yii::app()->name. " - ".$this->subject;
			$mail->AddAddress($this->toObj->user->email);			
			//send
			
			if ($mail->Send()) {
				$mail->ClearAddresses();
				$this->interviewObj->active=0;
				return $this->interviewObj->save();
			} else {
				return false;
			}
		}else{
			return false;
		}
	}
	
	/**
	 * Consolidates the "from" and "to" fields by filling in data model objects from database.
	 * In student mode, "from" will be the student model and "to" will be the employer model.
	 * In employer mode, it will be wise versa.
	 * @return boolean - true if the models are set successfully
	 * @throws CException -if from and to fields are not valid or type is not a valid type
	 */
	private function _setFromAndTo(){
		if (!$this->hasErrors($this->from) && !$this->hasErrors($this->to)) {
			
			$criteria=new CDbCriteria();
			$criteria->with=array('user'=>array('select'=>'email, first_name, last_name','joinType'=>'INNER JOIN'));
			$criteria->together=true;
			switch ($this->type) {
				case self::TYPE_STU:
					$this->fromObj=Student::model()->findByPk($this->from,$criteria);
					$this->toObj=Employer::model()->findByPk($this->to,$criteria);
					$this->interviewObj=InterviewStudentJobTitle::model()->findByAttributes(array('stu_job_id'=>$this->stu_job_id,'employer_id'=>$this->to,'active'=>1));
				break;
				
				case self::TYPE_EMP:
					$this->fromObj=Employer::model()->findByPk($this->from,$criteria);
					$this->toObj=Student::model()->findByPk($this->to,$criteria);//stu_job_id
					//$this->interviewObj=InterviewStudentJobTitle::model()->findByAttributes(array('stu_job_id'=>$this->stu_job_id,'employer_id'=>$this->from,'active'=>1));					$this->interviewObj=InterviewStudentJobTitle::model()->findByAttributes(array('employer_id'=>$this->employer_id,'stu_job_id'=>$this->to));
				break;
				
				default:
					throw new CException('Invalid type.');
				break;
			}
			if ($this->fromObj!=null && $this->toObj!=null && $this->interviewObj!=null) {
				return true;
			}
			else {
				return false;
			}
		}else {
			throw new CException('Cannot set From and To fields.');
		}
	}	// Email send while setup for an interview	public function sendIn(){			//	if($this->_setFromAndTo()){	//		$senderName=$this->fromObj->user->getName();	//		echo "$senderName";	//		return $senderName;	//	} if($this->_setFromAndTo()){			$senderName=$this->fromObj->user->getName();		//if($this->_setFromAndTo()){			//$senderName=$this->fromObj->user->getName();			$description=$senderName." has cancelled the interview on ".$this->interviewObj->interview_date;			$mail = new YiiMailer('interviewCancelNotification',					array(							'senderName'=>"akbar" ,							'description'=>"descri",							'message'=>"email fr inter",							'interviewObj'=>$this->interviewObj,							'senderObj'=>$this->fromObj,							)					);			//render HTML mail, layout is set from config file or with $mail->setLayout('layoutName')			$mail->render();			//set properties as usually with PHPMailer			$mail->From = Yii::app()->params['nonReplyEmail'];			$mail->FromName = $senderName;		//	$mail->Subject = Yii::app()->name. " - ".$this->subject;			$mail->AddAddress($this->toObj->user->email);			//$mail->AddAddress("sabrinaalam@hotmail.com");			//send						if ($mail->Send()) {			//echo "email sent for in";				$mail->ClearAddresses();				$this->interviewObj->active=0;				return $this->interviewObj->save();			} else {				return false;			}		}else{		return false;		}	}	/*		echo "inside mailer";		$mail = new YiiMailer();//$mail->clearLayout();//if layout is already set in config$mail->setFrom('makbar24@hotmail.com', 'John Doe');$mail->setTo('sabrinaalam@hotmail.com');$mail->setSubject('Mail subject');$mail->setBody('Simple message');$mail->send();	// end sending email for interview		if($this->_setFromAndTo()){		echo " inside _setFromTo   ";	$this->_setFromAndTo();	$senderName=$this->user->getName();	echo "$senderName";	echo "hahahahah   ";	//		return $senderName;	}	return  "form mailer";*/	//}	
}