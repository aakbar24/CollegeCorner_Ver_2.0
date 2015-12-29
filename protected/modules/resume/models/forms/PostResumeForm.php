<?php
/**
 * The form model to handle resume post action. 
 * @author Wenbin
 *
 */
class PostResumeForm extends CFormModel
{
	
	public $jobType;	public $ecwsCourse;
	/**
	 * The resume file will be related to all job titles submitted.
	 * @var CUploadedFile 
	 */
	public $resumeFile;	public $portfolioFile;
	/**
	 * The skills data will also be saved to all job titles submitted. 
	 * @var string
	 */
	public $skills;
	public $jobCat;
	/**
	 * In save, the each job title will be saved as a new row.
	 * @var array
	 */
	public $jobTitles;
	public $user;
	/**
	 * Counts the active job titles the user has applied so far
	 * @var integer
	 */
	private $_countUserJobs;
	
	public function __construct($userId=null,$scenario='')
	{
		if ($userId!==null) 
		{
			$this->_countUserJobs=StudentJobTitle::model()->countByAttributes(array('user_id'=>$userId,'is_hired'=>0,));
		}
	}
	
	public function getCountUserJobs()
	{
		return $this->_countUserJobs;
	}
	
	public function rules()
	{
		return array(
				array('jobType,ecwsCourse, resumeFile, skills, jobCat, jobTitles','required'),
				array('jobType, ecwsCourse ,jobCat', 'numerical','integerOnly'=>true),
				// consider putting the max file size as constant or app param
				array('resumeFile','file','allowEmpty'=>true, 'safe'=>true, 'maxSize'=>3146666,'types'=>array('txt','doc','docx','rtf', 'pdf')),
				array('portfolioFile','file','allowEmpty'=>true, 'safe'=>true, 'maxSize'=>3146666,'types'=>array('txt','doc','docx','rtf', 'pdf')),
				array('skills','length', 'max'=>255),
			);
	}
	
	public function attributeLabels()
	{
		return array(
				'jobType' => Yii::t('model', 'postResumeForm.jobType'),
				'resumeFile' => Yii::t('model', 'postResumeForm.resumeFile'),				'portfolioFile' => Yii::t('model', 'postResumeForm.portfolioFile'),								'ecwsCourse' => Yii::t('model', 'postResumeForm.ecwsCourse'),
				'skills' => Yii::t('model', 'postResumeForm.skills'),
				'jobCat' => Yii::t('model', 'postResumeForm.jobCat'),
				'jobTitles' => Yii::t('model', 'postResumeForm.jobTitles'),
				
		);
	}
	
	public function save($userId,$cvFileName,$pfFileName)
	{
		if ($userId!==null) 
		{
			$transaction=Yii::app()->db->beginTransaction();
			try 
			{
				foreach ($this->jobTitles as $jobTitle)
				{
					$studentJobTitle=new StudentJobTitle();
					$studentJobTitle->user_id=$userId;
					$studentJobTitle->job_title_id=$jobTitle;
					$studentJobTitle->job_type_id=$this->jobType;
					$studentJobTitle->resume_file=$cvFileName;										//if($pfFileName != NULL)					//{					$studentJobTitle->portfolio_file=$pfFileName;					//}										$studentJobTitle->ECWS_id=$this->ecwsCourse;
					$studentJobTitle->skills=$this->skills;
					$studentJobTitle->date_created=new CDbExpression('NOW()');
					$studentJobTitle->expiry_date=new CDbExpression('DATE(NOW()+INTERVAL 3 MONTH)');
					if (!$studentJobTitle->save()) {
						throw new CException(json_encode($studentJobTitle->errors));
					}
				}
				$transaction->commit();
				return true;
			} 
			catch (Exception $e) 
			{
				$transaction->rollback();
				throw new CException($e->getMessage());
			}
		}
		else
		{
			throw new CException('User not found!');
		}
		
	}
}