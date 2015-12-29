<?php

/**
 * This is the model class for table "{{workshop_facilitator}}".
 *
 * The followings are the available columns in table '{{workshop_facilitator}}':
 * @property integer $workshop_facilitator_id
 * @property string $first_name
 * @property string $last_name
 * @property string $name
 * @property string $biography
 * @property string $image
 * @property boolean is_active
 *
 * The followings are the available model relations:
 * @property Workshop[] $workshops
 */
class WorkshopFacilitator extends CActiveRecord
{
    public $imagePath;
    const defaultImage = 'facilitator_default.png';

	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return WorkshopFacilitator the static model class
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
		return '{{workshop_facilitator}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('first_name, last_name, biography, is_active', 'required'),
			array('first_name, last_name', 'length', 'max'=>30),
            array('image', 'length', 'max'=>30),
			array('is_active','boolean','allowEmpty'=>false),
            array('imagePath','file','allowEmpty'=>true, 'safe'=>true, 'maxSize'=>2097152,'types'=>'gif,png,jpg'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('workshop_facilitator_id, first_name, last_name, biography, is_active', 'safe', 'on'=>'search'),
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
			'workshops' => array(self::HAS_MANY, 'Workshop', 'workshop_facilitator_id'),
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
			'workshop_facilitator_id' => Yii::t('model','workshopFacilitator.workshop_facilitator_id'),
			'first_name' => Yii::t('model','workshopFacilitator.first_name'),
			'last_name' => Yii::t('model','workshopFacilitator.last_name'),
			'biography' => Yii::t('model','workshopFacilitator.biography'),
            'image' => Yii::t('model', 'workshopFacilitator.image'),
			'is_active' => Yii::t('model','workshopFacilitator.is_active'),
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

		$criteria->compare('workshop_facilitator_id',$this->workshop_facilitator_id);
		$criteria->compare('first_name',$this->first_name,true);
		$criteria->compare('last_name',$this->last_name,true);
		$criteria->compare('biography',$this->biography,true);
		$criteria->compare('is_active', $this->is_active);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

    public function save($runValidation=true,$attributes=null,$transaction=true)
    {
        if ($runValidation && !$this->validate($attributes)) {
            return false;
        }

        if ($transaction) {
            $tr=Yii::app()->db->beginTransaction();
            try {
                $saveWithProfileImage=$this->saveWithProfileImage($runValidation,$attributes);
                $tr->commit();
            } catch (Exception $e) {
                $tr->rollback();
                throw $e;
            }
        }else{
            $saveWithProfileImage=$this->saveWithProfileImage($runValidation,$attributes);
        }

        //null indicates there is no profile image uploaded, so we perform a normal save
        if ($saveWithProfileImage==null) {
            return parent::save($runValidation,$attributes);
        }else{
            return $saveWithProfileImage;
        }

    }

    protected function saveWithProfileImage($runValidation=true,$attributes=null){

        if ($this->imagePath!=null && $this->imagePath!='') {
            if(parent::save($runValidation,$attributes)){

                $image=substr($this->imagePath, strrpos($this->imagePath, '/'));
                $ext=CFileHelper::getExtension($image);

                $imageName=$this->primaryKey.'-image.'.$ext;

                $imageUploadPath=self::getImageUploadPath().$image;
                $imageSavePath=self::getImageSavedPath().'/'.$imageName;

                if (!copy($imageUploadPath, $imageSavePath)) {
                    $this->addError('imagePath', 'Unable to save the profile image.');
                    unlink($imageUploadPath);
                    return false;
                }else{
                    $this->image=$imageName;
                }
                if(parent::save($runValidation,$attributes)){
                    unlink($imageUploadPath);
                    return true;
                }
            }
            return false;
        }else{
            return null;
        }
    }

	
	public function getName(){
		return $this->first_name.' '.$this->last_name;
	}
	
	public static function getAllFacilitators(){
		$dependency=new CDbCacheDependency('SELECT count(workshop_facilitator_id) FROM tbl_workshop_facilitator WHERE is_active=1');
		return self::model()->cache(Yii::app()->params['dbCacheIntervalLong'],$dependency)->findAll('is_active=1');
	}
	
	public static function deleteFacilitator($id){
		return self::model()->updateByPk($id, array('is_active'=>0))==1;
	}

    public static function getImageUploadPath(){
        return Yii::getPathOfAlias('site.files').'/uploads/facilitator';
    }

    public static function getImageSavedPath(){
        return Yii::getPathOfAlias('site.files').'/images/facilitator';
    }

    public static function getImageUploadUrl(){
        return Yii::app()->baseUrl.'/files/images/facilitator/';
    }

    public function getImageUrl(){
        if (!empty($this->image))
        return Yii::app()->baseUrl.'/files/images/facilitator/'.$this->image;
        else
            return Yii::app()->baseUrl.'/files/images/facilitator/'.self::defaultImage;
    }

    public static function generateImagePath($article_image = null)
    {
        if (!empty($article_image))
            return Yii::app()->baseUrl.'/files/images/facilitator/'.$article_image;
        else
            return Yii::app()->baseUrl.'/files/images/facilitator/'.self::defaultImage;
    }
}