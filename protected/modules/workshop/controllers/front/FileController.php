<?php
class FileController extends CController
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
				array('allow', 
						'actions'=>array('download'),
						'users'=>array('*'),
				),
				array('deny',  // deny all users
						'users'=>array('*'),
				),
		);
	}

    public function actionDownload($name, $id)
    {
        if ($name!==null) {
            $userFilePath=Yii::getPathOfAlias('site.files').'/workshops/' . $id;
            $userFilePath.="/". $name;
            if(!FileHelper::outputFile($name,$userFilePath))
            {
                throw new CHttpException(404,'File not found');
            }
        }
    }
	
	/*public function actionDownloadResume($name)
	{
		if (isset($_POST)) {
			$student_id=$_POST['student_id'];
			$stu_job_id=$_POST['stu_job_id'];
			$first_name=$_POST['first_name'];
			$last_name=$_POST['last_name'];
			$ext=CFileHelper::getExtension($name);
			$downloadName=$first_name.$last_name.'_cv_jobtitle_'.$stu_job_id.'.'.$ext;
			if ($name!==null) {
				$userFilePath=Yii::getPathOfAlias('site.files').'/resumes/'.$student_id;
				$userFilePath.='/'.$name;
				if(!FileHelper::outputFile($downloadName,$userFilePath))
				{
					throw new CHttpException(404,'File not found');
				}
			}	
		}else {
			throw new CHttpException(404,"Unable to find the file $name");
		}
		
	}
	
	public function actionDownloadResumeZip()
	{
		if (isset($_POST) && isset($_POST['stu_job_id']) && !empty($_POST['stu_job_id'])) {
			
			$criteria=new CDbCriteria();
			$criteria->addInCondition('stu_job_id', $_POST['stu_job_id']);
			$criteria->select='stu_job_id,student_id,stu_job_id,first_name,last_name,resume_file';
			$selectedJobs=ViewStudentJobTitle::model()->findAll($criteria);
			if ($selectedJobs!=null) {
				$tmpZipFile=tempnam(sys_get_temp_dir(),'zip');//FileHelper::getFilePath(Yii::getPathOfAlias('site.files').'/resumes/temp/zip/',true);
				
				$zip=new ZipArchive();
				if($zip->open($tmpZipFile,ZipArchive::OVERWRITE)===true){
					foreach ($selectedJobs as $key=>$job){
							
							
						$student_id=$job['student_id'];
						$stu_job_id=$job['stu_job_id'];
						$first_name=$job['first_name'];
						$last_name=$job['last_name'];
						$name=$job['resume_file'];
						$ext=CFileHelper::getExtension($name);
						$userFilezipName=$first_name.$last_name.'_cv_jobtitle_'.$stu_job_id.'.'.$ext;
						if ($name!==null) {
							$userFilePath=Yii::getPathOfAlias('site.files').'/resumes/'.$student_id;
							$userFilePath.='/'.$name;
							if(file_exists($userFilePath))
							{
								$zip->addFile($userFilePath,$userFilezipName);
							}
						}
							
					}
					if($zip->close()){
						if(!FileHelper::outputFile('resumesZip'.Randomness::randomString().'.zip', $tmpZipFile))
						{
							throw new CHttpException(404,'Download zip failed');
						}
					}
				}
								
			}
			die();
		}else {
			throw new CHttpException(400,"Unable to find the selected files");
		}
	
	}*/
}