<?php

class StudentWorkshopController extends ProfileRelatedController
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='/layouts/studentWorkshopTab';

	public $tabMenus=null;
	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
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
			
			array('allow', 
					'actions'=>array('index','history'),
					'users'=>array('@'),
					'expression'=>'$user->isStudent()',
			),
				
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$model=new StudentWorkshop('search');
		$model->user_id=Yii::app()->user->id;
		$model->is_active=true;
		
		$model->unsetAttributes();
		if (isset($_GET['ajax'])) {
			$model->attributes=$_GET['StudentWorkshop'];
		}
		
		$this->render('index',array('model'=>$model));
	}
	
	public function actionHistory()
	{
		$model=new StudentWorkshop('search');
		$model->user_id=Yii::app()->user->id;
		$model->is_active=true;
		
		$model->unsetAttributes();
		if (isset($_GET['ajax'])) {
			$model->attributes=$_GET['StudentWorkshop'];
		}
		
		$this->render('history',array('model'=>$model));
	}
	
}
