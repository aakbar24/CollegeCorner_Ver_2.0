<?php

class CertificationController extends ProfileRelatedController
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='/layouts/certificationLayout';

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
					'actions'=>array('index','view'),
					'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update','toggleActive','manage','delete'),
				'users'=>array('@'),
				'expression'=>'$user->isEmployer()',
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}
	
	public function actions(){
		return array(
				'toggleActive' => array(
						'class'=>'bootstrap.actions.TbToggleAction',
						'modelName' => 'PostItem',
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
		$model=new CertificationForm();
		$model->certification->provider_id=Yii::app()->user->id;
		$model->certification->provider=Employer::model()->findByPk(Yii::app()->user->id,array('select'=>'company_name'))->company_name;
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Certification'])&&isset($_POST['PostItem']))
		{
			$model->postItem->attributes=$_POST['PostItem'];
			$model->certification->attributes=$_POST['Certification'];
			
			$fileUpload = CUploadedFile::getInstance($model->certification, 'cert_image');
				
			if ($fileUpload !== null)
			{
				//$model->certification->removeCertImage();
				$model->certification->cert_image = $fileUpload;
			}
				
			if($model->validate()&&$model->save()){
				if ($fileUpload !== null)
					$model->certification->cert_image->saveAs($model->certification->getCertImagePath());
				Yii::app()->user->setFlash('success', Yii::t('app', 'msg.success.create_certificate'));
				$this->redirect(array('view','id'=>$model->postItem->post_item_id));
			}
			
			/* if($model->validate()&&$model->save())
				$this->redirect(array('view','id'=>$model->postItem->post_item_id)); */
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
		$model=new CertificationForm('view',$id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Certification'])&&isset($_POST['PostItem']))
		{
			$model->postItem->attributes=$_POST['PostItem'];
			$model->certification->attributes=$_POST['Certification'];
			
			$fileUpload = CUploadedFile::getInstance($model->certification, 'cert_image');
			
			if ($fileUpload !== null)
			{
				$model->certification->removeCertImage();
				$model->certification->cert_image = $fileUpload;
			}
			
			if($model->validate()&&$model->save()){
				if ($fileUpload !== null)
					$model->certification->cert_image->saveAs($model->certification->getCertImagePath());
				Yii::app()->user->setFlash('success', Yii::t('app', 'msg.success.update_certificate'));
				$this->redirect(array('view','id'=>$model->postItem->post_item_id));
			}
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
			if (!Certification::deleteCertificationPost($id)) {
				throw new CHttpException(400,'Failed! Unable to delete this certification.');
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
		$model=new Certification('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Certification']))
			$model->attributes=$_GET['Certification'];
		
		$dataProvider=$model->search();
		$this->render('index',array(
			'model'=>$model
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionManage()
	{
		$model=new Certification('search');
		$model->unsetAttributes();  // clear any default values
		//$model->user_id=Yii::app()->user->id;
		$model->provider_id=Yii::app()->user->id;
		if(isset($_GET['Certification']))
			$model->attributes=$_GET['Certification'];

		$this->render('manage',array(
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
		$model=Certification::getCertification($id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='certification-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
