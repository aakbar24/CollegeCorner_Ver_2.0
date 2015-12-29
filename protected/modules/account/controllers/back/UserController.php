<?php

class UserController extends BackEndController
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/userLayout';

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
	 * Declares class-based actions.
	 */
	public function actions(){
		return array(
				'upload'=>array(
						'class'=>'bootstrap.actions.TbUberUploadAction',
						'uploadPath'=>CollegeDetails::getLogoImageUploadPath(),
				),
				'crop'=>array(
						'class'=>'bootstrap.actions.TbUberCropAction',
						'uploadPath'=>CollegeDetails::getLogoImageUploadPath(),
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
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
					'actions'=>array('editAccount'),
					'users'=>array('@'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('update','index','view','delete','admin','createCollegeAdmin', 'verifyEmployers', 'verifyStudents', 'verifyUser', 'sendActivation'),
				'users'=>array('@'),
				'expression'=>'$user->isAdmin()|| $user->isSuperAdmin()',
			),
			array('allow', // allow super admin user to 'create' action
				'actions'=>array('create'),
				'users'=>array('@'),
				'expression'=>'$user->isSuperAdmin()',
			),
			array('allow', // allow college admin user to perform 'updateCollegeDetails' action
					'actions'=>array('updateCollegeDetails','crop','upload'),
					'users'=>array('@'),
					'expression'=>'$user->isCollegeAdmin()',
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
		$model=new RegisterForm();

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['RegisterForm']))
		{
			$model->attributes=$_POST['RegisterForm'];
			$model->user->attributes=$_POST['User'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->user->user_id));
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}
	
	/**
	 * Creates a new college admin.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreateCollegeAdmin()
	{
		$model=new CollegeAdminRegisterForm();
	
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);
	
		if(isset($_POST['CollegeAdminRegisterForm']))
		{
			$model->attributes=$_POST['CollegeAdminRegisterForm'];
			$model->user->attributes=$_POST['User'];
			$model->collegeAdmin->attributes=$_POST['CollegeAdmin'];
			if($model->validate()&&$model->save())
				$this->redirect(array('view','id'=>$model->user->user_id));
		}
	
		$this->render('createCollegeAdmin',array(
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

		if(isset($_POST['User']))
		{
			$model->attributes=$_POST['User'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->user_id));
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
		if (Yii::app()->user->isAdmin()) {
			$dataProvider=new Admin('search');
			$dataProvider->unsetAttributes();
			$dataProvider=$dataProvider->search(Yii::app()->user->id);
		}else if (Yii::app()->user->isSuperAdmin()) {
			$dataProvider=new SuperAdmin('search');
			$dataProvider->unsetAttributes();
			$dataProvider=$dataProvider->search(Yii::app()->user->id);
		}
		
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$data=$this->_getAdminSearchData();
		
		$this->render('admin',$data);
	}

    public function actionVerifyEmployers()
    {
    $model = new Employer('search');

        $model->unsetAttributes();

        if(isset($_GET['Employer'])){
            $model->attributes=$_GET['Employer'];
        }

        $dataProvider = $model->searchInactive();

        $this->render('verifyEmployers', array('model' => $model, 'dataProvider' => $dataProvider));
    }

    public function actionVerifyStudents()
    {
        $model = new Student('search');

        $model->unsetAttributes();

        if(isset($_GET['Student'])){
            $model->attributes=$_GET['Student'];
        }

        $dataProvider = $model->searchInactive();

        $this->render('verifyStudents', array('model' => $model, 'dataProvider' => $dataProvider));
    }
	
	private function _getAdminSearchData(){
		$model=null;
		$modelClass='';
		$dataProvider=null;
		switch (Yii::app()->user->user_group_id){
			case Admin::USER_GROUP_ID:
				$model=new Admin('search');
				$modelClass='Admin';
			break;
			
			case SuperAdmin::USER_GROUP_ID:
				$model=new SuperAdmin('search');
				$modelClass='SuperAdmin';
			break;
			
			default:
				break;
		}
		
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET[$modelClass])){
			$model->attributes=$_GET[$modelClass];
		}
		
		if (Yii::app()->user->isAdmin())
			$dataProvider=$model->search();
		else if(Yii::app()->user->isSuperAdmin())
			$dataProvider=$model->search(Yii::app()->user->id);
		
		return array('model'=>$model,'dataProvider'=>$dataProvider);
	}
	
	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=User::model()->findByPk($id,'t.user_id <> :excludeUserId',array(':excludeUserId'=>Yii::app()->user->id));
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='user-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
	
	/**
	 * Edit the current user account.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionEditAccount() 
	{
		$this->breadcrumbs=array(
				Yii::t('view', 'auth.edit_account_title_lb'),
		);
		
		$this->layout='//layouts/column1';

		$user=User::model()->findByPk(Yii::app()->user->id);
		$model=new AccountForm();
		$model->user=$user;
		if (isset($_POST['AccountForm']) && isset($_POST['User'])) 
		{
			$model->user->attributes=$_POST['User'];
			$model->attributes=$_POST['AccountForm'];
			if ($model->validate() && $model->save()) 
			{
				$model->user->setState(Yii::app()->user,true);
				Yii::app()->user->setFlash('success', Yii::t('app', 'msg.success.update_account_info'));
				$this->refresh(true);
			}
		}
		$this->render('application.modules.account.views.common.profile.editAccount', array('model'=>$model));
	}
	
	public function actionUpdateCollegeDetails()
	{
		$this->layout='//layouts/column1';
	
		$user=User::model()->with('collegeAdmin','collegeAdmin.college','collegeAdmin.college.collegeDetails')->together()->findByPk(Yii::app()->user->id);
		$model=$user->collegeAdmin->college->collegeDetails;
		if ($model==null) {
			$model=new CollegeDetails();
			$model->college_id=$user->collegeAdmin->college_id;
		}
		
		if (isset($_POST['CollegeDetails']))
		{
			$model->attributes=$_POST['CollegeDetails'];
			if ($model->validate() && $model->saveWithLogoImage())
			{
				Yii::app()->user->setFlash('success', Yii::t('app', 'msg.success.update_college_details'));
			}
		}
		$this->render('updateCollegeDetails', array('model'=>$model,'collegeAdmin'=>$user->collegeAdmin));
	}

    public function actionVerifyUser($user_id)
    {
        $user = User::model()->findByPk($user_id);

        Yii::log($user->user_group_id, 'log');

        if ($user->verify())
        {
        Yii::app()->user->setFlash('success', $user->username . '\'s account is now verified.');
            switch($user->user_group_id)
            {
                case Student::USER_GROUP_ID:
                    Emailer::emailStudentVerified($user);
                    break;
                case Employer::USER_GROUP_ID:
                    Emailer::emailEmployerVerified($user);
                    break;
            }
        }
        else
            Yii::app()->user->setFlash('error', $user->username . '\'s account could not be verified.');

        if (!Yii::app()->request->isAjaxRequest)
        {
            switch($user->user_group_id)
            {
                case Student::USER_GROUP_ID:
                    $this->redirect(array('verifyStudents'));
                case Employer::USER_GROUP_ID:
                    $this->redirect(array('verifyEmployers'));
                default:
                    $this->redirect(array('admin'));
            }
        }
    }

    public function actionSendActivation($user_id)
    {
        /** @var $user User */
        /** @var $uv UserVerification */
        $user = User::model()->findByPk($user_id);

        switch($user->user_group_id)
        {
            case Student::USER_GROUP_ID:
                $uv = UserVerification::model()->findByPk($user_id);
                if (!empty($uv))
                $mailed = Emailer::emailStudentActivation($user, $uv->hash);
                break;
            case Employer::USER_GROUP_ID:
                $mailed = Emailer::emailEmployerVerified($user);
                break;
            default:
                throw new CHttpException(404,'Invalid user group.');
        }
        if (isset($mailed) && $mailed)
        Yii::app()->user->setFlash('success', 'Activation Email sent to ' . CHtml::tag('strong', array(), $user->email));
        else
        Yii::app()->user->setFlash('error', 'Error occurred while sending email to ' . CHtml::tag('strong', array(), $user->email));

        $this->redirect(array('admin'));
    }

    public function getEmployerMenuItem()
    {

    $unverifiedNum = User::model()->countByAttributes(array('is_verified'=>'0', 'user_group_id'=>Employer::USER_GROUP_ID));

    $label = 'Verify Employers';

    if ($unverifiedNum > 0)
        $label .= $this->widget('bootstrap.widgets.TbBadge', array(
            'type'=>'important',
            'label'=>$unverifiedNum,
            'htmlOptions' => array('class'=>'pull-right'),
        ), true);

        return array('label'=>$label,
            'url'=>array('verifyEmployers'));
    }

    public function getStudentMenuItem()
    {

        $unverifiedNum = User::model()->countByAttributes(array('is_verified'=>'0', 'user_group_id'=>Student::USER_GROUP_ID));

        $label = 'Verify Students';

        if ($unverifiedNum > 0)
            $label .= $this->widget('bootstrap.widgets.TbBadge', array(
                'type'=>'important',
                'label'=>$unverifiedNum,
                'htmlOptions' => array('class'=>'pull-right'),
            ), true);

        return array('label'=>$label,
            'url'=>array('verifyStudents'));
    }
}
