<?php
class EmployerInterviewController extends ProfileRelatedController
{

	/**
	 * Declares class-based actions.
	 */
	public function actions()
	{
		return array(
					
		);
	}

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
				'accessControl', // perform access control
				'postOnly +  update, delete, deleteSelected',
		);
	}
	
	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(
				
				array('allow', // actions that only allow employers to perform
						'actions'=>array('index',
								'interviewSelected',
								'update',
								'delete', 'deleteSelected',
								),
						'users'=>array('@'),
						'expression'=>'intval($user->user_group_id)===Employer::USER_GROUP_ID' //only allow employer to access
				),
				array('deny',  // deny all users
						'users'=>array('*'),
				),
		);
	}
	
	
	public function actionInterviewSelected(){
	
		if (isset($_POST) && isset($_POST['stu_job_id']) && !empty($_POST['stu_job_id'])) {
							$interviewCancelForm=new InterviewCancelForm(InterviewCancelForm::TYPE_EMP);			//$interviewCancelForm->attributes=$_POST['InterviewCancelForm'];
			$unInteResumes=InterviewStudentJobTitle::getUnInterviewResumes($_POST['stu_job_id'],Yii::app()->user->id);
			if (count($unInteResumes)>0) {
				try {
	
					if (InterviewStudentJobTitle::saveInterviewResumes($unInteResumes,Yii::app()->user->id ,$_POST['interviewDate'])) {						echo "I am here   ";						$interviewCancelForm->sendIn();						echo "I am here after send";
						$this->renderPartial('/common/_alerts',array('type'=>'success','msg'=>Yii::t('app', 'msg.success.interview_resumes')));
					}
					echo CHtml::hiddenField('interviewed-date', $_POST['interviewDate']);
				} catch (Exception $e) {					
					$this->renderPartial('/common/_alerts',array('type'=>'danger','msg'=>Yii::t('app', 'msg.error.interview_resumes')));
				}
				
				echo CHtml::hiddenField('interviewed-resumes',implode(',', $unInteResumes));
			}
			else{
				$this->renderPartial('/common/_alerts',array('type'=>'warning','msg'=>Yii::t('app', 'msg.alert.no_interview_resumes')));
			}
		}else{
			$this->renderPartial('/common/_alerts',array('type'=>'danger','msg'=>Yii::t('app', 'msg.error.resumes_not_found')));
		}
	}
	
		
		
	public function actionIndex() {
		$this->layout='/layouts/_empResumeGridView';
		$model=new ViewInterview('search');
		if (isset($_GET['ajax'])) {
			if(isset($_GET['ViewInterview']))
				$model->attributes=$_GET['ViewInterview'];
				
			$this->renderPartial('_viewInterviewResumes',array('model'=>$model));
		}
		else
		{
			$this->render('viewInterviewResumes',array('model'=>$model));
		}
	}
	
	public function actionUpdate(){
	
		if (isset($_POST) && isset($_POST['stu_job_id'])&& isset($_POST['interviewDate']) ) {
			$stuJobId=$_POST['stu_job_id'];
			$interviewResume=InterviewStudentJobTitle::model()->findByAttributes(array('stu_job_id'=>$stuJobId,'employer_id'=>Yii::app()->user->id));
			if ($interviewResume!=null) {
					$interviewResume->interview_date=$_POST['interviewDate'];
					if ($interviewResume->save()) {
						$this->renderPartial('/common/_alerts',array('type'=>'success','msg'=>Yii::t('app', 'msg.success.update_interview_resume')));
					}else {
						$this->renderPartial('/common/_alerts',array('type'=>'danger','msg'=>Yii::t('app', 'msg.error.update_interview_resume')));
					}
						
			}else {
				$this->renderPartial('/common/_alerts',array('type'=>'danger','msg'=>Yii::t('app', 'msg.error.resume_not_found')));
			}
			
		}else{
			$this->renderPartial('/common/_alerts',array('type'=>'danger','msg'=>Yii::t('app', 'msg.error.resume_not_found')));
		}
	}
	
	public function actionDelete($id) {
		if (isset($_GET['ajax'])) {
			if (isset($id)) {
				$interviewRes=InterviewStudentJobTitle::model()->findByAttributes(array('stu_job_id'=>$id,'employer_id'=>Yii::app()->user->id));
				if($interviewRes!=null){			
					if($interviewRes->deleteInterview()){
						$this->renderPartial('/common/_alerts',array('type'=>'success','msg'=>Yii::t('app', 'msg.success.del_interview_resume')));
					}else {
						$this->renderPartial('/common/_alerts',array('type'=>'danger','msg'=>Yii::t('app', 'msg.error.del_interview_resume')));
					}
					return;
				}
			}
			$this->renderPartial('/common/_alerts',array('type'=>'danger','msg'=>Yii::t('app', 'msg.error.resume_not_found')));
		}
	}

	public function actionDeleteSelected() {
		if (isset($_GET['ajax'])) {
			if (isset($_POST) && isset($_POST['stu_job_id']) && !empty($_POST['stu_job_id'])) {
				try {
					if(InterviewStudentJobTitle::deleteResumes($_POST['stu_job_id'], Yii::app()->user->id)){
						$this->renderPartial('/common/_alerts',array('type'=>'success','msg'=>Yii::t('app', 'msg.success.del_interview_resumes')));
					}
				} catch (Exception $e) {
					$this->renderPartial('/common/_alerts',array('type'=>'danger','msg'=>Yii::t('app', 'msg.error.del_interview_resumes')));
				}
				return;
			}
			$this->renderPartial('/common/_alerts',array('type'=>'danger','msg'=>Yii::t('app', 'msg.error.resumes_not_found')));
		}
	}
	
}