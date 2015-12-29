<?php

class CertificationCatController extends BackEndController
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';

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
				'actions'=>array('create','update','admin','delete',),
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
		$model=new CertificationCat;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['CertificationCat']))
		{
			$model->attributes=$_POST['CertificationCat'];
			if($model->save()){
				Yii::app()->user->setFlash('success', Yii::t('app', 'msg.success.save_workshop_cat'));
				$this->redirect(array('admin'));
			}
		}
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate()
	{
		
		if (Yii::app()->request->isPostRequest) {
			$id=$_POST['pk'];
			$name=$_POST['name'];
			$value=$_POST['value'];
			$model=$this->loadModel($id);
				
			if ($model==null)
				throw new CHttpException(400,'Unable to find the category');
				
			$model->setAttribute($name, $value);
			if(!$model->save())
				throw new CHttpException(400,'Unable to update the category');
				
		}else{
			throw new CHttpException(400,'Your request is invalid.');
		}
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
			CertificationCat::deleteCat($id);

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
		$dataProvider=new CActiveDataProvider('CertificationCat');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new CertificationCat('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['CertificationCat']))
			$model->attributes=$_GET['CertificationCat'];
		
		$data=array();
		$data['model']=$model;
		$data['createModel']=new CertificationCat();
		if (Yii::app()->user->hasFlash('success')) {
			$data['msg']=Yii::app()->user->getFlash('success');
			$data['type']='success';
		};
		$this->render('admin',$data);
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=CertificationCat::model()->findByPk($id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='certification-cat-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
