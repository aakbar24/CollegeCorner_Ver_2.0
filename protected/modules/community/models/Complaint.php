<?php

/**
 * This is the model class for table "{{complaint}}".
 *
 * The followings are the available columns in table '{{complaint}}':
 * @property integer $complaint_id
 * @property integer $post_item_id
 * @property integer $reply_id
 * @property integer $user_id
 * @property string $reason
 * @property string $date_created
 *
 * The followings are the available model relations:
 * @property User $user
 * @property PostItem $postItem
 */
class Complaint extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Complaint the static model class
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
		return '{{complaint}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('post_item_id, user_id, reply_id', 'numerical', 'integerOnly'=>true),
                        array('reason', 'required', 'on'=>'postComplaint', 'message' => 'Please provide a reason for your complaint.'),
                    
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
                        array('complaint_id, post_item_id, user_id, reply_id, date_created', 'safe', 'on'=>'postComplaint'),
			array('complaint_id, post_item_id, user_id, reason, date_created', 'safe', 'on'=>'search'),
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
			'postItem' => array(self::BELONGS_TO, 'PostItem', 'post_item_id'),
                        'reply' => array(self::BELONGS_TO, 'Reply', 'reply_id')
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
			'reason' => Yii::t('model','complaint.reason'),
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search( $distinct = false, $thread_id = null)
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
                
                $criteria->with = array('postItem', 'user', 'reply');
                
                if ($distinct)
                {
                    $criteria->addCondition('postItem.is_active = 1');
                    $criteria->group = 't.post_item_id';
                }
                
                if ($thread_id != null) {
            $criteria->addCondition('t.post_item_id = :thread_id');
            $criteria->params[':thread_id'] = $thread_id;
        }

		$criteria->compare('complaint_id',$this->complaint_id);
		$criteria->compare('post_item_id',$this->post_item_id);
		$criteria->compare('user_id',$this->user_id);
		$criteria->compare('reason',$this->reason,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
         public function save($runValidation = true, $attributes = null) {

        if ($this->isNewRecord) {
            $this->date_created = new CDbExpression('NOW()');
        }
        
        return parent::save($runValidation, $attributes);
    }
        
}