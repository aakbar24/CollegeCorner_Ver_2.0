<?php
class EmployerFavController extends ProfileRelatedController
{
	/**
	 * Declares class-based actions.
	 */
	public function actions()
	{
		return array(
					
		);
	}

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
				'accessControl', // perform access control
				'postOnly + delete, deleteSelected',
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
				
				array('allow', // actions that only allow employers to perform
						'actions'=>array('index',
								'fav','favSelected',
								'view',
								'delete','deleteSelected',
								),
						'users'=>array('@'),
						'expression'=>'intval($user->user_group_id)===Employer::USER_GROUP_ID' //only allow employer to access
				),
				array('deny',  // deny all users
						'users'=>array('*'),
				),
		);
	}
			
	public function actionFav($stu_job_id){
		if (isset($stu_job_id)) {
			if (StudentJobTitle::model()->exists('stu_job_id=:stu_job_id',array(':stu_job_id'=>$stu_job_id))) {
				$favJobTitle=new FavoriteStudentJobTitle();
				$favJobTitle->stu_job_id=$stu_job_id;
				$favJobTitle->employer_id=Yii::app()->user->id;
				try {
					if ($favJobTitle->save()) {
						$this->renderPartial('//common/_alerts',array('type'=>'success','msg'=>Yii::t('app', 'msg.success.fav_resume')));
					}	
				} catch (CDbException $e) {
					$this->renderPartial('//common/_alerts',array('type'=>'danger','msg'=>Yii::t('app', 'msg.error.fav_resume')));
				}
			}
			else{
				$this->renderPartial('//common/_alerts',array('type'=>'danger','msg'=>Yii::t('app', 'msg.error.resume_not_found')));
			}
		}
	}
	
	public function actionFavSelected(){
		
		if (isset($_POST) && isset($_POST['stu_job_id']) && !empty($_POST['stu_job_id'])) {
			
			$unFavResumes=FavoriteStudentJobTitle::getUnFavResumes($_POST['stu_job_id'],Yii::app()->user->id);
			if (count($unFavResumes)>0) {
				try {
					if (FavoriteStudentJobTitle::saveResumes($unFavResumes,Yii::app()->user->id )) {
						$this->renderPartial('//common/_alerts',array('type'=>'success','msg'=>Yii::t('app', 'msg.success.fav_resumes')));
					}
					echo CHtml::hiddenField('favorited-resumes',implode(',', $unFavResumes));
				} catch (Exception $e) {
					$this->renderPartial('//common/_alerts',array('type'=>'danger','msg'=>Yii::t('app', 'msg.error.fav_resumes')));
				}	
			}
			else{
				$this->renderPartial('//common/_alerts',array('type'=>'warning','msg'=>Yii::t('app', 'msg.alert.no_fav_resumes')));
			}
		}else{
			$this->renderPartial('//common/_alerts',array('type'=>'danger','msg'=>Yii::t('app', 'msg.error.resumes_not_found')));
		}
	}
	
		
	public function actionIndex() {
		$this->layout='/layouts/_empResumeGridView';
		$model=new ViewFavorite('search');
		if (isset($_GET['ajax'])) {
			if(isset($_GET['ViewFavorite']))
				$model->attributes=$_GET['ViewFavorite'];
				
			$this->renderPartial('_viewFavResumes',array('model'=>$model));
		}
		else
		{
			$this->render('viewFavResumes',array('model'=>$model));
		}
	}
	
	public function actionDelete($id) {
		if (isset($_GET['ajax'])) {
			if (isset($id)) {
				$empFavRes=FavoriteStudentJobTitle::model()->findByAttributes(array('stu_job_id'=>$id,'employer_id'=>Yii::app()->user->id));
				if($empFavRes!=null){
					if($empFavRes->delete()){
						$this->renderPartial('//common/_alerts',array('type'=>'success','msg'=>Yii::t('app', 'msg.success.del_fav_resume')));
					}else {
						$this->renderPartial('//common/_alerts',array('type'=>'danger','msg'=>Yii::t('app', 'msg.error.del_fav_resume')));
					}
					return;
				}
			}
			$this->renderPartial('//common/_alerts',array('type'=>'danger','msg'=>Yii::t('app', 'msg.error.resume_not_found')));
		}
	}
	
	public function actionDeleteSelected() {
		if (isset($_GET['ajax'])) {
			if (isset($_POST) && isset($_POST['stu_job_id']) && !empty($_POST['stu_job_id'])) {
				try {
					if(FavoriteStudentJobTitle::deleteResumes($_POST['stu_job_id'], Yii::app()->user->id)){
						$this->renderPartial('//common/_alerts',array('type'=>'success','msg'=>Yii::t('app', 'msg.success.del_fav_resumes')));
					}
				} catch (Exception $e) {
					$this->renderPartial('//common/_alerts',array('type'=>'danger','msg'=>Yii::t('app', 'msg.error.del_fav_resumes')));
				}
				return;
			}
			$this->renderPartial('//common/_alerts',array('type'=>'danger','msg'=>Yii::t('app', 'msg.error.resumes_not_found')));
		}
	}
		
}