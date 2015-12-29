<?php

/**
 * This is the model class for table "{{college_program}}".
 *
 * The followings are the available columns in table '{{college_program}}':
 * @property integer $college_id
 * @property integer $program_id
 *
 * The followings are the available model relations:
 * @property Student[] $students
 * @property Student[] $students1
 * @property Thread[] $threads
 * @property Thread[] $threads1
 */
class CollegeProgram extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return CollegeProgram the static model class
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
		return '{{college_program}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('college_id, program_id', 'required'),
			array('college_id, program_id', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('college_id, program_id', 'safe', 'on'=>'search'),
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
			'students' => array(self::HAS_MANY, 'Student', 'college_id'),
			'students1' => array(self::HAS_MANY, 'Student', 'program_id'),
			'threads' => array(self::HAS_MANY, 'Thread', 'college_id'),
			'threads1' => array(self::HAS_MANY, 'Thread', 'program_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'college_id' => 'College',
			'program_id' => 'Program',
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
		$criteria->compare('program_id',$this->program_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}