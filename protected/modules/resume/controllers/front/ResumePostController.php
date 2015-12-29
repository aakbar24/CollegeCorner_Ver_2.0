<?php
class ResumePostController extends ProfileRelatedController
{

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
				'accessControl', // perform access control
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
				array('allow', //  actions that allow authenticated user to perform  
						'actions'=>array('view','ajaxJobTitles'),
						'users'=>array('@'),
				),
				array('allow', // actions that only allow students to perform
						'actions'=>array('index','post','view','viewCat','edit','deleteJob','ajaxJobTitles'),
						'users'=>array('@'),
						'expression'=>'intval($user->user_group_id)===Student::USER_GROUP_ID' //only allow student to access
				),
				array('deny',  // deny all users
						'users'=>array('*'),
				),
		);
	}
	
	public function actionIndex()
	{
		$isCurrentHired=StudentJobTitle::isCurrentHired(Yii::app()->user->id);
		$data=new ViewStudentJobTitle('search');
		$data->student_id=Yii::app()->user->id;
		$data=$data->searchLatestJobTitles();
		//$data=Student::model()->findByPk(Yii::app()->user->id)->searchLatestJobTitles();
		$model=new JobTitle('search');
		
		if (isset($_GET['ajax'])) {
			if(isset($_GET['JobTitle']))
				$model->attributes=$_GET['JobTitle'];
			$this->renderPartial('gridviews/_index',array('model'=>$model,'data'=>$data));
		}
		else 
		{
			$this->render('index',array('model'=>$model,'data'=>$data));
		}
		
	}
	
	public function actionPost() 
	{
		$model=new PostResumeForm(Yii::app()->user->id);
		
		//check max job post
		if ($model->getCountUserJobs()<Yii::app()->params['maxResumeJobTitles']) 
		{
			if (isset($_POST['PostResumeForm'])) {
				$model->attributes=$_POST['PostResumeForm'];
				$model->resumeFile = CUploadedFile::getInstance($model, 'resumeFile');				$model->portfolioFile = CUploadedFile::getInstance($model, 'portfolioFile');
					
				if ($model->validate()) 
				{
					//checks the number of job titles submitted are within the limit boundry
					if((count($model->jobTitles)+$model->getCountUserJobs())>Yii::app()->params['maxResumeJobTitles'])
					{
						Yii::app()->user->setFlash('warning', sprintf(Yii::t('app', 'msg.warning.max_job_titles_exceed'),Yii::app()->params['maxResumeJobTitles']));
						$this->redirect(Yii::app()->createAbsoluteUrl($this->getModule()->returnUrl));
						Yii::app()->end();
						return;
					}
					$extension=FileHelper::getExtension($model->resumeFile->name);					if(!empty($model->portfolioFile->name))					{					$extension_PortFolio=FileHelper::getExtension($model->portfolioFile->name);					}					else 					$extension_PortFolio = "";
					//saved file name in the following pattern
					// {user_id}cv{time_stamp_string}.{extension}
					$fileName=Yii::app()->user->id.'cv'.Yii::app()->dateFormatter->format('yyyy-MM-dd_H-mm-ss', time()).'.'.$extension;															if(!empty($extension_PortFolio))					{					$fileName_PortFolio=Yii::app()->user->id.'pf'.Yii::app()->dateFormatter->format('yyyy-MM-dd_H-mm-ss', time()).'.'.$extension_PortFolio;					}					else 					$fileName_PortFolio = "";
			
					if ($model->save(Yii::app()->user->id,$fileName,$fileName_PortFolio)) 
					{							//if(!empty($fileName_PortFolio))							//{
						$userFilePath=FileHelper::getFilePath(Yii::getPathOfAlias('site.files').'/resumes/'.Yii::app()->user->id.'/');
						$model->resumeFile->saveAs($userFilePath.$fileName);												if(!empty($fileName_PortFolio))							{						$model->portfolioFile->saveAs($userFilePath.$fileName_PortFolio);						}
						Yii::app()->user->setFlash('success',Yii::t('app', 'msg.success.post_resume'));						//}
					}
					//checks the number of job titles submitted are within the limit boundry
					if((count($model->jobTitles)+$model->getCountUserJobs())>Yii::app()->params['maxResumeJobTitles'])
					{
						$this->refresh(true);
					}
					else 
					{
						$this->redirect($this->createAbsoluteUrl('index'));
					}
				}
			}
			$this->render('post', array('model'=>$model));
		}
		else
		{
			Yii::app()->user->setFlash('warning', sprintf(Yii::t('app', 'msg.warning.max_job_titles_exceed'),Yii::app()->params['maxResumeJobTitles']));
			$this->redirect(Yii::app()->createAbsoluteUrl($this->getModule()->returnUrl));
		}
		
	}
	
	public function actionDeleteJob($stuJobID)
	{
		if ($stuJobID!==null)
		{
			$jobTitleModel=StudentJobTitle::model()->with('jobTitle')->findByAttributes(array('stu_job_id'=>$stuJobID,'user_id'=>Yii::app()->user->id));
			if ($jobTitleModel!=null) 
			{
				try {
					if ($jobTitleModel->delete())
					{
						Yii::app()->user->setFlash('success', sprintf(Yii::t('app', 'msg.success.delete_job_title'),$jobTitleModel->jobTitle->job_title_name));
						$this->redirect($this->createUrl('viewCat',array('jobCat'=>$jobTitleModel->jobTitle->job_cat_id)),true);
					}
					else
					{
						throw new CHttpException(404,"Student Job Title {$stuJobID} cannot be deleted.");
					}	
				} catch (Exception $e) {
					throw new CHttpException(404,"Student Job Title {$stuJobID} cannot be deleted.");
				}
			}
			else
			{
				throw new CHttpException(404,"Student Job Title {$stuJobID} is not found.");
			}
				
		}
		else
		{
			throw new CHttpException(404,"Student Job Title is not found.");
		}
	}

	public function actionViewCat($jobCat)
	{
		if ($jobCat!==null)
		{
			$jobCatModel=JobCat::model()->findByPk($jobCat);
			if ($jobCatModel!=null) {
				$data=new ViewStudentJobTitle('search');//Student::model()->findByPk(Yii::app()->user->id)->studentJobTitles;//searchStudentJobsByCat($jobCat);
				$data=$data->searchStuJobTitlesByJobCat(Yii::app()->user->id,$jobCat);
				$this->render('viewCat',array('data'=>$data,'jobCat'=>$jobCatModel));
			}
			else
			{
				throw new CHttpException(404,"Job Category {$jobCat} is not found.");
			}
			
		}
		else
		{
			throw new CHttpException(404,"Job Category is not found.");
		}
	}
	
	
	public function actionAjaxJobTitles()
	{
		if (isset($_POST['jobCat'])) 
		{
			$titles=CHtml::listData(JobTitle::getTitlesByCategory($_POST['jobCat'],Yii::app()->user->id),'job_title_id','job_title_name');
			
			if(empty($titles))
			{
				echo CHtml::tag('label',array('class'=>'checkbox'),Yii::t('model','postResumeForm.jobTitles_empty'),true);
			}
			else 
			{
				$model=new PostResumeForm();
				echo CHtml::activeCheckBoxList($model, 'jobTitles', $titles,array('container'=>'', 'separator'=>'', 'template'=>'<label class="checkbox">{input} {label}</label>'));
			}
		}
		
	}
}