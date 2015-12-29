<?php
class StudentHiredController extends ProfileRelatedController
{

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
				'accessControl', // perform access control
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
						'actions'=>array('index',),
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
		$model=new ViewStudentJobTitle('search');

		if (isset($_GET['ajax'])) {
			if(isset($_GET['ViewStudentJobTitle']))
				$model->attributes=$_GET['ViewStudentJobTitle'];
			
			$this->renderPartial('gridviews/_index',array('model'=>$model));
		}
		else 
		{
			$data=array('previousHired'=>$model,'currentHired'=>$model->searchCurrentHiredByStu(Yii::app()->user->id));
			$this->render('index',$data);
		}
		
	}
	
}