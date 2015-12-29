<?php

/**
 * This is the model class for table "{{user_group}}".
 *
 * The followings are the available columns in table '{{user_group}}':
 * @property integer $user_group_id
 * @property string $user_group_name
 * @property integer $parent_group_id
 *
 * The followings are the available model relations:
 * @property User[] $users
 * @property UserGroup $parentGroup
 * @property UserGroup[] $userGroups
 */
class UserGroup extends CActiveRecord
{
	
	const ADMIN_GROUP_ID=3;
	const NORMAL_USER_GROUP_ID=5;
	const MANAGER_GROUP_ID=4;
	
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return UserGroup the static model class
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
		return '{{user_group}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('user_group_name', 'required'),
			array('parent_group_id', 'numerical', 'integerOnly'=>true),
			array('user_group_name', 'length', 'max'=>15),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('user_group_id, user_group_name, parent_group_id', 'safe', 'on'=>'search'),
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
			'users' => array(self::HAS_MANY, 'User', 'user_group_id'),
			'parentGroup' => array(self::BELONGS_TO, 'UserGroup', 'parent_group_id'),
			'userGroups' => array(self::HAS_MANY, 'UserGroup', 'parent_group_id'),
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
			'user_group_id' => Yii::t('model','userGroup.user_group_id'),
			'user_group_name' => Yii::t('model','userGroup.user_group_name'),
			'parent_group_id' => Yii::t('model','userGroup.parent_group_id'),
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

		$criteria->compare('user_group_id',$this->user_group_id);
		$criteria->compare('user_group_name',$this->user_group_name,true);
		$criteria->compare('parent_group_id',$this->parent_group_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	public static function allowBackendAccess($userGroup){
		$criteria=new CDbCriteria;
		$criteria->addInCondition('user_group_id', array(self::ADMIN_GROUP_ID,self::MANAGER_GROUP_ID),'OR')->addInCondition('parent_group_id',array(self::ADMIN_GROUP_ID,self::MANAGER_GROUP_ID),'OR');
		$criteria->addCondition('user_group_id=:userGroup');
		$criteria->params[':userGroup']=$userGroup;
		return self::model()->cache(Yii::app()->params['dbCacheIntervalLong'])->exists($criteria);
	}
	
	public function isAdmin(){
		$userGroup=intval($this->user_group_id);
		$parentGroup=intval($this->parent_group_id);
		return $userGroup ==self::ADMIN_GROUP_ID || $parentGroup==self::ADMIN_GROUP_ID;
	}
	
	public static function getAdminFilter($userGroup){
		if ($userGroup==Admin::USER_GROUP_ID) {
			$criteria = new CDbCriteria();
			$criteria->addCondition('user_group_id<>:adminGroupId AND parent_group_id<>:adminGroupId');
			$criteria->params[':adminGroupId']=$userGroup;
			return self::model()->cache(Yii::app()->params['dbCacheIntervalLong'])->findAll($criteria);
		}
		else if ($userGroup==SuperAdmin::USER_GROUP_ID) {
			return self::model()->cache(Yii::app()->params['dbCacheIntervalLong'])->findAll();
		}
		return array();
	}
	
	public static function getSuperAdminFormDropdown($userGroup){
		if ($userGroup==SuperAdmin::USER_GROUP_ID) {
			$criteria = new CDbCriteria();
			$criteria->addInCondition('user_group_id', array(Admin::USER_GROUP_ID,SuperAdmin::USER_GROUP_ID));
			return self::model()->cache(Yii::app()->params['dbCacheIntervalLong'])->findAll($criteria);
		}
		return array();
	}

}