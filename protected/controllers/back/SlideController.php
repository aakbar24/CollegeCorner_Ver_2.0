<?php

class SlideController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/slideLayout';

    public $positions = null;

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
    public function accessRules() {
        return array(
            array('allow', // allow authenticated user to perform 'create' and 'update' actions
                'actions' => array('index', 'view', 'create', 'update', 'admin', 'delete'),
                'users' => array('@'),
                'expression' => '$user->isCollegeAdmin() || $user->isAdmin() || $user->isSuperAdmin()',
            ),
            array('allow',
                'actions' => array('toggle'),
                'users' => array('@'),
                'expression' => '$user->isCollegeAdmin() || $user->isAdmin() || $user->isSuperAdmin()',
            ),
            array('deny', // deny all users
                'users' => array('*'),
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
        Yii::log("File Path: " . Yii::getPathOfAlias('site.files') . '/images/slides/', 'log');

		$model=new Slide;

        $maxPositions = Slide::model()->count();
        $model->position = $maxPositions;

		if(isset($_POST['Slide']))
		{
			$model->attributes=$_POST['Slide'];

            $fileUpload = CUploadedFile::getInstance($model, 'slide_image');
            Yii::log(CVarDumper::dumpAsString($fileUpload));

            if ($fileUpload !== null)
                $model->slide_image = $fileUpload;

			if($model->validate() && $model->save())
            {
                if ($fileUpload !== null)
                    $model->slide_image->saveAs(Yii::getPathOfAlias('site.files') . '/images/slides/' . $model->slide_image . "_" . $model->getPrimaryKey());
				$this->redirect(array('view','id'=>$model->slide_id));
            }
		}

        $viewablePositions = array();
        foreach(range(0,$maxPositions) as $position)
        {
            $viewablePositions[$position] = Formatter::formatOrdinal($position + 1);
        }

        $this->positions = $viewablePositions;

		$this->render('create',array(
			'model'=>$model
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
        /* @param Slide $model*/
		$model=$this->loadModel($id);

        $maxPositions = Slide::model()->count();

        Yii::log("PrevImage: " . $model->slide_image, 'log');

		if(isset($_POST['Slide']))
		{
            $model->oldPosition = $model->position;

			$model->attributes=$_POST['Slide'];
            Yii::log("CurrImage: " . $model->slide_image, 'log');

            $fileUpload = CUploadedFile::getInstance($model, 'slide_image');
            Yii::log("FileUpload: " . CVarDumper::dumpAsString($fileUpload), 'log');

            if ($fileUpload !== null)
            {
                $model->removeImage();
                $model->slide_image = $fileUpload;
            }

			if($model->validate() && $model->save())
            {
                if ($fileUpload !== null)
                    $model->slide_image->saveAs(Yii::app()->basePath . '/../files/images/slides/' . $model->slide_image . "_" . $model->getPrimaryKey());

				$this->redirect(array('view','id'=>$model->slide_id));
            }
		}

        $viewablePositions = array();
        foreach(range(0,$maxPositions - 1) as $position)
        {
            $viewablePositions[$position] = Formatter::formatOrdinal($position + 1);
        }

        $this->positions = $viewablePositions;

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
			$this->loadModel($id)->delete();

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
		$dataProvider=new CActiveDataProvider('Slide', array('criteria' => array('order' => 'position')));
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Slide('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Slide']))
			$model->attributes=$_GET['Slide'];

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
		$model=Slide::model()->findByPk($id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='slide-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
