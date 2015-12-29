<?php

/**
 * This is the model class for table "v_favorite".
 *
 * The followings are the available columns in table 'v_favorite':
 * @property integer $stu_job_id
 * @property integer $student_id
 * @property string $username
 * @property string $first_name
 * @property string $last_name
 * @property integer $college_id
 * @property integer $program_id
 * @property integer $job_cat_id
 * @property string $job_cat_name
 * @property integer $job_title_id
 * @property string $job_title_name
 * @property string $resume_file
 * @property string $skills
 * @property integer $employer_id
 * @property string $company_name
 * @property integer $expired
 * @property integer $is_student_hired
 */
class ViewFavorite extends DBViewActiveRecord
{
	
	/**
	 * This field is only provided when searching the latest resumes by a specific employer with his id.
	 * It is not a searchable field. Also, it doesn't relate to interviewEmployers.
	 * @var interger
	 */
	public $inte_employer_id;
	
	/**
	 * This field is only provided when searching the resumes by a specific employer with his id.
	 * It is not a searchable field. Also, it doesn't relate to interviewEmployers.
	 * @var interger
	 */
	public $employer_inte_date;
	
	/**
	 * This field is only provided when searching the resumes by a specific employer with his id.
	 * It is not a searchable field. Also, it doesn't relate to interviewEmployers.
	 * <p>
	 * Inidicates if a resume has been in employer's interview list before but deleted already
	 * @var boolean
	 */
	public $employer_inte_active;
	
	public $pageSize;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return ViewFavorite the static model class
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
		return 'v_favorite';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('stu_job_id, student_id, username, first_name, last_name, college_id, program_id, job_cat_name, job_title_id, job_title_name, resume_file, skills, employer_id, company_name', 'required'),
			array('stu_job_id, college_id, program_id, job_cat_id, job_title_id, employer_id, expired', 'numerical', 'integerOnly'=>true),
			array('username, company_name', 'length', 'max'=>50),
			array('first_name, last_name', 'length', 'max'=>20),
			array('job_cat_name', 'length', 'max'=>40),
			array('job_title_name', 'length', 'max'=>45),
			array('resume_file', 'length', 'max'=>100),
			array('skills', 'length', 'max'=>200),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('stu_job_id, username, student_id, collegeName, pageSize, first_name, last_name, college_id, program_id, job_cat_id, job_cat_name, job_title_id, job_title_name, resume_file, skills, employer_id, company_name, expired', 'safe', 'on'=>'search'),
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
			'first_name' => Yii::t('model','viewStudentJobTitle.first_name'),
			'last_name' => Yii::t('model','viewStudentJobTitle.last_name'),
			'college_id' => Yii::t('model','viewStudentJobTitle.college_id'),
			'program_id' => Yii::t('model','viewStudentJobTitle.program_id'),
			'job_cat_id' => Yii::t('model','viewStudentJobTitle.job_cat_id'),
			'job_cat_name' => Yii::t('model','viewStudentJobTitle.job_cat_name'),
			'job_title_id' => Yii::t('model','viewStudentJobTitle.job_title_id'),
			'job_title_name' => Yii::t('model','viewStudentJobTitle.job_title_name'),
			'resume_file' => Yii::t('model','viewStudentJobTitle.resume_file'),
			'skills' => Yii::t('model','viewStudentJobTitle.skills'),
			'employer_id' => Yii::t('model','viewStudentJobTitle.employer_id'),
			'company_name' => Yii::t('model','viewStudentJobTitle.company_name'),
			'expired' => Yii::t('model','viewFavorite.expired'),
		);
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
		$criteria->compare('t.employer_id',$empId);
		$criteria->with=array('college'=>array('joinType'=>'INNER JOIN','select'=>'college_name'));
	
		$criteria->params[':empId']=$empId;
		
		$criteria->join.=' LEFT OUTER JOIN {{interview_student_job_title}} inte ON inte.employer_id=:empId AND inte.stu_job_id=t.stu_job_id ';
						 
		$criteria->select.=',inte.employer_id as inte_employer_id, inte.interview_date as employer_inte_date, inte.active as employer_inte_active ';
							
		
		$limit=$this->pageSize;
		return $this->relatedSearch(
				$criteria,
				array('pagination'=>array('pageSize'=>$limit,'params'=>array('ViewFavorite[pageSize]'=>$limit)))
		);
	}
	
	/**
	 * Compares the interview date to current time
	 */
	public function isInterviewActive(){
		return StudentJobTitleHelper::isInterviewActive($this);
	}
	
	/**
	 * Displays the interview date icon
	 */
	public function getInterviewIcon(){
		return StudentJobTitleHelper::getInterviewIcon($this);
	}
	
	/**
	 * Displays the expired icon
	 */
	public function getExpiredIcon(){
		return StudentJobTitleHelper::getExpiredIcon($this);
	}
	
	public function allowInterview(){
		return StudentJobTitleHelper::allowInterview($this);
	}
	
	/**
	 * Displays the interview date icon
	 */
	public function getStudentHiredIcon(){
		return StudentJobTitleHelper::getStudentHiredIcon($this);
	}
}