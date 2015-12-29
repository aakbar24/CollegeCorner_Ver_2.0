<?php

/**
 * This is the model class for table "v_interview".
 *
 * The followings are the available columns in table 'v_interview':
 * @property integer $stu_job_id
 * @property string $username
 * @property integer $student_id
 * @property string $first_name
 * @property string $last_name
 * @property integer $college_id
 * @property integer $program_id
 * @property integer $job_cat_id
 * @property string $job_cat_name
 * @property integer $job_title_id
 * @property string $job_title_name
 * @property string $resume_file
 * @property string $is_hired
 * @property string $is_current_hired
 * @property string $skills
 * @property string $expiry_date
 * @property string $interview_date
 * @property integer $employer_id
 * @property string $company_name
 * @property integer $active
 * @property integer $is_student_hired
 */
class ViewInterview extends DBViewActiveRecord
{
	public $pageSize;
	
	/**
	 * This field is only provided when searching the latest resumes by a specific employer with his id.
	 * It is not a searchable field. Also, it doesn't relate to favEmployers.
	 * @var interger
	 */
	public $fav_employer_id;
	
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return ViewInterview the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'v_interview';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('stu_job_id, username, student_id, first_name, last_name, college_id, program_id, job_cat_name, job_title_id, job_title_name, resume_file, skills, expiry_date, interview_date, employer_id, company_name', 'required'),
			array('stu_job_id, student_id, college_id, program_id, job_cat_id, job_title_id, employer_id, active', 'numerical', 'integerOnly'=>true),
			array('username, company_name', 'length', 'max'=>50),
			array('first_name, last_name', 'length', 'max'=>20),
			array('job_cat_name', 'length', 'max'=>40),
			array('job_title_name', 'length', 'max'=>45),
			array('resume_file', 'length', 'max'=>100),
			array('is_hired, is_current_hired', 'length', 'max'=>1),
			array('skills', 'length', 'max'=>200),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('stu_job_id, username,active, pageSize, collegeName, student_id, first_name, last_name, college_id, program_id, job_cat_id, job_cat_name, job_title_id, job_title_name, resume_file, is_hired, is_current_hired, skills, expiry_date, interview_date, employer_id, company_name', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
				'college'=>array(self::BELONGS_TO,'College', 'college_id'),
		);
	}
	
	public function afterConstruct(){
		parent::afterConstruct();
		$this->job_cat_id='';
		$this->job_title_id='';
		$this->pageSize=Yii::app()->params['defaultPageLimit'];
	}
	
	public function primaryKey(){
		return array('stu_job_id');
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		//labels use the translation messages, make sure you provide the label messages in proper category file
		//default category is the 'model.php' in the messages folder 
		return array(
			'stu_job_id' => Yii::t('model','viewStudentJobTitle.stu_job_id'),
			'username' => Yii::t('model','viewStudentJobTitle.username'),
			'student_id' => Yii::t('model','viewStudentJobTitle.student_id'),
			'first_name' => Yii::t('model','viewStudentJobTitle.first_name'),
			'last_name' => Yii::t('model','viewStudentJobTitle.last_name'),
			'college_id' => Yii::t('model','viewStudentJobTitle.college_id'),
			'program_id' => Yii::t('model','viewStudentJobTitle.program_id'),
			'job_cat_id' => Yii::t('model','viewStudentJobTitle.job_cat_id'),
			'job_cat_name' => Yii::t('model','viewStudentJobTitle.job_cat_name'),
			'job_title_id' => Yii::t('model','viewStudentJobTitle.job_title_id'),
			'job_title_name' => Yii::t('model','viewStudentJobTitle.job_title_name'),
			'resume_file' => Yii::t('model','viewStudentJobTitle.resume_file'),
			'is_hired' => Yii::t('model','viewStudentJobTitle.is_hired'),
			'is_current_hired' => Yii::t('model','viewStudentJobTitle.is_current_hired'),
			'skills' => Yii::t('model','viewStudentJobTitle.skills'),
			'expiry_date' => Yii::t('model','viewStudentJobTitle.expiry_date'),
			'interview_date' => Yii::t('model','interviewStudentJobTitle.interview_date'),
			'employer_id' => Yii::t('model','viewStudentJobTitle.employer_id'),
			'company_name' => Yii::t('model','viewStudentJobTitle.company_name'),
		);
	}

	public function searchByEmployer($empId){
		$criteria = new CDbCriteria();
		$criteria->compare('student_id',$this->student_id);
		$criteria->compare('stu_job_id',$this->stu_job_id);
		$criteria->compare('t.username',$this->username,true);
		$criteria->compare('t.first_name',$this->first_name,true);
		$criteria->compare('t.last_name',$this->last_name,true);
		$criteria->compare('job_title_id',$this->job_title_id);
		$criteria->compare('job_title_name',$this->job_title_name,true);
		$criteria->compare('job_cat_id',$this->job_cat_id);
		$criteria->compare('job_cat_name',$this->job_cat_name,true);
		$criteria->compare('company_name',$this->company_name,true);
		$criteria->compare('is_hired','0');
		$criteria->compare('active',1);
		$criteria->compare('is_current_hired','0');
		$criteria->compare('t.employer_id',$empId);
		$criteria->compare('interview_date',$this->interview_date,true);
		$criteria->with=array(
				'college'=>array('joinType'=>'INNER JOIN','select'=>'college_name'),
		);
		
		$criteria->addCondition('t.expiry_date > DATE(NOW())');
		
		$criteria->params[':empId']=$empId;
	
		$criteria->join.=' LEFT OUTER JOIN {{favorite_student_job_title}} fav ON fav.employer_id=:empId AND fav.stu_job_id=t.stu_job_id ';
		$criteria->select.=',fav.employer_id as fav_employer_id';
		
		$sort=array(
				'defaultOrder'=>'t.interview_date',
		);
	
		$limit=$this->pageSize;
		return $this->relatedSearch(
				$criteria,
				array('sort'=>$sort,'pagination'=>array('pageSize'=>$limit,'params'=>array('ViewInterview[pageSize]'=>$limit)))
		);
	}
	
	/**
	 * Compares the interview date to current time
	 */
	public function isInterviewActive(){
		$now=time();
		$interviewDate=strtotime($this->interview_date);
		return $interviewDate>$now;
	}
	
	function behaviors() {
		return array(
				'relatedsearch'=>array(
						'class'=>'RelatedSearchBehavior',
						'relations'=>array(
								// Field where search value is different($this->deviceid)
								'collegeName'=>array(
										'field'=>'college.college_name',
										'searchvalue'=>'college_id',
										'partialMatch'=>false,
								),
	
								// Next line describes a field we do not search,
								// but we define it here for convienience
								//'mylocalreference'=>'field.very.far.away.in.the.relation.tree',
						),
				),
		);
	}
	
	public function allowChangeInterview(){
		return $this->is_student_hired==0;
	}
	
	/**
	 * Displays the interview date icon
	 */
	public function getStudentHiredIcon(){
		return StudentJobTitleHelper::getStudentHiredIcon($this);
	}
	
	public function getFavIcon(){
		return StudentJobTitleHelper::getFavIcon($this);
	}
	
	public function searchByStudent($stuId){
		$criteria = new CDbCriteria();
		$criteria->compare('student_id',$stuId);
		$criteria->compare('stu_job_id',$this->stu_job_id);
		$criteria->compare('job_title_id',$this->job_title_id);
		$criteria->compare('job_title_name',$this->job_title_name,true);
		$criteria->compare('job_cat_id',$this->job_cat_id);
		$criteria->compare('job_cat_name',$this->job_cat_name,true);
		$criteria->compare('company_name',$this->company_name,true);
		$criteria->compare('is_hired','0');
		$criteria->compare('active',1);
		$criteria->compare('is_current_hired','0');
		$criteria->compare('interview_date',$this->interview_date,true);
		
		$criteria->addCondition('interview_date >DATE(NOW())');
		
		$sort=array(
				'defaultOrder'=>'t.interview_date',
		);
		
		$limit=$this->pageSize;
		return $this->relatedSearch(
				$criteria,
				array('sort'=>$sort,'pagination'=>array('pageSize'=>$limit,'params'=>array('ViewInterview[pageSize]'=>$limit)))
		);
	}
}