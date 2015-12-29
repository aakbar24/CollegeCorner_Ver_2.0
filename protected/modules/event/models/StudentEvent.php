<?php

/**
 * This is the model class for table "{{student_event}}".
 *
 * The followings are the available columns in table '{{student_event}}':
 * @property integer $user_id
 * @property integer $post_item_id
 * @property integer $is_history
 */
class StudentEvent extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return StudentEvent the static model class
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
		return '{{student_event}}';
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
			array('user_id, post_item_id, is_history', 'numerical', 'integerOnly'=>true),
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
			'event'=>array(self::BELONGS_TO, 'Event', 'post_item_id'),
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
			'user_id' => Yii::t('model','studentEvent.user_id'),
			'post_item_id' => Yii::t('model','studentEvent.post_item_id'),
			'is_history' => Yii::t('model','studentEvent.is_history'),
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search($forHistory=FALSE)
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('t.user_id',$this->user_id);
		$criteria->compare('t.post_item_id',$this->post_item_id);

		$criteria->with=array('postItem'=>array('together'=>true,'joinType'=>'INNER JOIN','select'=>'is_active, title'),
				'event'=>array('together'=>true,'joinType'=>'INNER JOIN','select'=>'start_date, start_time, end_date, end_time'),
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
								'start_date'=>'event.start_date',
								'start_time'=>'event.start_time',
								'end_date'=>'event.end_date',
								'end_time'=>'event.end_time',
								// Next line describes a field we do not search,
								// but we define it here for convienience
								//'mylocalreference'=>'field.very.far.away.in.the.relation.tree',
						),
				),
		);
	}
}