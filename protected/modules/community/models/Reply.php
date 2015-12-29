<?php

/**
 * This is the model class for table "{{reply}}".
 *
 * The followings are the available columns in table '{{reply}}':
 * @property integer $reply_id
 * @property integer $post_item_id
 * @property string $message
 * @property integer $user_id
 * @property integer $child_reply
 * @property string $is_active
 * @property string $date_created
 * @property string $date_updated
 *
 * The followings are the available model relations:
 * @property Thread $postItem
 * @property User $user
 * @property Reply $childReply
 * @property Reply[] $replies
 */
class Reply extends CActiveRecord {

    

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return Reply the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return '{{reply}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('message', 'required'),
            array('child_reply,', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('reply_id, post_item_id, message, user_id, child_reply, is_active, date_created, date_updated', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'postItem' => array(self::BELONGS_TO, 'Thread', 'post_item_id'),
            'user' => array(self::BELONGS_TO, 'User', 'user_id'),
            'childReply' => array(self::BELONGS_TO, 'Reply', 'child_reply'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'reply_id' => 'Reply',
            'post_item_id' => 'Post Item',
            'message' => 'Message',
            'user_id' => 'User',
            'child_reply' => 'Child Reply',
            'is_active' => 'Is Active',
            'date_created' => 'Date Created',
            'date_updated' => 'Date Updated',
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('reply_id', $this->reply_id);
        $criteria->compare('post_item_id', $this->post_item_id);
        $criteria->compare('message', $this->message, true);
        $criteria->compare('user_id', $this->user_id);
        $criteria->compare('child_reply', $this->child_reply);
        $criteria->compare('is_active', $this->is_active, true);
        $criteria->compare('date_created', $this->date_created, true);
        $criteria->compare('date_updated', $this->date_updated, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    public function save($runValidation = true, $attributes = null) {
  
        if (!$this->post_item_id)
            return false;

        if ($this->isNewRecord) {
            $this->user_id = Yii::app()->user->id;
            $this->date_created = new CDbExpression('NOW()');
        } else {
            $this->date_updated = new CDbExpression('NOW()');
        }

        return parent::save($runValidation, $attributes);
    }
    
    public static function getChildReplyPosting($id)
    {
        $q = "SELECT message, tbl_reply.user_id, tbl_reply.is_active, username, tbl_user.user_group_id , profile_image
FROM tbl_reply
INNER JOIN tbl_user ON tbl_reply.user_id = tbl_user.user_id
WHERE reply_id =:replyId";
        
        $cmd = Yii::app()->db->createCommand($q);
        $cmd->bindParam(':replyId', $id, PDO::PARAM_INT);
        $replyResult = $cmd->queryRow();

        return $replyResult;
    }

}