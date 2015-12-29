<?php

/**
 * This is the model class for table "{{slide}}".
 *
 * The followings are the available columns in table '{{slide}}':
 * @property integer $slide_id
 * @property string $slide_image
 * @property string $label
 * @property string $caption
 * @property integer $position
 */
class Slide extends CActiveRecord
{

    const IMAGE_PATH = '/files/images/slides/';

    const IMAGE_DEFAULT = 'slide_default.jpg';

    public $oldPosition = null;

	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Slide the static model class
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
		return '{{slide}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('position', 'numerical', 'integerOnly'=>true),
            array('label', 'required'),
			array('slide_image', 'length', 'max'=>100),
            array('slide_image', 'file', 'types' => 'jpg, jpeg, gif, png', 'maxSize' => 1024 * 1024 * 2, 'tooLarge' => 'Images have to be smaller than 2MB', 'allowEmpty' => true),
			array('label, caption', 'length', 'max'=>500),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
            array('slide_image', 'safe', 'on' => 'insert'),
			array('slide_id, slide_image, label, caption, position', 'safe', 'on'=>'search'),
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
			'slide_id' => Yii::t('model','slide.slide_id'),
			'slide_image' => Yii::t('model','slide.slide_image'),
			'label' => Yii::t('model','slide.label'),
			'caption' => Yii::t('model','slide.caption'),
			'position' => Yii::t('model','slide.position'),
		);
	}

    public function getCaption()
    {
    return !empty($this->caption) ? $this->caption : " ";
    }

    protected function afterDelete()
    {
        parent::afterDelete();

        $this->removeImage();

        $this->_adjustSlideOrderOnDelete();
    }

    private function _adjustSlideOrderOnDelete()
    {
        $q = "UPDATE
  tbl_slide
SET
  position = position - 1
WHERE
  position > :position
";

        $position =  $this->position;

        $cmd = Yii::app()->db->createCommand($q);
        $cmd->bindParam(':position', $position, PDO::PARAM_INT);

        $cmd->execute();
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

		$criteria->compare('slide_id',$this->slide_id);
		$criteria->compare('slide_image',$this->slide_image,true);
		$criteria->compare('label',$this->label,true);
		$criteria->compare('caption',$this->caption,true);
		$criteria->compare('position',$this->position);

        $criteria->order = "position";

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

    public function save($runValidation = false, $attributes = null)
    {
        if ($this->isNewRecord)
        {
            $numSlides = $this->model()->count();

            if ($this->position != $numSlides)
            {
                Yii::log("Repositioning");

                $q = "UPDATE
  tbl_slide
SET
  position = position + 1
WHERE
  position >= :newPosition
";

                $newPosition = $this->position;
                $cmd = Yii::app()->db->createCommand($q);
                $cmd->bindParam(':newPosition', $newPosition, PDO::PARAM_INT);

                $cmd->execute();
            }
        }
        else if ($this->oldPosition != null && $this->position != $this->oldPosition){
            $q = "UPDATE
  tbl_slide
SET
  position =
  CASE
  WHEN position = :oldPosition THEN :newPosition
  ELSE IF(:newPosition > :oldPosition, position - 1, position + 1)
  END
WHERE
  position BETWEEN LEAST(:newPosition, :oldPosition) AND GREATEST(:newPosition, :oldPosition)
";
            $newPosition = $this->position;
            $cmd = Yii::app()->db->createCommand($q);
            $cmd->bindParam(':newPosition', $newPosition, PDO::PARAM_INT);
            $cmd->bindParam(':oldPosition', $this->oldPosition, PDO::PARAM_INT);

            $cmd->execute();

        }

        if (empty($this->caption))
        {
            $this->caption = " ";
        }

        return parent::save($runValidation, $attributes);
    }

    public function getImageSrc()
    {
        if (!empty($this->slide_image)) {
            $filePath = Yii::app()->request->baseUrl . self::IMAGE_PATH . $this->slide_image . "_" . $this->primaryKey;
            return $filePath;
        }

        return null;
    }

    public static function generateImagePath($slide_image = null, $pk = null)
    {
        Yii::log($slide_image . " - " . $pk);
        if (!empty($slide_image) && !empty($pk)) {
            $filePath = Yii::app()->request->baseUrl . self::IMAGE_PATH . $slide_image . "_" . $pk;
            return $filePath;
        }

        return $filePath = Yii::app()->request->baseUrl . self::IMAGE_PATH . self::IMAGE_DEFAULT;
    }

    public static function getSliderItems()
    {
        $q = "SELECT
        slide_id,
        slide_image,
	label,
        caption
FROM tbl_slide
ORDER BY position";

      $slides = Yii::app()->db->createCommand($q)->query();

    $items = array();

        foreach ($slides as $slide)
        {
            $items[] = array('image' => self::generateImagePath($slide['slide_image'], $slide['slide_id']), 'label' => $slide['label'], 'caption' => $slide['caption']);
        }

    return $items;
    }

    public function removeImage()
    {
        if (!empty($this->slide_image))
            unlink(Yii::getPathOfAlias('site.files') . '/images/slides/' . $this->slide_image . "_" . $this->getPrimaryKey());
    }

}