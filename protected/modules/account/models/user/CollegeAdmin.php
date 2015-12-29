<?php

/**
 * This is the model class for table "{{college_admin}}".
 *
 * The followings are the available columns in table '{{college_admin}}':
 * @property integer $user_id
 * @property integer $college_id
 * @property string $department
 *
 * The followings are the available model relations:
 * @property User $user
 * @property College $college
 */
class CollegeAdmin extends CActiveRecord
{
	const USER_GROUP_ID=7;
	
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return CollegeAdmin the static model class
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
		return '{{college_admin}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('college_id', 'required'),
			array('user_id, college_id', 'numerical', 'integerOnly'=>true),
			array('department', 'length', 'max'=>50),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('user_id, college_id, department', 'safe', 'on'=>'search'),
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
			'user' => array(self::BELONGS_TO, 'User', 'user_id'),
			'college' => array(self::BELONGS_TO, 'College', 'college_id'),
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
			'user_id' => Yii::t('model','collegeAdmin.user_id'),
			'college_id' => Yii::t('model','collegeAdmin.college_id'),
			'department' => Yii::t('model','collegeAdmin.department'),
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
		$criteria->compare('college_id',$this->college_id);
		$criteria->compare('department',$this->department,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	/**
	 *
	 * Takes a saved valid user and save the current college admin object to the database.
	 * It calls the default CActiveRecord::save() function.
	 * @see CActiveRecord::save()
	 * @param User $user
	 * @param boolean $runValidation
	 * @param array $attributes
	 *
	 */
	public function save($runValidation=true,$attributes=null,$user=null) {
	
		if ($this->isNewRecord)
		{
			if ($user!=null && $user->primaryKey!=null)
			{
				$this->user_id=$user->primaryKey;
				return parent::save($runValidation,$attributes);
			}
			else
			{
				throw new CException('A valid user is required');
			}
		}
		else
		{
			return parent::save($runValidation,$attributes);
		}
	
	}
	
	public static function getDashboardItems(){
		return array(
				'college'=>array('label'=>Yii::t('view', 'dashboard.college_details_lb'), 'url'=>'account/user/updateCollegeDetails','icon'=>'user','description'=>'Edit College Profile details'),
				'community'=>array('label'=>Yii::t('view', 'dashboard.community_lb'), 'url'=>'account/auth/index','icon'=>'group','description'=>'Manage Student Communities'),
				'event'=>array('label'=>Yii::t('view', 'dashboard.event_lb'), 'url'=>'event/event/index','icon'=>'calendar','description'=>'Manage Events'),
				
		);
	}
	
	public static function getMainNavItems(){
		return array(
				array('label'=>Yii::t('view', 'menu.dashboard_lb'), 'url'=>array('/account/auth/index')),
		);
	}
        
        public static function getCollegeId()
        {
            return self::model()->findByPk(Yii::app()->user->id)->college_id;
        }
}