<?php
class ProfileController extends Controller
{
	public $layout='//layouts/profile';
	
	/**
	 * Declares class-based actions.
	 */
	public function actions(){
		return array('upload'=>array(
				'class'=>'bootstrap.actions.TbUberUploadAction',
				'uploadPath'=>User::getProfileImageUploadPath(),
				),
				'crop'=>array(
						'class'=>'bootstrap.actions.TbUberCropAction',
						'uploadPath'=>User::getProfileImageUploadPath(),
						'cropWidth'=>140,
					)
				);
	}
	
	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
				'accessControl', // perform access control for CRUD operations
				//				'postOnly + , register',
				array(
						'application.filters.GridViewHandler' //path to GridViewHandler.php class
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
				/* array('allow',  // allow all users to perform 'login', 'forget', and 'register' actions
						'actions'=>array('login','register','forget'),
						'users'=>array('*'),
				), */
				array('allow', // allow authenticated user to perform 'update' and 'logout' actions
						'actions'=>array('index','editAccount','editProfile','view','viewProfile','upload','crop'),
						'users'=>array('@'),
				),
				array('deny',  // deny all users
						'users'=>array('*'),
				),
		);
	}
	
	public function actionIndex()
	{
        $userGroupId=Yii::app()->user->getState('user_group_id');
        if ($userGroupId!==null)
        {
            $userGroupId=intval($userGroupId);
            switch ($userGroupId)
            {
                case Student::USER_GROUP_ID:
                    $this->render('studentIndex');
                    break;

                case Employer::USER_GROUP_ID:
                    $model=Employer::model()->findByPk(Yii::app()->user->id);

                    $company = $model->company_name;

                    $this->render('employerIndex', array('company' => $company));
                    break;

                default:
                    throw new CHttpException(404,'Invalid User group found.');
                    break;
            }
        }
        else
        {
            throw new CHttpException(404,'User group is not found.');
        }
	}
	
	public function actionEditAccount() 
	{
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
	
	public function actionEditProfile()
	{
		$userGroupId=Yii::app()->user->getState('user_group_id');
		if ($userGroupId!==null) 
		{
			$userGroupId=intval($userGroupId);
			$model=null;
			switch ($userGroupId) 
			{
				case Student::USER_GROUP_ID:
					$model=Student::model()->findByPk(Yii::app()->user->id);
					if (isset($_POST['Student'])) {
						$this->_updateProfile($_POST['Student'],$model);
					}
					$this->render('editStudentProfile',array('model'=>$model));
					break;
				
				case Employer::USER_GROUP_ID:
					$model=Employer::model()->findByPk(Yii::app()->user->id);
					if (isset($_POST['Employer'])) {
						$this->_updateProfile($_POST['Employer'],$model);
					}
					$this->render('editEmployerProfile',array('model'=>$model));
					break;
				
				default:
					throw new CHttpException(404,'Invalid User group found.');
				break;
			}
		}
		else
		{
			throw new CHttpException(404,'User group is not found.');
		}
	}
	
	public function actionView()
	{
		$userGroupId=Yii::app()->user->getState('user_group_id');
		if ($userGroupId!==null)
		{
			$userGroupId=intval($userGroupId);
			$model=null;
			switch ($userGroupId)
			{
				case Student::USER_GROUP_ID:
					$model=Student::model()->with(array('user','user.userGroup'))->findByPk(Yii::app()->user->id);
					$this->render('viewStudentProfile',array('model'=>$model));
					break;
		
				case Employer::USER_GROUP_ID:
					$model=Employer::model()->with(array('user','user.userGroup'))->findByPk(Yii::app()->user->id);
					
					$this->render('viewEmployerProfile',array('model'=>$model));
					break;
		
				default:
					throw new CHttpException(404,'Invalid User group found.');
					break;
			}
		}
		else
		{
			throw new CHttpException(404,'User group is not found.');
		}
	}
	
	public function actionViewProfile($id)
	{
		$user=User::model()->findByPk($id);
		
		if ($user!==null)
		{
			$userGroupId=$user->user_group_id;
			$userGroupId=intval($userGroupId);
			$model=null;
			switch ($userGroupId)
			{
				case Student::USER_GROUP_ID:
					$model=Student::model()->findByPk($id);
					$this->renderPartial('viewStudentProfile',array('model'=>$model));
					break;
	
				case Employer::USER_GROUP_ID:
					$model=Employer::model()->findByPk($id);
						
					$this->renderPartial('viewEmployerProfile',array('model'=>$model));
					break;
	
				default:
					throw new CHttpException(404,'Invalid User group found.');
					break;
			}
		}
		else
		{
			throw new CHttpException(404,'User is not found.');
		}
	}
	
	/**
	 * A helper function to handle edit profile action.
	 * @param array $post - the $_POST array of the associated $model type
	 * @param CActiveRecord $model - Profile model object (Either Student or Employer)
	 */
	private function _updateProfile($post=null,$model=null)
	{
		if (isset($post) && isset($model)) {
			$model->attributes=$post;
			if ($model->save()) {
				Yii::app()->user->setFlash('success', Yii::t('app', 'msg.success.update_profile'));
				$this->refresh();
			}
		}
	}
}