<?php

class WorkshopFacilitatorController extends BackEndController
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
    public $layout='//layouts/workshopLayout';

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
		);
	}
	
	public function actions(){
		return array(
				'toggleActive' => array(
						'class'=>'bootstrap.actions.TbToggleAction',
						'modelName' => 'WorkshopFacilitator',
				),
            'upload'=>array(
                'class'=>'bootstrap.actions.TbUberUploadAction',
                'uploadPath'=>Yii::getPathOfAlias('site.files').'/uploads/facilitator',
            ),
            'crop'=>array(
                'class'=>'bootstrap.actions.TbUberCropAction',
                'uploadPath'=>Yii::getPathOfAlias('site.files').'/uploads/facilitator',
                'cropWidth'=>140,
            )
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
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('view','create','update','admin','delete','toggleActive','upload','crop'),
				'users'=>array('@'),
				'expression'=>'$user->isAdmin() || $user->isSuperAdmin()',
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
			'model'=>$this->loadModel($id),
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new WorkshopFacilitator;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['WorkshopFacilitator']))
		{
			$model->attributes=$_POST['WorkshopFacilitator'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->workshop_facilitator_id));
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
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['WorkshopFacilitator']))
		{
			$model->attributes=$_POST['WorkshopFacilitator'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->workshop_facilitator_id));
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
			WorkshopFacilitator::deleteFacilitator($id);

			// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
			if(!isset($_GET['ajax']))
				$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
		}
		else
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new WorkshopFacilitator('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['WorkshopFacilitator']))
			$model->attributes=$_GET['WorkshopFacilitator'];

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
		$model=WorkshopFacilitator::model()->findByPk($id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='workshop-facilitator-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
