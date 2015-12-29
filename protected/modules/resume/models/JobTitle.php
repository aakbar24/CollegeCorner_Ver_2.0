<?php

/**
 * This is the model class for table "{{job_title}}".
 *
 * The followings are the available columns in table '{{job_title}}':
 * @property integer $job_title_id
 * @property string $job_title_name
 * @property integer $job_cat_id
 *
 * The followings are the available model relations:
 * @property JobCat $jobCat
 * @property Student[] $students
 */
class JobTitle extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return JobTitle the static model class
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
		return '{{job_title}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('job_title_name, job_cat_id', 'required'),
			array('job_cat_id', 'numerical', 'integerOnly'=>true),
			array('job_title_name', 'length', 'max'=>45),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('job_title_id, job_title_name, job_cat_id', 'safe', 'on'=>'search'),
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
			'jobCat' => array(self::BELONGS_TO, 'JobCat', 'job_cat_id'),
			'students' => array(self::MANY_MANY, 'Student', '{{student_job_title}}(job_title_id, user_id)'),
			'studentJobTitles' => array(self::HAS_MANY, 'StudentJobTitle', 'job_title_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'job_title_id' => Yii::t('model', 'jobTitle.job_title_id'),
			'job_title_name' => Yii::t('model', 'jobTitle.job_title_name'),
			'job_cat_id' => Yii::t('model', 'jobTitle.job_cat_id'),
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

		$criteria->compare('job_title_id',$this->job_title_id);
		$criteria->compare('job_title_name',$this->job_title_name,true);
		$criteria->compare('job_cat_id',$this->job_cat_id);
		
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	public static function getTitlesByCategory($catId,$userId)
	{
		
		$dbc=Yii::app()->db->createCommand();
		$dbc->select('t.job_title_id, t.job_title_name')->
		from('{{job_title}} t')->
		where('t.job_title_id NOT IN (SELECT job_title_id FROM {{student_job_title}} WHERE user_id=:userId and is_hired="0" and is_current_hired="0" and expiry_date >DATE(NOW()))',array(':userId'=>$userId))->
		andWhere('t.job_cat_id=:jobCat',array(':jobCat'=>$catId))->andWhere('t.is_active=1')->order('job_title_name ASC');
		
		$dbc->prepare();
		$titles=$dbc->queryAll(true);
		
		
		if ($titles==null) {
			return array();
		}
		return $titles;
	}
	
	public static function getAllTitlesByCategory($catId)
	{
	
		$dbc=Yii::app()->db->createCommand();
		$dbc->select('t.job_title_id, t.job_title_name')->
		from('{{job_title}} t')->where('t.job_cat_id=:jobCat',array(':jobCat'=>$catId))->andWhere('t.is_active=1')->order('job_title_name ASC');
	
		$dbc->prepare();
		$titles=$dbc->queryAll(true);
	
	
		if ($titles==null) {
			return array();
		}
		return $titles;
	}
}