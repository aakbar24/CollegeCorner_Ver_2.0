<?php

/**
 * This is the model class for table "v_student_job_title".
 *
 * The followings are the available columns in table 'v_student_job_title':
 * @property integer $stu_job_id
 * @property integer $student_id
 * @property string $username
 * @property string $first_name
 * @property string $last_name
 * @property integer $job_title_id
 * @property string $job_title_name
 * @property integer $job_type_id
 * @property string $job_type_name
 * @property integer $job_cat_id
 * @property string $job_cat_name
 * @property string $resume_file
 * @property string $skills
 * @property string $expiry_date
 * @property integer $employer_id
 * @property string $company_name
 * @property string $is_hired
 * @property string $is_current_hired
 * @property string $date_hired
 * @property string $date_created
 * @property string $date_updated
 * @property integer $fav_employer_id
 * 
 * @property ViewStudent student
 */
class ViewStudentJobTitle extends DBViewActiveRecord
{
	/**
	 * Flag for advanced search options
	 * @var boolean
	 */
	public $advanced=0;
	
	public $pageSize;
	
	/**
	 * This field is only provided when searching the latest resumes by a specific employer with his id.
	 * It is not a searchable field. Also, it doesn't relate to favEmployers.
	 * @var interger
	 */
	public $fav_employer_id;
	
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
	
	
	public $expired;
	
