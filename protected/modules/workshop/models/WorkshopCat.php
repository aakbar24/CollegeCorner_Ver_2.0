<?php

/**
 * This is the model class for table "{{workshop_cat}}".
 *
 * The followings are the available columns in table '{{workshop_cat}}':
 * @property integer $workshop_cat_id
 * @property string $workshop_cat_name
 * @property boolean $is_active
 *
 * The followings are the available model relations:
 * @property Workshop[] $workshops
 */
class WorkshopCat extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return WorkshopCat the static model class
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
		return '{{workshop_cat}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('workshop_cat_name, is_active', 'required'),
			array('workshop_cat_name', 'length', 'max'=>45),
			array('is_active','boolean','allowEmpty'=>false),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('workshop_cat_id, workshop_cat_name, is_active', 'safe', 'on'=>'search'),
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
			'workshops' => array(self::HAS_MANY, 'Workshop', 'workshop_cat_id'),
			'workshopCount'=>array(self::STAT,'Workshop','workshop_cat_id'),
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
			'workshop_cat_id' => Yii::t('model','workshopCat.workshop_cat_id'),
			'workshop_cat_name' => Yii::t('model','workshopCat.workshop_cat_name'),
			'is_active' => Yii::t('model','workshopCat.is_active'),
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

		$criteria->compare('workshop_cat_id',$this->workshop_cat_id);
		$criteria->compare('workshop_cat_name',$this->workshop_cat_name,true);
		$criteria->compare('is_active',1);
		$criteria->with=array('workshopCount');
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	public static function getAllCategories(){
		$dependency=new CDbCacheDependency('SELECT count(workshop_cat_id) FROM tbl_workshop_cat WHERE is_active=1');
		return self::model()->cache(Yii::app()->params['dbCacheIntervalLong'],$dependency)->findAll('is_active=1');
	}
	
	public static function deleteCat($id){
		return self::model()->updateByPk($id, array('is_active'=>0))==1;
	}
}