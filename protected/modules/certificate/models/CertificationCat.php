<?php

/**
 * This is the model class for table "{{certification_cat}}".
 *
 * The followings are the available columns in table '{{certification_cat}}':
 * @property integer $certification_cat_id
 * @property string $certification_cat_name
 *
 * The followings are the available model relations:
 * @property Certification[] $certifications
 */
class CertificationCat extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return CertificationCat the static model class
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
		return '{{certification_cat}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('certification_cat_name', 'required'),
			array('certification_cat_name', 'length', 'max'=>30),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('certification_cat_id, certification_cat_name', 'safe', 'on'=>'search'),
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
			'certifications' => array(self::HAS_MANY, 'Certification', 'certification_cat_id'),
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
			'certification_cat_id' => Yii::t('model','certificationCat.certification_cat_id'),
			'certification_cat_name' => Yii::t('model','certificationCat.certification_cat_name'),
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

		$criteria->compare('certification_cat_id',$this->certification_cat_id);
		$criteria->compare('certification_cat_name',$this->certification_cat_name,true);
		$criteria->compare('is_active',1);
		//$criteria->with=array('workshopCount');

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	public static function getAllCertCats(){
		$dependency=new CDbCacheDependency('SELECT count(certification_cat_id) FROM tbl_certification_cat WHERE is_active=1');
		return self::model()->cache(Yii::app()->params['dbCacheIntervalLong'],$dependency)->findAll('is_active=1');
	}
	
	public static function deleteCat($id){
		return self::model()->updateByPk($id, array('is_active'=>0))==1;
	}
}