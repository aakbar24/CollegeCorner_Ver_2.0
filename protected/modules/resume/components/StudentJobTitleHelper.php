<?php
class StudentJobTitleHelper{
	
	private function __construct(){}
	
	/**
	 * Displays the favorite icon
	 */
	public static function getFavIcon($model){
		return (isset($model->fav_employer_id)?" <i class=\"icon-star fav-highlight\"></i> ":"");
	}
	
	/**
	 * Compares the interview date to current time
	 */
	public static function isInterviewActive($model){
		if(!isset($model->employer_inte_date)) return true;
		$now=time();
		$interviewDate=strtotime($model->employer_inte_date);
		return $interviewDate>$now;
	}
	
	/**
	 * Displays the interview date icon
	 */
	public static function getInterviewIcon($model){
		$isInterviewPassed=!self::isInterviewActive($model);
		$isInterviewInactive=(isset($model->employer_inte_active)&&((intval($model->employer_inte_active)===0)));
		return (isset($model->inte_employer_id)?" <i class=\"icon-calendar".
				($isInterviewInactive||$isInterviewPassed?"-empty":"")."\" rel=\"tooltip\" title=\"Interview Date: ".$model->employer_inte_date.($isInterviewPassed?" (Date already passed)":($isInterviewInactive?" (Cancelled)":""))."\"></i> ":"");
	}
	
	/**
	 * Indicates whether the current job title allows to add to interview list
	 */
	public static function allowInterview($model){
		return isset($model->is_student_hired)&&($model->is_student_hired==0)&&!isset($model->inte_employer_id)&&(!$model->expired);
	}
	
	/**
	 * Displays the interview date icon
	 */
	public static function getStudentHiredIcon($model){
		if (!isset($model->is_student_hired))return null;
		
		$isHired=$model->is_student_hired==1;
		return ($isHired?" <i class=\"icon-flag\" rel=\"tooltip\" title=\"Student is hired by an employer. Interview is not available.\"></i> ":"");
	}
	
	/**
	 * Displays the expired icon
	 */
	public static function getExpiredIcon($model){
		return (isset($model->expired)&&($model->expired)?" <i class=\"icon-warning-sign \" rel=\"tooltip\" title=\"Expired\"></i> ":"");
	}
	
	public static function generateResumeFileUrl($model)
	{		
		if (isset($model->resume_file)&&$model->resume_file!==null)
		{ 		
			return Yii::app()->createAbsoluteUrl('resume/file/download',array('name'=>$model->resume_file));
		}
		return null;
	}
	public static function generatePortfolioFileUrl($model)	{		if (isset($model->portfolio_file)&&$model->portfolio_file!==null)		{			if($model->portfolio_file!=="" )			{			return Yii::app()->createAbsoluteUrl('resume/file/download',array('name'=>$model->portfolio_file));			}			//else			//return null;		}		//else		//	return null;		return null;	}		public static function generatePortfolioFileEmployerUrl($model)	{		if (isset($model->portfolio_file)&&$model->portfolio_file!==null)		{			if($model->portfolio_file!=="" )			{			return Yii::app()->createAbsoluteUrl('resume/file/downloadPortfolio',array('name'=>$model->portfolio_file));			}			//else			//return null;		}		//else		//	return null;		return null;	}
	public static function generateResumeFileEmployerUrl($model)
	{
		if (isset($model->resume_file)&& $model->resume_file!==null)
		{
			return Yii::app()->createAbsoluteUrl('resume/file/downloadResume',array('name'=>$model->resume_file));
		}
		return null;
	}
	
}