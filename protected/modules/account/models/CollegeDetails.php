<?php

/**
 * This is the model class for table "{{college_details}}".
 *
 * The followings are the available columns in table '{{college_details}}':
 * @property integer $college_id
 * @property string $logo_image
 * @property string $address
 * @property string $city
 * @property string $province
 * @property string $postal_code
 * @property integer $country_id
 * @property string $phone
 * @property string $ext
 * @property string $website
 * @property string $is_active
 * @property string $date_created
 * @property string $date_updated
 * @property string $event_background_color
 * @property string $event_text_color
 *
 * The followings are the available model relations:
 * @property College $college
 * @property Country $country
 */
class CollegeDetails extends CActiveRecord
{
	public $logoImagePath;
	
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return CollegeDetails the static model class
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
		return '{{college_details}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('college_id, address, city, province, postal_code, country_id, phone, event_background_color, event_text_color', 'required'),
			array('college_id, country_id', 'numerical', 'integerOnly'=>true),
			array('logo_image, city, province, phone', 'length', 'max'=>20),
			array('address, website', 'length', 'max'=>100),
			array('postal_code', 'length', 'max'=>7),
			array('event_background_color, event_text_color', 'length', 'max'=>10),
			array('ext', 'length', 'max'=>5),
			array('is_active', 'length', 'max'=>1),
			array('date_updated', 'safe'),
			array('logoImagePath','file','allowEmpty'=>true, 'safe'=>true, 'maxSize'=>2097152,'types'=>'gif,png,jpg'),
			array('website', 'url', 'defaultScheme'=>'http'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('college_id, logo_image, address, city, province, postal_code, country_id, phone, ext, website, is_active, date_created, date_updated', 'safe', 'on'=>'search'),
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
			'college' => array(self::BELONGS_TO, 'College', 'college_id'),
			'country' => array(self::BELONGS_TO, 'Country', 'country_id'),
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
			'college_id' => Yii::t('model','collegeDetails.college_id'),
			'logo_image' => Yii::t('model','collegeDetails.logo_image'),
			'address' => Yii::t('model','collegeDetails.address'),
			'city' => Yii::t('model','collegeDetails.city'),
			'province' => Yii::t('model','collegeDetails.province'),
			'postal_code' => Yii::t('model','collegeDetails.postal_code'),
			'country_id' => Yii::t('model','collegeDetails.country_id'),
			'phone' => Yii::t('model','collegeDetails.phone'),
			'ext' => Yii::t('model','collegeDetails.ext'),
			'website' => Yii::t('model','collegeDetails.website'),
			'is_active' => Yii::t('model','collegeDetails.is_active'),
			'date_created' => Yii::t('model','collegeDetails.date_created'),
			'date_updated' => Yii::t('model','collegeDetails.date_updated'),
			'event_background_color' => Yii::t('model','collegeDetails.event_background_color'),
			'event_text_color' => Yii::t('model','collegeDetails.event_text_color'),
		);
	}
	
	public function beforeSave(){
		if ($this->isNewRecord) {
			$this->date_created=new CDbExpression('NOW()');
		}else{
			$this->date_updated=new CDbExpression('NOW()');
		}
		return parent::beforeSave();
	}
	
	public function saveWithLogoImage(){
		$tr=Yii::app()->db->beginTransaction();
		try {
			$saved=$this->save();
			if ($saved) {
				
				if ($this->logoImagePath!=null && $this->logoImagePath!='') {
					$logoImage=substr($this->logoImagePath, strrpos($this->logoImagePath, '/'));
					$ext=CFileHelper::getExtension($logoImage);
					$logoImageName=$this->primaryKey.'-logo.'.$ext;
					$imageUploadPath=self::getLogoImageUploadPath().$logoImage;
					$imageSavePath=self::getLogoImageSavedPath().'/'.$logoImageName;
					$this->logo_image=$logoImageName;
				}
				
				if ((isset($imageUploadPath) && isset($imageSavePath))&& !copy($imageUploadPath, $imageSavePath)) {
					$this->addError('logoImagePath', 'Unable to save the logo image.');
					unlink($imageUploadPath);
					throw new CException('Save failed.\nDetails:'.json_encode($this->errors));
				}else{
					if (!$this->save()) {
						throw new CException('Save failed.\nDetails:'.json_encode($this->errors));
					}
					$tr->commit();
					return true;
				}
			}else{
				throw new CException('Initial Save failed.\nDetails:'.json_encode($this->errors));
			}
		} catch (Exception $e) {
			$this->addError('', 'Unable to save the logo image.');
			$tr->rollback();
			return false;
		}
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
		$criteria->compare('logo_image',$this->logo_image,true);
		$criteria->compare('address',$this->address,true);
		$criteria->compare('city',$this->city,true);
		$criteria->compare('province',$this->province,true);
		$criteria->compare('postal_code',$this->postal_code,true);
		$criteria->compare('country_id',$this->country_id);
		$criteria->compare('phone',$this->phone,true);
		$criteria->compare('ext',$this->ext,true);
		$criteria->compare('website',$this->website,true);
		$criteria->compare('is_active',$this->is_active,true);
		$criteria->compare('date_created',$this->date_created,true);
		$criteria->compare('date_updated',$this->date_updated,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	public static function getLogoImageUploadPath(){
		return Yii::getPathOfAlias('site.files').'/uploads/colleges';
	}
	
	public static function getLogoImageSavedPath(){
		return Yii::getPathOfAlias('site.files').'/images/colleges';
	}
}