<?php

/**
 * This is the model class for table "{{job_cat}}".
 *
 * The followings are the available columns in table '{{job_cat}}':
 * @property integer $job_cat_id
 * @property string $job_cat_name
 *
 * The followings are the available model relations:
 * @property JobTitle[] $jobTitles
 */
class JobCat extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return JobCat the static model class
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
		return '{{job_cat}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('job_cat_name', 'required'),
			array('job_cat_name', 'length', 'max'=>40),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('job_cat_id, job_cat_name', 'safe', 'on'=>'search'),
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
			'jobTitles' => array(self::HAS_MANY, 'JobTitle', 'job_cat_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'job_cat_id' => Yii::t('model', 'jobCat.job_cat_id'),
			'job_cat_name' => Yii::t('model', 'jobCat.job_cat_name'),
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

		$criteria->compare('job_cat_id',$this->job_cat_id);
		$criteria->compare('job_cat_name',$this->job_cat_name,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	public static function getAllCategories()
	{
		return self::model()->cache(Yii::app()->params['dbCacheInterval'])->findAll(array('order'=>'job_cat_name ASC','condition'=>'is_active=1'));
	}
}