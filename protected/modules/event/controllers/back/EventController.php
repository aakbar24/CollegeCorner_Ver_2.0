<?php

class EventController extends BackEndController
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';

	public function actions(){
		return array(
				'toggle' => array(
        				'class'=>'bootstrap.actions.TbToggleAction',
						'modelName' => 'PostItem',
        ));
	}
	
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
			
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('index','view','create','update','admin','delete'),
				'users'=>array('@'),
				'expression'=>'$user->isCollegeAdmin() || $user->isAdmin() || $user->isSuperAdmin()',
			),
				
			array('allow',
					'actions'=>array('toggle'),
					'users'=>array('@'),
					'expression'=>'$user->isCollegeAdmin() || $user->isAdmin() || $user->isSuperAdmin()',
			),
			
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		$this->render('view',array(
			'model'=>new EventForm('view',$id),
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new EventForm;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['EventForm']))
		{
			$model->attributes=$_POST['EventForm'];
			$model->postItem->attributes=$_POST['PostItem'];
			$model->event->attributes=$_POST['Event'];
			if($model->validate() && $model->save())
				$this->redirect(array('view','id'=>$model->event->post_item_id));
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model=new EventForm('view',$id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['EventForm']))
		{
			$model->attributes=$_POST['EventForm'];
			$model->postItem->attributes=$_POST['PostItem'];
			$model->event->attributes=$_POST['Event'];
			if($model->validate() && $model->save())
				$this->redirect(array('view','id'=>$model->event->post_item_id));
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		if(Yii::app()->request->isPostRequest)
		{
			// we only allow deletion via POST request
			//$this->loadModel($id)->delete();
			if (Yii::app()->user->isCollegeAdmin()) {
				if (!Event::deleteEventPost($id,Yii::app()->user->id)) {
					throw new CHttpException(400,'Failed! Unable to delete this event.');
				}
			}else{
				if (!Event::deleteEventPost($id)) {
					throw new CHttpException(400,'Failed! Unable to delete this event.');
				}
			}
			
			// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
			if(!isset($_GET['ajax']))
				$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
		}
		else
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$model=new Event('search');
		if (Yii::app()->user->isCollegeAdmin()) {
			
			$model->userId=Yii::app()->user->id;
			$model->is_active=true;
			
		}
		
		$dataProvider=$model->search();
		
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Event('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Event']))
			$model->attributes=$_GET['Event'];
		
		if (Yii::app()->user->isCollegeAdmin()) {
			$model->userId=Yii::app()->user->id;
			$model->is_active=true;
		}
		
		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=Event::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param CModel the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='event-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
