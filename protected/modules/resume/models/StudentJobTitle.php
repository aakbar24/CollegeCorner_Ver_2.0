<?php

/**
 * This is the model class for table "{{student_job_title}}".
 *
 * The followings are the available columns in table '{{student_job_title}}':
 * @property integer $stu_job_id
 * @property integer $user_id
 * @property integer $job_title_id
 * @property integer $job_type_id
 * @property string $resume_file
 * @property string $skills
 * @property integer $employer_id
 * @property string $date_created
 * @property string $expiry_date
 * @property string $is_hired
 * @property string $is_current_hired
 * @property string $date_hired
 *
 * The followings are the available model relations:
 * @property FavoriteStudentJobTitle[] $favoriteStudentJobTitles
 * @property InterviewStudentJobTitle[] $interviewStudentJobTitles
 */
class StudentJobTitle extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return StudentJobTitle the static model class
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
		return '{{student_job_title}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('user_id, job_title_id, job_type_id, resume_file, skills, expiry_date', 'required'),
			array('stu_job_id, user_id, job_title_id, job_type_id, employer_id', 'numerical', 'integerOnly'=>true),
			array('resume_file', 'length', 'max'=>100),
			array('skills', 'length', 'max'=>200),
			array('is_hired, is_current_hired', 'length', 'max'=>1),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('stu_job_id, user_id, job_title_id, job_type_id, resume_file, skills, employer_id, date_created,expiry_date, is_hired', 'safe', 'on'=>'search'),
			array('stu_job_id, employer_id, is_hired, is_current_hired, date_hired', 'required', 'on'=>'hire'),
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
			'favoriteStudentJobTitles' => array(self::HAS_MANY, 'FavoriteStudentJobTitle', 'stu_job_id'),
			'interviewStudentJobTitles' => array(self::HAS_MANY, 'InterviewStudentJobTitle', 'stu_job_id'),
			'jobTitle'=>array(self::BELONGS_TO,'JobTitle', 'job_title_id'),
			'student'=>array(self::BELONGS_TO,'Student', 'user_id'),
			'user'=>array(self::BELONGS_TO,'User', 'user_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'stu_job_id' => Yii::t('model', 'studentJobTitle.stu_job_id'),
			'user_id' => Yii::t('model', 'studentJobTitle.user_id'),
			'job_title_id' => Yii::t('model', 'studentJobTitle.job_title_id'),
			'job_type_id' => Yii::t('model', 'studentJobTitle.job_type_id'),
			'resume_file' => Yii::t('model', 'studentJobTitle.resume_file'),
			'skills' => Yii::t('model', 'studentJobTitle.skills'),
			'employer_id' => Yii::t('model', 'studentJobTitle.employer_id'),
			'expiry_date' => Yii::t('model', 'studentJobTitle.expiry_date'),
			'is_hired' =>Yii::t('model', 'studentJobTitle.is_hired'),
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
		$criteria->compare('stu_job_id',$this->stu_job_id);
		$criteria->compare('user_id',$this->user_id);
		$criteria->compare('job_title_id',$this->job_title_id);
		$criteria->compare('job_type_id',$this->job_type_id);
		$criteria->compare('resume_file',$this->resume_file,true);
		$criteria->compare('skills',$this->skills,true);
		$criteria->compare('employer_id',$this->employer_id);
		$criteria->compare('expiry_date',$this->expiry_date,true);
		$criteria->compare('is_hired',$this->is_hired,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	public function generateResumeFileUrl()
	{
		if ($this->resume_file!==null) 
		{
			return Yii::app()->createAbsoluteUrl('resume/file/download',array('name'=>$this->resume_file));
		}
		return null;
		
	}
	
	public static function isCurrentHired($user_id){
		return self::model()->exists('is_current_hired ="1" AND user_id=:user_id',array(':user_id'=>$user_id));
	}
	
	public static function getResumeToHire($stuJobId){
		if (isset($stuJobId)) {
			$criteria=new CDbCriteria();
			$criteria->compare('stu_job_id', $stuJobId);
			$criteria->compare('is_hired', '0');
			$criteria->compare('is_current_hired', '0');
			$criteria->addCondition('employer_id IS NULL');
			return StudentJobTitle::model()->find($criteria);
		}
		
		return false;
	}
	
	public static function getResumeToUnHire($stuJobId,$empId){
		if (isset($stuJobId)) {
			$criteria=new CDbCriteria();
			$criteria->compare('stu_job_id', $stuJobId);
			$criteria->compare('is_hired', '1');
			$criteria->compare('is_current_hired', '1');
			$criteria->compare('employer_id', $empId);
			return StudentJobTitle::model()->find($criteria);
		}
	
		return false;
	}
	
	public function isStudentHired(){
		$criteria=new CDbCriteria();
		$criteria->compare('user_id', $this->user_id);
		$criteria->compare('is_current_hired', '1');
		return self::model()->exists($criteria);
	}
	
	public function hire($empId){
		if (isset($empId) && !$this->isNewRecord) {
			if (!$this->isStudentHired()) {
				$this->employer_id=$empId;
				$this->is_hired='1';
				$this->is_current_hired='1';
				$this->date_hired=new CDbExpression('NOW()');
				return $this->save();
			}
		}
		return false;
	}
	
	public function unhire($empId){
		if (isset($empId) && !$this->isNewRecord) {
			if ($this->is_current_hired=='1' && $this->employer_id==$empId) {
				$this->is_current_hired='0';
				return $this->save();
			}
		}
		return false;
	}
	
	public static function unhireResumes($resumes, $empId){
		if (!isset($resumes) || !is_array($resumes) || !isset($empId)) {
			throw new CException('Resumes and Employer Id are required');
		}
	
		$resCount=count($resumes);
		if ($resCount===0) {
			return true;
		}
	
		$transaction=Yii::app()->db->beginTransaction();
		try {
			$hiredResumes=StudentJobTitle::model()->FindAllByAttributes(array('stu_job_id'=>$resumes,'employer_id'=>$empId,'is_current_hired'=>'1','is_hired'=>'1'));
			$deletedCount=0;
			
			foreach ($hiredResumes as $hired) {
				if ($hired->unhire($empId)) {
					$deletedCount++;
				}
			}
			
			if($deletedCount!==$resCount){
				throw new CException("Only {$deletedCount} records deleted, while deleting {$resCount} records.");
			}
	
			$transaction->commit();
			return true;
		} catch (Exception $e) {
			$transaction->rollback();
			throw $e;
		}
	}
	
	public function delete(){
		$tr=Yii::app()->db->beginTransaction();
		try {
			FavoriteStudentJobTitle::model()->deleteAllByAttributes(array('stu_job_id'=>$this->stu_job_id));
			InterviewStudentJobTitle::model()->deleteAllByAttributes(array('stu_job_id'=>$this->stu_job_id));
			parent::delete();
			$tr->commit();
			return true;
		} catch (Exception $e) {
			$tr->rollback();
			throw $e;
		}
	}
}