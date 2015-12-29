<?php
class EmployerHiredController extends ProfileRelatedController
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
				'postOnly +  hire, unhire, unhireSelected',
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
								'hire','unhire','unhireSelected'
								),
						'users'=>array('@'),
						'expression'=>'intval($user->user_group_id)===Employer::USER_GROUP_ID' //only allow employer to access
				),
				array('deny',  // deny all users
						'users'=>array('*'),
				),
		);
	}
	
	
	public function actionHire($stu_job_id){
		if (isset($stu_job_id)) {
			$resumeToHire=StudentJobTitle::getResumeToHire($stu_job_id);
			if ($resumeToHire!=null) {
				if ($resumeToHire->hire(Yii::app()->user->id)) {
					$this->renderPartial('/common/_alerts',array('type'=>'success','msg'=>Yii::t('app', 'msg.success.hire_resume')));
				}else {
					$this->renderPartial('/common/_alerts',array('type'=>'danger','msg'=>Yii::t('app', 'msg.error.hire_resume')));
				}
			}
			else{
				$this->renderPartial('/common/_alerts',array('type'=>'danger','msg'=>Yii::t('app', 'msg.error.resume_not_found')));
			}
		}
	}
	
	public function actionIndex(){
		$this->layout='/layouts/_empResumeGridView';
		$model=new ViewStudentJobTitle('search');
		if (isset($_GET['ajax'])) {
			if(isset($_GET['ViewStudentJobTitle']))
				$model->attributes=$_GET['ViewStudentJobTitle'];
			
			if($_GET['ajax']=='resume-grid-view-archive')
				$this->renderPartial('_viewHiredArchiveResumes',array('model'=>$model));
			else
				$this->renderPartial('_viewHiredResumes',array('model'=>$model));
		}
		else
		{
			$this->render('viewHiredResumes',array('model'=>$model));
		}
	}
	
	public function actionUnhire($stu_job_id){
		if (isset($stu_job_id)) {
			$resumeToUnHire=StudentJobTitle::getResumeToUnHire($stu_job_id,Yii::app()->user->id);
			if ($resumeToUnHire!=null) {
				if ($resumeToUnHire->unhire(Yii::app()->user->id)) {
					$this->renderPartial('/common/_alerts',array('type'=>'success','msg'=>Yii::t('app', 'msg.success.unhire_resume')));
				}else {
					$this->renderPartial('/common/_alerts',array('type'=>'danger','msg'=>Yii::t('app', 'msg.error.unhire_resume')));
				}
			}
			else{
				$this->renderPartial('/common/_alerts',array('type'=>'danger','msg'=>Yii::t('app', 'msg.error.resume_not_found')));
			}
		}
	}
	
	public function actionUnhireSelected() {
		if (isset($_GET['ajax'])) {
			if (isset($_POST) && isset($_POST['stu_job_id']) && !empty($_POST['stu_job_id'])) {
				try {
					if(StudentJobTitle::unhireResumes($_POST['stu_job_id'], Yii::app()->user->id)){
						$this->renderPartial('/common/_alerts',array('type'=>'success','msg'=>Yii::t('app', 'msg.success.unhire_resumes')));
					}
				} catch (Exception $e) {
					$this->renderPartial('/common/_alerts',array('type'=>'danger','msg'=>Yii::t('app', 'msg.error.unhire_resume')));
				}
				return;
			}
			$this->renderPartial('/common/_alerts',array('type'=>'danger','msg'=>Yii::t('app', 'msg.error.resumes_not_found')));
		}
	}
	
}