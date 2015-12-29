<?php

class WorkshopController extends ProfileRelatedController
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */

	public $tabMenus=null;
	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
			'postOnly + signup'
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
					'actions'=>array('index','view','feed'),
					'users'=>array('*'),
			),
			array('allow', 
				'actions'=>array('create','update','manage','delete'),
				'users'=>array('@'),
				'expression'=>'$user->isEmployer()',
			),
				
			array('allow',
					'actions'=>array('signup'),
					'users'=>array('@'),
					'expression'=>'$user->isStudent()',
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
		$this->layout='//layouts/resource';

        $this->tabMenus=array(
            array('label'=>'Articles', 'url'=>array('/site/articles')),
            array('label'=>'News', 'url'=>array('/site/news')),
            array('label'=>'Events', 'url'=>array('/event/event/index')),
            array('label'=>'Workshops', 'active'=>true),
        );
		
		$alreadySignup=false;
		if (Yii::app()->user->isStudent()) {
			$alreadySignup=StudentWorkshop::model()->exists('user_id=:user_id AND post_item_id=:post_item_id',array(':user_id'=>Yii::app()->user->id,':post_item_id'=>$id));
		}
		
		$this->render('view',array(
			'model'=>new WorkshopForm('view',$id,true),
			'alreadySignup'=>$alreadySignup,
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
                    $this->redirect(array('manage'));
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
                    Yii::app()->user->setFlash('success', Yii::t('app', 'msg.success.update_workshop'));
                    $this->redirect(array('view','id'=>$model->workshop->post_item_id));
                }
                else
                    Yii::app()->user->setFlash('error', Yii::t('app', 'msg.error.update_workshop'));
            }
            else
                Yii::app()->user->setFlash('error', Yii::t('app', 'msg.error.update_workshop'));
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
			if(!isset($_GET['ajax'])){
				$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
			}else{
				$this->renderPartial('//common/_alerts',array('type'=>'success','msg'=>Yii::t('app', 'msg.success.delete_workshop')));
			}
		}
		else
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$this->layout='//layouts/resource';
		$this->render('index');
	}

	public function actionManage()
	{
		$model=new Workshop('search');
		$model->unsetAttributes();  // clear any default values
		$model->userId=Yii::app()->user->id;
		$model->is_active=true;
		if(isset($_GET['Workshop']))
			$model->attributes=$_GET['Workshop'];
		
		if (isset($_GET['ajax'])) {
			$this->renderPartial('gridviews/_manage',array('model'=>$model));
			Yii::app()->end();
		}else{
			$this->render('manage',array(
					'model'=>$model,
			));
		}
		
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
	
	public function actionFeed(){
		if (isset($_GET['start']) && isset($_GET['end'])) {
			$model=new Workshop('search');
			
			$workshops=$model->searchWorkshopsForFeed($_GET['start'],$_GET['end']);
				
			if (!empty($workshops)) {
				$workshopSources=array();
				foreach ($workshops as $key=>$workshop) {
					$workshopSources[$key]['id']=$workshop['post_item_id'];
					$workshopSources[$key]['title']=$workshop['title'];
					$workshopSources[$key]['start']=$workshop['start_date'].' '.$workshop['start_time'];
					$workshopSources[$key]['end']=$workshop['end_date'].' '.$workshop['end_time'];
					$workshopSources[$key]['allDay']=false;
					
					$workshopSources[$key]['provider']='Provider: '.($workshop['employer']!=null?$workshop['employer']:Yii::app()->name);
					$workshopSources[$key]['url']=$this->createAbsoluteUrl('view',array('id'=>$workshop['post_item_id']));
				}
				echo CJSON::encode($workshopSources);
				 
			}
		}
		Yii::app()->end();
	}
	
	public function actionSignup($id){
		if (isset($id)) {
			if (Yii::app()->request->isPostRequest) {
				/* @var $workshop Workshop */
				$workshop=Workshop::model()->findByPk($id);
				if ($workshop!=null && $workshop->is_approved==1) {
					
					$studentWorkshop=new StudentWorkshop();
					$studentWorkshop->user_id=Yii::app()->user->id;
					$studentWorkshop->post_item_id=$id;
						
					if ($studentWorkshop->save()) {
						Yii::app()->user->setFlash('success', Yii::t('app', 'msg.success.workshop_signup'));
						$this->redirect(array('view','id'=>$id));
					}
				}else{
					throw new CHttpException(400,'Event not found.');
				}
			}else{
				throw new CHttpException(400,'Invalid Request');
			}
		}
		else{
			throw new CHttpException(400,'Event not found.');
		}
	}
}
