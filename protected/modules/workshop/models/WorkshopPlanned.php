<?php

/**
 * This is the model class for table "{{workshop_planned}}".
 *
 * The followings are the available columns in table '{{workshop_planned}}':
 * @property integer $post_item_id
 *
 * The followings are the available model relations:
 * @property PostItem $postItem
 */
class WorkshopPlanned extends CActiveRecord
{

    const POST_TYPE=8;

	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return WorkshopPlanned the static model class
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
		return '{{workshop_planned}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('post_item_id', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('post_item_id', 'safe', 'on'=>'search'),
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
			'postItem' => array(self::BELONGS_TO, 'PostItem', 'post_item_id'),
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
			'post_item_id' => Yii::t('model','workshopPlanned.post_item_id'),
		);
	}

    public static function getPlannedWorkshops()
    {
        $criteria=new CDbCriteria;

        $criteria->with = array('postItem'=>array('select'=> array('title','description')));

        $sort=array(
            'defaultOrder'=>'title',
        );

        return new CActiveDataProvider(self::model(), array(
            'criteria' => $criteria,
            'sort' => $sort
        ));
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

        $criteria->with = array('postItem');

        $sort=array(
            'defaultOrder'=>'title',
        );

        return $this->relatedSearch(
            $criteria,
            array('sort'=>$sort)
        );

		/*return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));*/
	}

    function behaviors() {
        return array(
            'relatedsearch'=>array(
                'class'=>'RelatedSearchBehavior',
                'relations'=>array(
                    'title'=>'postItem.title',
                    'description'=>'postItem.description',
                    'date_created'=>'postItem.date_created',
                ),
            ),
        );
    }

    public function save($runValidation = true, $attributes = null, $postItem = null) {

        if ($this->isNewRecord) {
            if ($postItem != null && $postItem->primaryKey != null) {
                $this->post_item_id = $postItem->primaryKey;
                return parent::save($runValidation, $attributes);
            } else {
                throw new CException('A post item is required');
            }
        } else {
            return parent::save($runValidation, $attributes);
        }
    }
}