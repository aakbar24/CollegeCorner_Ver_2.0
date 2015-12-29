<?php

/**
 * This is the model class for table "v_student".
 *
 * The followings are the available columns in table 'v_student':
 * @property integer $user_id
 * @property string $username
 * @property string $email
 * @property string $first_name
 * @property string $last_name
 * @property string $profile_image
 * @property string $user_group_name
 * @property string $membership_level_name
 * @property string $college_name
 * @property string $program_name
 * @property string $education_level_name
 * @property string $program_code
 * @property string $major_name
 * @property string $enrollment_date
 * @property string $about_me
 * @property string $is_notify
 * @property string $is_active
 * @property string $date_created
 * @property string $date_updated
 * 
 * @property ViewStudentJobTitle[] jobTitles
 */
class ViewStudent extends DBViewActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return ViewStudent the static model class
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
		return 'v_student';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('username, email, first_name, last_name, user_group_name, membership_level_name, college_name, program_name, education_level_name, date_created', 'required'),
			array('user_id', 'numerical', 'integerOnly'=>true),
			array('username', 'length', 'max'=>50),
			array('email', 'length', 'max'=>100),
			array('first_name, last_name, program_code', 'length', 'max'=>20),
			array('profile_image, college_name, education_level_name', 'length', 'max'=>30),
			array('user_group_name, membership_level_name', 'length', 'max'=>15),
			array('program_name', 'length', 'max'=>45),
			array('major_name', 'length', 'max'=>80),
			array('about_me', 'length', 'max'=>200),
			array('is_notify, is_active', 'length', 'max'=>1),
			array('enrollment_date, date_updated', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('user_id, username, email, first_name, last_name, profile_image, user_group_name, membership_level_name, college_name, program_name, education_level_name, program_code, major_name, enrollment_date, about_me, is_notify, is_active, date_created, date_updated', 'safe', 'on'=>'search'),
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
				'jobTitles' => array(self::HAS_MANY, 'ViewStudentJobTitle', 'user_id'),
		);
	}
	
	public function primaryKey(){
		return 'user_id';
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		//labels use the translation messages, make sure you provide the label messages in proper category file
		//default category is the 'model.php' in the messages folder 
		return array(
			'user_id' => Yii::t('model','viewStudent.user_id'),
			'username' => Yii::t('model','viewStudent.username'),
			'email' => Yii::t('model','viewStudent.email'),
			'first_name' => Yii::t('model','viewStudent.first_name'),
			'last_name' => Yii::t('model','viewStudent.last_name'),
			'profile_image' => Yii::t('model','viewStudent.profile_image'),
			'user_group_name' => Yii::t('model','viewStudent.user_group_name'),
			'membership_level_name' => Yii::t('model','viewStudent.membership_level_name'),
			'college_name' => Yii::t('model','viewStudent.college_name'),
			'program_name' => Yii::t('model','viewStudent.program_name'),
			'education_level_name' => Yii::t('model','viewStudent.education_level_name'),
			'program_code' => Yii::t('model','viewStudent.program_code'),
			'major_name' => Yii::t('model','viewStudent.major_name'),
			'enrollment_date' => Yii::t('model','viewStudent.enrollment_date'),
			'about_me' => Yii::t('model','viewStudent.about_me'),
			'is_notify' => Yii::t('model','viewStudent.is_notify'),
			'is_active' => Yii::t('model','viewStudent.is_active'),
			'date_created' => Yii::t('model','viewStudent.date_created'),
			'date_updated' => Yii::t('model','viewStudent.date_updated'),
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

		$criteria->compare('user_id',$this->user_id);
		$criteria->compare('username',$this->username,true);
		$criteria->compare('email',$this->email,true);
		$criteria->compare('first_name',$this->first_name,true);
		$criteria->compare('last_name',$this->last_name,true);
		$criteria->compare('profile_image',$this->profile_image,true);
		$criteria->compare('user_group_name',$this->user_group_name,true);
		$criteria->compare('membership_level_name',$this->membership_level_name,true);
		$criteria->compare('college_name',$this->college_name,true);
		$criteria->compare('program_name',$this->program_name,true);
		$criteria->compare('education_level_name',$this->education_level_name,true);
		$criteria->compare('program_code',$this->program_code,true);
		$criteria->compare('major_name',$this->major_name,true);
		$criteria->compare('enrollment_date',$this->enrollment_date,true);
		$criteria->compare('about_me',$this->about_me,true);
		$criteria->compare('is_notify',$this->is_notify,true);
		$criteria->compare('is_active',$this->is_active,true);
		$criteria->compare('date_created',$this->date_created,true);
		$criteria->compare('date_updated',$this->date_updated,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}