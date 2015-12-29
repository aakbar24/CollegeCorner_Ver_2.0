<?php

class WorkshopController extends BackEndController
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
						'modelName' => 'PostItem',
				),
				'toggleApproved' => array(
						'class'=>'bootstrap.actions.TbToggleAction',
						'modelName' => 'Workshop',
				),
            /*'toggleRunning' => array(
                'class'=>'bootstrap.actions.TbToggleAction',
                'modelName' => 'Workshop',
            )*/);
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
				'actions'=>array('create','update','admin','delete','index','view','toggleActive','toggleApproved','toggleRunning'),
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
			'model'=>new WorkshopForm('view',$id),
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new WorkshopForm;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['WorkshopForm']))
		{
			$model->attributes=$_POST['WorkshopForm'];
			$model->postItem->attributes=$_POST['PostItem'];
			$model->workshop->attributes=$_POST['Workshop'];

            $model->workshopFile = CUploadedFile::getInstance($model, 'workshopFile');
            Yii::log(CVarDumper::dumpAsString($model->workshopFile));

			if($model->validate())
            {
                $fileUpload = $model->workshopFile;

                if ($fileUpload !== null)
                {
                    Yii::log(CVarDumper::dumpAsString($fileUpload));
                    $model->workshop->workshop_file = $fileUpload;
                    $fileName = $fileUpload->name;
                }

                if ($model->save())
                {
                    if ($model->workshop->workshop_file !== null)
                    {
                        $userFilePath=FileHelper::getFilePath(Yii::getPathOfAlias('site.files').'/workshops/'.$model->postItem->primaryKey.'/');
                        $model->workshopFile->saveAs($userFilePath.$fileName);
                    }
				$this->redirect(array('view','id'=>$model->workshop->post_item_id));
                }
            }
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
		$model=new WorkshopForm('view',$id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

        if(isset($_POST['WorkshopForm']))
        {
            $model->attributes=$_POST['WorkshopForm'];
            $model->postItem->attributes=$_POST['PostItem'];
            $model->workshop->attributes=$_POST['Workshop'];

            $model->workshopFile = CUploadedFile::getInstance($model, 'workshopFile');
            Yii::log(CVarDumper::dumpAsString($model->workshopFile));

            if($model->validate())
            {
                $fileUpload = $model->workshopFile;

                if ($fileUpload !== null)
                {
                    $model->workshop->removeFile();
                    $model->workshop->workshop_file = $fileUpload;
                    $fileName = $fileUpload->name;
                }

                if ($model->save())
                {
                    if ($model->workshop->workshop_file !== null)
                    {
                        $userFilePath=FileHelper::getFilePath(Yii::getPathOfAlias('site.files').'/workshops/'.$model->postItem->primaryKey.'/');
                        $model->workshopFile->saveAs($userFilePath.$fileName);
                    }
                    $this->redirect(array('view','id'=>$model->workshop->post_item_id));
                }
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
			if (!Workshop::deleteWorkshopPost($id)) {
				throw new CHttpException(400,'Failed! Unable to delete this event.');
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
		$dataProvider=new CActiveDataProvider('Workshop');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Workshop('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Workshop']))
			$model->attributes=$_GET['Workshop'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

    public function actionToggleRunning($id, $attribute)
    {
        Yii::log("ID: " . $id . " Attribute: " , $attribute, "log");
        if (Yii::app()->getRequest()->isPostRequest)
        {
            $model = $this->loadModel($id);
            $model->$attribute = ($model->$attribute == 0) ? 1 : 0;

            if ($model->$attribute == 1)
                $model->scenario = 'running';

            $success = $model->save(true, null);

            if (Yii::app()->getRequest()->isAjaxRequest)
            {
                if ($success)
                    $message = $model->$attribute ? "Workshop is now running" : "Workshop is no longer running";
                else
                    $message = $model->$attribute ? ("Workshop cannot be run\n\n " . strip_tags(CHtml::errorSummary($model))) : "Problem changing Workshop status";

                echo $message;
                exit(0);
            }
            $this->redirect(array('admin'));
        } else
            throw new CHttpException(Yii::t('zii', 'Invalid request'));
    }

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=Workshop::model()->findByPk($id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='workshop-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
