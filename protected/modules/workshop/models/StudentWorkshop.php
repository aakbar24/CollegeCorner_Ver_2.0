<?php

/**
 * This is the model class for table "{{student_workshop}}".
 *
 * The followings are the available columns in table '{{student_workshop}}':
 * @property integer $user_id
 * @property integer $post_item_id
 * @property string $is_history
 */
class StudentWorkshop extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return StudentWorkshop the static model class
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
		return '{{student_workshop}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('user_id, post_item_id', 'required'),
			array('user_id, post_item_id', 'numerical', 'integerOnly'=>true),
			array('is_history', 'length', 'max'=>1),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('is_active, title, start_date, start_time, end_date, end_time, user_id, post_item_id, is_history', 'safe', 'on'=>'search'),
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
			'workshop'=>array(self::BELONGS_TO, 'Workshop', 'post_item_id'),
			'postItem'=>array(self::BELONGS_TO, 'PostItem', 'post_item_id'),
			'student'=>array(self::BELONGS_TO, 'Student', 'user_id'),
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
			'user_id' => Yii::t('model','studentWorkshop.user_id'),
			'post_item_id' => Yii::t('model','studentWorkshop.post_item_id'),
			'is_history' => Yii::t('model','studentWorkshop.is_history'),
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	/* public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('user_id',$this->user_id);
		$criteria->compare('post_item_id',$this->post_item_id);
		$criteria->compare('is_history',$this->is_history,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	} */
	public function search($forHistory=FALSE)
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.
	
		$criteria=new CDbCriteria;
	
		$criteria->compare('t.user_id',$this->user_id);
		$criteria->compare('t.post_item_id',$this->post_item_id);
	
		$criteria->with=array('postItem'=>array('together'=>true,'joinType'=>'INNER JOIN','select'=>'is_active, title'),
				'workshop'=>array('together'=>true,'joinType'=>'INNER JOIN','select'=>'start_date, start_time, end_date, end_time'),
		);
	
		if ($forHistory) {
			$criteria->addCondition('ADDTIME(end_date,end_time) <= NOW()');
			$sort=array('defaultOrder'=>'start_date DESC, end_date DESC, start_time DESC, end_time DESC',);
		}else{
			$criteria->addCondition('ADDTIME(end_date,end_time) > NOW()');
			$sort=array('defaultOrder'=>'start_date ASC, end_date ASC, start_time ASC, end_time ASC',);
		}
	
		return $this->relatedSearch(
				$criteria,
				array('sort'=>$sort)
		);
	}
	
	function behaviors() {
		return array(
				'relatedsearch'=>array(
						'class'=>'RelatedSearchBehavior',
						'relations'=>array(
								// Field where search value is different($this->deviceid)
								'is_active'=>array('field'=> 'postItem.is_active','partialMatch'=>false),
								'title'=>'postItem.title',
								'start_date'=>'workshop.start_date',
								'start_time'=>'workshop.start_time',
								'end_date'=>'workshop.end_date',
								'end_time'=>'workshop.end_time',
								// Next line describes a field we do not search,
								// but we define it here for convienience
								//'mylocalreference'=>'field.very.far.away.in.the.relation.tree',
						),
				),
		);
	}
}