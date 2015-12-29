<?php
class StudentInterviewController extends ProfileRelatedController
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
				'postOnly + checkCancel',
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
				
				array('allow', // actions that only allow students to perform
						'actions'=>array('index','checkCancel'),
						'users'=>array('@'),
						'expression'=>'intval($user->user_group_id)===Student::USER_GROUP_ID' //only allow student to access
				),
				array('deny',  // deny all users
						'users'=>array('*'),
				),
		);
	}
	
	public function actionIndex()
	{
		$this->layout='/layouts/_stuResumeGridView';
		$model=new ViewInterview('search');

		if (isset($_GET['ajax'])) {
			if(isset($_GET['ViewInterview']))
				$model->attributes=$_GET['ViewInterview'];
			
			$this->renderPartial('gridviews/_index',array('model'=>$model));
		}
		else 
		{
			$interviewCancelForm=new InterviewCancelForm(InterviewCancelForm::TYPE_STU);
			$data=array('model'=>$model,'interviewCancelForm'=>$interviewCancelForm);
			$data=$this->performCancel($data);
			$this->render('index',$data);
		}
		
	}
	
	public function actionCheckCancel(){
		$model=new InterviewCancelForm(InterviewCancelForm::TYPE_STU);
		$this->performAjaxValidation($model);
	}
	
	protected function performCancel($data){
		if (isset($_POST['InterviewCancelForm'])) {
			
			$interviewCancelForm=new InterviewCancelForm(InterviewCancelForm::TYPE_STU);
			$interviewCancelForm->attributes=$_POST['InterviewCancelForm'];
			
			if ($interviewCancelForm->validate()&&$interviewCancelForm->send()) {
				$data['alertType']='success';
				$data['alertMsg']=Yii::t('app', 'msg.success.del_interview_resume');
			}
			else {
				$data['alertType']='error';
				$data['alertMsg']=Yii::t('app', 'msg.error.del_interview_resume');
			}
		}
		return $data;
	}
	
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='interview-cancel-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}