	public $is_student_hired;
	
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return ViewStudentJobTitle the static model class
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
		return 'v_student_job_title';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			//array('stu_job_id, student_id, username, first_name, last_name, job_title_id, job_title_name, job_type_id, job_type_name, job_cat_name, resume_file, skills, expiry_date', 'required'),
			array('stu_job_id, student_id, job_title_id, job_type_id, job_cat_id, employer_id', 'numerical', 'integerOnly'=>true),
			array('username, company_name', 'length', 'max'=>50),
			array('first_name, last_name, job_type_name', 'length', 'max'=>20),
			array('job_title_name', 'length', 'max'=>45),
			array('job_cat_name', 'length', 'max'=>40),
			array('resume_file', 'length', 'max'=>100),
			array('portfolio_file', 'length', 'max'=>100),
			array('skills', 'length', 'max'=>200),
			array('is_hired, is_current_hired, advanced', 'length', 'max'=>1),
			array('date_hired, date_created, date_updated', 'safe'),
			array('advanced', 'boolean','falseValue'=>0,'trueValue'=>1),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('stu_job_id, ECWS_id,advanced, expired, interviewDate,employer_inte_date, pageSize, student_id,collegeName,program,college_id, username, first_name, last_name, job_title_id, job_title_name, job_type_id, job_type_name, job_cat_id, job_cat_name, skills, expiry_date, employer_id, company_name, is_hired, is_current_hired, date_hired, date_created, date_updated', 'safe', 'on'=>'search'),
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
				'student'=>array(self::BELONGS_TO,'Student', 'student_id'),
				'college'=>array(self::BELONGS_TO,'College', 'college_id'),
				'favEmployers'=>array(self::HAS_MANY,'FavoriteStudentJobTitle', 'stu_job_id'),
				'interviewEmployers'=>array(self::HAS_MANY,'InterviewStudentJobTitle', 'stu_job_id'),
		);
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
			'student_id' => Yii::t('model','viewStudentJobTitle.student_id'),
			'username' => Yii::t('model','viewStudentJobTitle.username'),
			'first_name' => Yii::t('model','viewStudentJobTitle.first_name'),
			'last_name' => Yii::t('model','viewStudentJobTitle.last_name'),
			'job_title_id' => Yii::t('model','viewStudentJobTitle.job_title_id'),
			'job_title_name' => Yii::t('model','viewStudentJobTitle.job_title_name'),
			'job_type_id' => Yii::t('model','viewStudentJobTitle.job_type_id'),
			'job_type_name' => Yii::t('model','viewStudentJobTitle.job_type_name'),
			'job_cat_id' => Yii::t('model','viewStudentJobTitle.job_cat_id'),
			'job_cat_name' => Yii::t('model','viewStudentJobTitle.job_cat_name'),
			'resume_file' => Yii::t('model','viewStudentJobTitle.resume_file'),
			'portfolio_file' => Yii::t('model','viewStudentJobTitle.portfolio_file'),
			'skills' => Yii::t('model','viewStudentJobTitle.skills'),
			'expiry_date' => Yii::t('model','viewStudentJobTitle.expiry_date'),
			'employer_id' => Yii::t('model','viewStudentJobTitle.employer_id'),
			'company_name' => Yii::t('model','viewStudentJobTitle.company_name'),
			'is_hired' => Yii::t('model','viewStudentJobTitle.is_hired'),
			'is_current_hired' => Yii::t('model','viewStudentJobTitle.is_current_hired'),
			'date_hired' => Yii::t('model','viewStudentJobTitle.date_hired'),
			'date_created' => Yii::t('model','viewStudentJobTitle.date_created'),
			'date_updated' => Yii::t('model','viewStudentJobTitle.date_updated'),
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
		$criteria->compare('student_id',$this->student_id);
		$criteria->compare('username',$this->username,true);
		$criteria->compare('first_name',$this->first_name,true);
		$criteria->compare('last_name',$this->last_name,true);
		$criteria->compare('job_title_id',$this->job_title_id);
		$criteria->compare('job_title_name',$this->job_title_name,true);
		$criteria->compare('job_type_id',$this->job_type_id);
		$criteria->compare('job_type_name',$this->job_type_name,true);
		$criteria->compare('job_cat_id',$this->job_cat_id);
		$criteria->compare('job_cat_name',$this->job_cat_name,true);
		$criteria->compare('skills',$this->skills,true);
		$criteria->compare('expiry_date',$this->expiry_date,true);
		$criteria->compare('employer_id',$this->employer_id);
		$criteria->compare('company_name',$this->company_name,true);
		$criteria->compare('is_hired',$this->is_hired);
		$criteria->compare('is_current_hired',$this->is_current_hired);
		$criteria->compare('date_hired',$this->date_hired,true);
		$criteria->compare('date_created',$this->date_created,true);
		$criteria->compare('date_updated',$this->date_updated,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	public function generateResumeFileUrl()
	{
		return StudentJobTitleHelper::generateResumeFileUrl($this);
	}
	
	public function generatePortfolioFileUrl()

	{

		return StudentJobTitleHelper::generatePortfolioFileUrl($this);
		//return "www.fss.com";

	}
	
	public function generateResumeFileEmployerUrl()
	{
		return StudentJobTitleHelper::generateResumeFileEmployerUrl($this);
	}
	
	public function generatePortfolioFileEmployerUrl()

	{

		return StudentJobTitleHelper::generatePortfolioFileEmployerUrl($this);

	}
	
	public function primaryKey(){
		return array('stu_job_id');
	}
	
	public function afterConstruct(){
		parent::afterConstruct();
		$this->is_hired='';
		$this->is_current_hired='';
		$this->date_created='';
		$this->date_hired='';
		$this->date_updated='';
		$this->expiry_date='';
		$this->job_cat_id='';
		$this->job_title_id='';
		$this->job_type_id='';
		$this->pageSize=Yii::app()->params['defaultPageLimit'];
	}
	
	/**
	 * Searches the last job title posted and in its job category.
	 * @return CArrayDataProvider - the results in an array data provider
	 */
	public function searchLatestJobTitles()
	{
		$viewName=$this->tableName();
		$dbc=Yii::app()->db->createCommand();
		$dbc->selectDistinct('j.student_id,j.job_cat_id,j.job_cat_name, c.job_count, c.last_post')->
		from($viewName.' j')->
		join(
				'(select student_id, job_cat_id, count(*) as job_count, max(date_created) as last_post  
					from v_student_job_title 
					where is_hired="0" 
					and is_current_hired="0" 
					and expiry_date >DATE(NOW())
					group by job_cat_id, student_id) c ',
				'j.student_id=c.student_id and c.job_cat_id=j.job_cat_id'
		)->
		where('j.student_id=:student_id',array(':student_id'=>$this->student_id));
		
		$dbc->prepare();
		$rawData=$dbc->queryAll(true);
		
		return new CArrayDataProvider($rawData,
				array(
						
						'keyField'=>'job_cat_id',
						
						'id'=>'job_cat_id',
						'sort'=>array(
								'attributes'=>array(
										'job_cat_name',
										'job_count',
										'last_post',
										)
								
								),
						));
	}
	
	/**
	 * Searches the latest job titles for Employer corner.
	 * @return CActiveDataProvider - the results in an array data provider
	 */
	public function searchLatestStuJobResumesWithEmployer($empId)
	{
		//only create the data provider if we have the employer id
		if (isset($empId)) {
			$criteria=new CDbCriteria;
			$criteria->compare('student_id',$this->student_id);
			$criteria->compare('stu_job_id',$this->stu_job_id);
			$criteria->compare('t.username',$this->username,true);
			$criteria->compare('t.first_name',$this->first_name,true);
			$criteria->compare('t.last_name',$this->last_name,true);
			$criteria->compare('job_title_id',$this->job_title_id);
			$criteria->compare('job_title_name',$this->job_title_name,true);
			$criteria->compare('job_type_id',$this->job_type_id);
			$criteria->compare('job_type_name',$this->job_type_name,true);
			
				$criteria->compare('ECWS_id',$this->ECWS_id);

			$criteria->compare('ECWS_name',$this->ECWS_name,true);
			$criteria->compare('job_cat_id',$this->job_cat_id);
			$criteria->compare('job_cat_name',$this->job_cat_name,true);
			//$criteria->compare('skills',$this->skills,true);
			$criteria->compare('employer_id',$this->employer_id);
			$criteria->compare('company_name',$this->company_name,true);
			$criteria->compare('is_hired','0');
			$criteria->compare('is_current_hired','0');
			$criteria->compare('date_hired',$this->date_hired,true);
			$criteria->compare('t.date_created',$this->date_created,true);
			$criteria->compare('t.date_updated',$this->date_updated,true);
			$criteria->with=array('college'=>array('joinType'=>'INNER JOIN','select'=>'college_name'));
			//pass the supplied employer_id, the following join will provide us the information
			//whether each row is favorited by this employer already  
			$criteria=self::_appendEmpExtraConditions($criteria);
			$criteria->params[':empId']=$empId;
			
			//append the extra data to select columns
			
			$criteria->addCondition('t.expiry_date > DATE(NOW())');
			
			//filters out all the resumes that belong to students that are currently hired 
			$criteria->addCondition("student_id NOT IN (
					SELECT DISTINCT user_id
					FROM tbl_student_job_title
					WHERE is_current_hired =  '1')");
			$criteria=$this->_appendSkillsSearchConditions($criteria);	
			
			$sort=array(
					'defaultOrder'=>'t.date_updated DESC t.date_created DESC',
			);
			$limit=$this->pageSize;
			return $this->relatedSearch(
					$criteria,
					array('sort'=>$sort,'pagination'=>array('pageSize'=>$limit,'params'=>array('ViewStudentJobTitle[pageSize]'=>$limit)))
			);
		}
				
	}
	
	private function _appendSkillsSearchConditions($criteria){
		if ($criteria!=null ) {
			//the follow will append extra search conditions when skills are being searched
			$skills=$this->getSkillsArray();
			if(isset($skills) && !empty($skills)){
				$len=count($skills);
				if ($len>0) {
					$criteria->condition.= " AND ( skills LIKE :skill0 ";
					$criteria->params[':skill0']="%{$skills[0]}%";
					if ($len>1) {
						for ($i = 1; $i < $len; $i++) {
							$criteria->condition.= " OR skills LIKE :skill{$i} ";
							$criteria->params[":skill{$i}"]="%{$skills[$i]}%";
						}
					}
					$criteria->condition.=" )";
				}
			}
		}
		return $criteria;
	}
	
	/**
	 * Get the student job title with the regards of the employer by looking at FavStudentJobTitle and InterviewStudentJobTitle. 
	 * @param integer $stu_job_id
	 * @param integer $empId -
	 */
	public static function getStuResumeWithEmployer($stu_job_id,$empId){
		$criteria =new CDbCriteria();
		$criteria->select='t.*, (CASE WHEN expiry_date<NOW() THEN 1 else 0 END) AS expired, (CASE WHEN st.user_id IS NULL THEN 0 ELSE 1 END) AS is_student_hired';
		$criteria->addCondition('t.stu_job_id=:stu_job_id');
		$criteria->join='LEFT JOIN (SELECT DISTINCT user_id FROM {{student_job_title}} WHERE is_current_hired="1" )st ON st.user_id=t.student_id';
		$criteria=self::_appendEmpExtraConditions($criteria);
		$criteria->params=array(':empId'=>$empId,':stu_job_id'=>$stu_job_id);
		return self::model()->find($criteria);
	}
	
	/**
	 * Returns the skill set in array.
	 * @return array - the skill set in array format
	 */
	public function getSkillsArray(){
		
		if ( $this->skills!=null || $this->skills!='') {
			return explode(',', $this->skills);
		}
		else {
			return array();
		}
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
								
								//'interviewDate'=>'interviewEmployers.interview_date',
								// Next line describes a field we do not search,
								// but we define it here for convienience
								//'mylocalreference'=>'field.very.far.away.in.the.relation.tree',
						),
				),
		);
	}
	
	/**
	 * Append extra employer related conditions
	 * @param CDbCriteria $criteria
	 */
	private static function _appendEmpExtraConditions($criteria){
		if ($criteria!=NULL) {
							
				$criteria->join.=' LEFT OUTER JOIN {{favorite_student_job_title}} fav ON fav.employer_id=:empId AND fav.stu_job_id=t.stu_job_id '.
						'LEFT OUTER JOIN {{interview_student_job_title}} inte ON inte.employer_id=:empId AND inte.stu_job_id=t.stu_job_id';
				
				$criteria->select.=',fav.employer_id as fav_employer_id, inte.employer_id as inte_employer_id, inte.interview_date as employer_inte_date, inte.active as employer_inte_active';			
		}
		return $criteria;
		
	}
	
	/**
	 * Displays the favorite icon
	 */
	public function getFavIcon(){
		return StudentJobTitleHelper::getFavIcon($this);
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
	 * Indicates whether the current job title allows to add to interview list
	 */
	public function allowInterview(){
		return StudentJobTitleHelper::allowInterview($this);
	}
	
	/**
	 * Displays the interview date icon
	 */
	public function getStudentHiredIcon(){
		return StudentJobTitleHelper::getStudentHiredIcon($this);
	}
	
	/**
	 * Search current hired job titles by the provided employer id
	 * @param integer $empId
	 * @return CActiveDataProvider -the search results in active data provider format
	 */
	public function searchCurrentHiredByEmployer($empId){
		if (isset($empId)) {
			$criteria=new CDbCriteria;
			$criteria->compare('stu_job_id',$this->stu_job_id);
			$criteria->compare('t.username',$this->username,true);
			$criteria->compare('t.first_name',$this->first_name,true);
			$criteria->compare('t.last_name',$this->last_name,true);
			$criteria->compare('job_title_id',$this->job_title_id);
			$criteria->compare('job_title_name',$this->job_title_name,true);
			$criteria->compare('job_type_id',$this->job_type_id);
			$criteria->compare('job_type_name',$this->job_type_name,true);
			$criteria->compare('job_cat_id',$this->job_cat_id);
			$criteria->compare('job_cat_name',$this->job_cat_name,true);
			//$criteria->compare('skills',$this->skills,true);
			$criteria->compare('t.employer_id',$empId);
			$criteria->compare('is_hired','1');
			$criteria->compare('is_current_hired','1');
			$criteria->compare('date_hired',$this->date_hired,true);
			$criteria->compare('t.date_created',$this->date_created,true);
			$criteria->compare('t.date_updated',$this->date_updated,true);
			$criteria->with=array('college'=>array('joinType'=>'INNER JOIN','select'=>'college_name'));
			//pass the supplied employer_id, the following join will provide us the information
			//whether each row is favorited and/or added to interview list by this employer already  
			$criteria=self::_appendEmpExtraConditions($criteria);
			$criteria->params[':empId']=$empId;
			$sort=array(
					'defaultOrder'=>'t.date_hired DESC',
			);
			$limit=$this->pageSize;
			return $this->relatedSearch(
					$criteria,
					array('sort'=>$sort,'pagination'=>array('pageSize'=>$limit,'params'=>array('ViewStudentJobTitle[pageSize]'=>$limit)))
			);
		}
	}
	
	public function searchHiredArchiveByEmployer($empId){
		if (isset($empId)) {
			$criteria=new CDbCriteria;
			$criteria->compare('stu_job_id',$this->stu_job_id);
			$criteria->compare('t.username',$this->username,true);
			$criteria->compare('t.first_name',$this->first_name,true);
			$criteria->compare('t.last_name',$this->last_name,true);
			$criteria->compare('job_title_id',$this->job_title_id);
			$criteria->compare('job_title_name',$this->job_title_name,true);
			$criteria->compare('job_type_id',$this->job_type_id);
			$criteria->compare('job_type_name',$this->job_type_name,true);
			$criteria->compare('job_cat_id',$this->job_cat_id);
			$criteria->compare('job_cat_name',$this->job_cat_name,true);
			//$criteria->compare('skills',$this->skills,true);
			$criteria->compare('t.employer_id',$empId);
			$criteria->compare('is_hired','1');
			$criteria->compare('is_current_hired','0');
			$criteria->compare('date_hired',$this->date_hired,true);
			$criteria->compare('t.date_created',$this->date_created,true);
			$criteria->compare('t.date_updated',$this->date_updated,true);
			$criteria->with=array('college'=>array('joinType'=>'INNER JOIN','select'=>'college_name'));
			//pass the supplied employer_id, the following join will provide us the information
			//whether each row is favorited by this employer already
			$criteria=self::_appendEmpExtraConditions($criteria);
			$criteria->params[':empId']=$empId;
			$sort=array(
					'defaultOrder'=>'t.date_hired DESC',
			);
			$limit=$this->pageSize;
			return $this->relatedSearch(
					$criteria,
					array('sort'=>$sort,'pagination'=>array('pageSize'=>$limit,'params'=>array('ViewStudentJobTitle[pageSize]'=>$limit)))
			);
		}
	}
	
	/**
	 * Searches student job titles by student id and category id
	 * @return CActiveDataProvider
	 */
	public function searchStuJobTitlesByJobCat($stuId,$catId){
		if (!isset($stuId) || !isset($catId)) {
			throw new CException("Student Id and Job Category Id are required");
		}
		$criteria=new CDbCriteria;
		$criteria->compare('student_id',$stuId);
		$criteria->compare('job_cat_id',$catId);
		$criteria->compare('is_hired','0');
		$criteria->compare('is_current_hired','0');
		$criteria->addCondition('t.expiry_date > DATE(NOW())');
		$criteria->with=array('interviewEmployers'=>array('select'=>'employer_id, interview_date','joinType'=>'LEFT JOIN', 'on'=>'interview_date >DATE(NOW()) AND active=1'));
		$criteria->together=true;
		
		$limit=$this->pageSize;
		return new CActiveDataProvider($this, array(
				'criteria'=>$criteria,
				'pagination'=>array('pageSize'=>$limit,'params'=>array('ViewStudentJobTitle[pageSize]'=>$limit)),
		));
	}
	
	/**
	 * Searches the hired history by the student id.
	 * @param integer $stuId
	 * @throws CException if stuId is null 
	 * @return CActiveDataProvider 
	 */
	public function searchHiredHistoryByStu($stuId){
		if (!isset($stuId)) {
			throw new CException("Student Id is required");
		}
		
		$criteria=new CDbCriteria();
		$criteria->compare('student_id', $stuId);
		$criteria->compare('is_hired', '1');
		$criteria->compare('is_current_hired', '0');
		
		$limit=$this->pageSize;
		return new CActiveDataProvider($this, array(
				'criteria'=>$criteria,
				'pagination'=>array('pageSize'=>$limit,'params'=>array('ViewStudentJobTitle[pageSize]'=>$limit)),
		));
	}
	
	/**
	 * Searches the current hired job title by the student id.
	 * @param integer $stuId
	 * @throws CException
	 * @return ViewStudentJobTitle
	 */
	public function searchCurrentHiredByStu($stuId){
		if (!isset($stuId)) {
			throw new CException("Student Id is required");
		}
	
		$criteria=new CDbCriteria();
		$criteria->compare('student_id', $stuId);
		$criteria->compare('is_hired', '1');
		$criteria->compare('is_current_hired', '1');
	
		return self::model()->find($criteria);
	}
}