<?php

/**
 * This is the model class for table "{{college}}".
 *
 * The followings are the available columns in table '{{college}}':
 * @property integer $college_id
 * @property string $college_name
 *
 * The followings are the available model relations:
 * @property CollegeDetails $collegeDetails
 * @property Program[] $programs
 */
class College extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return College the static model class
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
		return '{{college}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('college_name', 'required'),
			array('college_name', 'length', 'max'=>30),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('college_id, college_name', 'safe', 'on'=>'search'),
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
			'collegeDetails' => array(self::HAS_ONE, 'CollegeDetails', 'college_id'),
			'programs' => array(self::MANY_MANY, 'Program', '{{college_program}}(college_id, program_id)'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'college_id' => 'College',
			'college_name' => 'College Name',
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

		$criteria->compare('college_id',$this->college_id);
		$criteria->compare('college_name',$this->college_name,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	public static function getAllCollege()
	{
		return College::model()->cache(Yii::app()->params['dbCacheInterval'])->findAll();
	}
	
	public static function getProgramsByCollege($college_id)
	{
		$college=College::model()->cache(Yii::app()->params['dbCacheInterval'])->findByPk($college_id);
		if ($college!=null) 
		{
			return $college->programs;
		}else 
		{
			return array();
		}
		
	}
        
        public static function getUserCollege()
        {
            return Student::model()->cache(Yii::app()->params['dbCacheInterval'])->findByPk(Yii::app()->user->id)->college;
        }
        
        public static function getCollegeFilter($userGroup){
		
		if ($userGroup==SuperAdmin::USER_GROUP_ID) {
			return self::model()->cache(Yii::app()->params['dbCacheIntervalLong'])->findAll();
		}
                else
		return array();
	}
}
