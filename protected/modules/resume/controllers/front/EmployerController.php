<?php
class EmployerController extends ProfileRelatedController
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
				'postOnly + ',
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
						'actions'=>array('index','viewResumeDetails',
								'searchResumes','ajaxGetJobTitles',
								),
						'users'=>array('@'),
						'expression'=>'intval($user->user_group_id)===Employer::USER_GROUP_ID' //only allow employer to access
				),
				array('deny',  // deny all users
						'users'=>array('*'),
				),
		);
	}
	
	public function actionIndex()
	{
		$this->layout='/layouts/_empResumeGridView';
		$model=new ViewStudentJobTitle('search');
		if (isset($_GET['ajax'])) {
		
			if(isset($_GET['ViewStudentJobTitle']))
				$model->attributes=$_GET['ViewStudentJobTitle'];
			
			$this->renderPartial('gridviews/_index',array('model'=>$model));
		}
		else 
		{
			$this->render('index',array('model'=>$model));
		}
		
	}
	
	public function actionViewResumeDetails()
	{
		if (isset($_POST['id'])) {
			$data=ViewStudentJobTitle::getStuResumeWithEmployer($_POST['id'],Yii::app()->user->id);//ViewStudentJobTitle::model()->findByPk($_POST['id']);
			if ($data!==null) {
				$view=isset($_GET['view'])?$_GET['view']:null;
				$this->renderPartial('gridviews/_resumeGridDetails',array('data'=>$data,'view'=>$view));
			}else{
				echo '<div class="alert alert-error"><strong>Error!</strong> Student Resume Not Found!</div>';
			}
			
		}else {
			throw new CHttpException(400,'No Student Resume ID provided.');
		}
	}
	
	public function actionSearchResumes()
	{
		$model=new ViewStudentJobTitle('search');

		if (isset($_GET['ajax'])) {
		
			//$displayLimit=null;
			if(isset($_GET['ViewStudentJobTitle']))
				$model->attributes=$_GET['ViewStudentJobTitle'];
			
			
			$this->renderPartial('listviews/_viewResumes',array('model'=>$model));
		}
		else 
		{
			//$displayLimit=isset($_POST['ViewStudentJobTitle']['pageSize'])?$_POST['ViewStudentJobTitle']['pageSize']:Yii::app()->params['defaultPageLimit'];
			if(isset($_POST['ViewStudentJobTitle'])){
			
			$model->attributes=$_POST['ViewStudentJobTitle'];
			}
	
			$this->render('searchResumes',array('model'=>$model));
		}
		
		
	}
	
	public function actionAjaxGetJobTitles(){
		
		if (isset($_POST['jobCat'])) {
		
			$titles=CHtml::listData(JobTitle::getAllTitlesByCategory($_POST['jobCat']),'job_title_id','job_title_name');
			echo '<option value="">'.Yii::t('model', 'viewStudentJobTitle.jobTitles_empty').'</option>';
			foreach ($titles as $value=>$name) {
				echo CHtml::tag('option',
						array('value'=>$value),CHtml::encode($name),true);
			}
		}
	}
}