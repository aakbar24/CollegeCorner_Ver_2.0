<?php

/**
 * This is the model class for table "{{favorite_student_job_title}}".
 *
 * The followings are the available columns in table '{{favorite_student_job_title}}':
 * @property integer $stu_job_id
 * @property integer $employer_id
 */
class FavoriteStudentJobTitle extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return FavoriteStudentJobTitle the static model class
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
		return '{{favorite_student_job_title}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('stu_job_id, employer_id', 'required'),
			array('stu_job_id, employer_id', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('stu_job_id, employer_id', 'safe', 'on'=>'search'),
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
				'studentJobTitle' => array(self::BELONGS_TO, 'StudentJobTitle', 'stu_job_id'),
				'employer' => array(self::BELONGS_TO, 'Employer', 'employer_id'),
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
			'stu_job_id' => Yii::t('model','favoriteStudentJobTitle.stu_job_id'),
			'employer_id' => Yii::t('model','favoriteStudentJobTitle.employer_id'),
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
		$criteria->compare('employer_id',$this->employer_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	/**
	 * Bulk inserts the supplied list of stu_job_ids with the empId.
	 * 
	 * @param array $resumes - array of stu_job_ids
	 * @param integer $empId - the empId that favorites the resumes
	 * 
	 * @return boolean - returns true when succeeded or nothing inserted, otherwise exception will be thrown.
	 */
	public static function saveResumes($resumes, $empId){
		
		if (!isset($resumes) || !is_array($resumes) || !isset($empId)) {
			throw new CException('Resumes and Employer Id are required');
		}
		
		if (count($resumes)==0) {
			return true;
		}
		
		$transaction=Yii::app()->db->beginTransaction();
		try {
			
			foreach ($resumes as $resume) {
				$fav=new FavoriteStudentJobTitle();
				$fav->stu_job_id=intval($resume);
				$fav->employer_id=intval($empId);
				if(!$fav->save()){
					$transaction->rollback();
					throw new CException(implode(', ', $fav->getErrors()));
				}
			}
			
			$transaction->commit();
			return true;
		} catch (Exception $e) {
			$transaction->rollback();
			throw $e;
		}
		
	}
	
	/**
	 * Filters the supplied list of stu_job_id that are not yet in the db with the employer_id. 
	 *
	 * @param array $resumes - array of stu_job_ids
	 * @param integer $empId - the empId that favorites the resumes
	 *
	 * @return array - list of stu_job_ids that are not yet in the db
	 */
	public static function getUnFavResumes($resumes, $empId){
	
		if (!isset($resumes) || !is_array($resumes) || !isset($empId)) {
			throw new CException('Resumes and Employer Id are required');
		}
		
		$criteria= new CDbCriteria();
		$criteria->compare('employer_id', $empId);
		$criteria->addInCondition('stu_job_id', $resumes);
		$criteria->index='stu_job_id';
		$criteria->select='stu_job_id';
		$favResumes=self::model()->findAll($criteria);
		
		if (count($favResumes)==0) {
			return $resumes;
		}
		else{
			
			$unFavResumes=array();
			
			foreach ($resumes as $resumeId) {
				
				if (!isset($favResumes[$resumeId])) {
					$unFavResumes[]=$resumeId;
				}
			}
			return $unFavResumes;
		}
	}
	
	public static function deleteResumes($resumes, $empId){
	
		if (!isset($resumes) || !is_array($resumes) || !isset($empId)) {
			throw new CException('Resumes and Employer Id are required');
		}
	
		$resCount=count($resumes);
		if ($resCount===0) {
			return true;
		}
	
		$transaction=Yii::app()->db->beginTransaction();
		try {
				$deletedCount=FavoriteStudentJobTitle::model()->deleteAllByAttributes(array('stu_job_id'=>$resumes,'employer_id'=>$empId));
				
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
		
}