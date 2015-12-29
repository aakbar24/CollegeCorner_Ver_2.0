<?php

/**
 * This is the model class for table "{{post_item}}".
 *
 * The followings are the available columns in table '{{post_item}}':
 * @property integer $post_item_id
 * @property string $title
 * @property string $description
 * @property integer $post_type_id
 * @property integer $user_id
 * @property string $is_active
 * @property string $date_created
 * @property string $date_updated
 * @property string $excerpt
 *
 * The followings are the available model relations:
 * @property Article $article
 * @property Certification $certification
 * @property Event $event
 * @property News $news
 * @property PostType $postType
 * @property User $user
 * @property Thread $thread
 * @property Workshop $workshop
 */
class PostItem extends CActiveRecord {

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return PostItem the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return '{{post_item}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('title, description', 'required'),
            array('title', 'length', 'max' => 150),
        	array('excerpt', 'length', 'max' => 500),
            array('description', 'filter', 'filter' => array($obj = new CHtmlPurifier(), 'purify')),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('post_type_id', 'safe'),
            array('post_item_id, title, description, excerpt, post_type_id, user_id, is_active, date_created, date_updated', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'article' => array(self::HAS_ONE, 'Article', 'post_item_id'),
            'certification' => array(self::HAS_ONE, 'Certification', 'post_item_id'),
            'event' => array(self::HAS_ONE, 'Event', 'post_item_id'),
            'news' => array(self::HAS_ONE, 'News', 'post_item_id'),
            'postType' => array(self::BELONGS_TO, 'PostType', 'post_type_id'),
            'user' => array(self::BELONGS_TO, 'User', 'user_id'),
            'thread' => array(self::HAS_ONE, 'Thread', 'post_item_id'),
            'workshop' => array(self::HAS_ONE, 'Workshop', 'post_item_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'post_item_id' => 'Post Item',
            'title' => 'Title',
            'description' => 'Description',
            'post_type_id' => 'Post Type',
            'user_id' => 'User',
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

        $criteria->compare('post_item_id', $this->post_item_id);
        $criteria->compare('title', $this->title, true);
        $criteria->compare('description', $this->description, true);
        $criteria->compare('post_type_id', $this->post_type_id);
        $criteria->compare('user_id', $this->user_id);
        $criteria->compare('is_active', $this->is_active, true);
        $criteria->compare('date_created', $this->date_created, true);
        $criteria->compare('date_updated', $this->date_updated, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    public function save($runValidation = true, $attributes = null) {

        if ($this->isNewRecord) {
            $this->user_id = Yii::app()->user->id;
            $this->date_created = new CDbExpression('NOW()');

//            $postMirror = new PostItemSearch();
//            $postMirror->post_item_id = $this->post_item_id;
            
        } else {
            $this->date_updated = new CDbExpression('NOW()');
//            $postMirror = PostItemSearch::model()->findByPk($this->post_item_id);
        }

//        $postMirror->title = $this->title;
//        $postMirror->description = $this->description;
//        $postMirror->save(false);
        //Yii::log(CVarDumper::dumpAsString("The following post was mirrored: " . $postMirror));

        return parent::save($runValidation, $attributes);
    }
    
    protected function afterSave() {
        parent::afterSave();
        
         if ($this->isNewRecord) {
            $postMirror = new PostItemSearch();
            $postMirror->post_item_id = $this->post_item_id;
            
        } else {
            $postMirror = PostItemSearch::model()->findByAttributes(array('post_item_id'=>$this->post_item_id));
        }

        $postMirror->title = $this->title;
        $postMirror->description = $this->description;
        $postMirror->save();
        Yii::log("The following post was mirrored:");
        Yii::log(CVarDumper::dumpAsString($postMirror));
    }

}
