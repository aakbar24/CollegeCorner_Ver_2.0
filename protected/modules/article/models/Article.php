<?php

/**
 * This is the model class for table "{{article}}".
 *
 * The followings are the available columns in table '{{article}}':
 * @property integer $post_item_id
 * @property string $source
 * @property string $article_image
 *
 * The followings are the available model relations:
 * @property PostItem $postItem
 */
class Article extends CActiveRecord
{

    const POST_TYPE = 1;
    const POST_TYPE_NEWS = 3;
    const IMAGE_PATH = '/files/images/articles/';

    const IMAGE_DEFAULT = 'article_default.png';

    public $title_search;
    public $date_search;

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return Article the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return "{{article}}";
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('post_item_id', 'numerical', 'integerOnly' => true),
            array('source, article_image', 'length', 'max' => 100),
            array('article_image', 'file', 'types' => 'jpg, jpeg, gif, png', 'maxSize' => 1024 * 1024 * 2, 'tooLarge' => 'Images have to be smaller than 2MB', 'allowEmpty' => true),
            array('article_image', 'safe', 'on' => 'insert'),
            array('post_item_id, source, article_image, title_search, date_search', 'safe', 'on' => 'search'),
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
            'user' => array(self::HAS_ONE, 'User', array('user_id' => 'user_id'), 'through' => 'postItem')
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
            'post_item_id' => Yii::t('model', 'article.post_item_id'),
            'source' => 'Source',
            'article_image' => 'Image',
        );
    }

    protected function afterDelete()
    {
        parent::afterDelete();

        $this->removeImage();
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search()
    {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;

        $criteria->with = array('postItem', 'user');
        $criteria->compare('postItem.title', $this->title_search, true);
        $criteria->compare('postItem.date_created', $this->date_search, true);
        $criteria->compare('user.username', $this->post_item_id, true);
        $criteria->compare('article_image', $this->article_image, true);

        if ($this->source == 'No') {
            $criteria->addCondition('source = ""');
        } else if ($this->source == 'Yes') {
            $criteria->addCondition('source != ""');
        }

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria, 'sort' => array(
                'attributes' => array(
                    'title_search' => array(
                        'asc' => 'postItem.title',
                        'desc' => 'postItem.title DESC',
                    ),
                    'date_search' => array(
                        'asc' => 'postItem.date_created',
                        'desc' => 'postItem.date_created DESC',
                    ),
                    '*',
                ),),
        ));
    }

    public function save($runValidation = true, $attributes = null, $postItem = null)
    {

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

    public function getImageSrc()
    {
        if (!empty($this->article_image)) {
            $filePath = Yii::app()->request->baseUrl . self::IMAGE_PATH . $this->article_image . "_" . $this->primaryKey;
            return $filePath;
        }

        return null;
    }

    public static function generateImagePath($article_image = null, $pk = null)
    {
        Yii::log($article_image . " - " . $pk);
        if (!empty($article_image) && !empty($pk)) {
            $filePath = Yii::app()->request->baseUrl . self::IMAGE_PATH . $article_image . "_" . $pk;
            return $filePath;
        }

        return $filePath = Yii::app()->request->baseUrl . self::IMAGE_PATH . self::IMAGE_DEFAULT;
    }

    public function removeImage()
    {
        if (!empty($this->article_image))
            unlink(Yii::app()->basePath . '/../files/images/articles/' . $this->article_image . "_" . $this->getPrimaryKey());
    }

    public function getSource()
    {
        if (!empty($this->source))
            return $this->source;
        else
            return "No Source";
    }

    public static function getArticles()
    {
        $q = "SELECT
        article_id,
	title, 
        DATE_FORMAT(date_created, '%m/%d/%Y %h:%i%p') AS date_created,
	description,
        source,
	username,
        article_image
FROM v_article
ORDER BY date_created DESC; 
";

        $cmd = Yii::app()->db->createCommand($q);
        $threadResult = $cmd->query();

        return $threadResult;
    }

    public static function getBriefArticlesData($limit = null, $post_type = null)
    {

        $count = Yii::app()->db->createCommand('SELECT COUNT(*) FROM v_article')->queryScalar();

        $q = "SELECT
        article_id AS id,
        post_type_id,
	title, 
        DATE_FORMAT(date_created, '%m/%d/%Y %h:%i%p') AS date_created,
	SUBSTRING(description, 1, :size) AS description,
        source,
	username,
        article_image
FROM v_article ";

        if (!empty($post_type))
            $q .= "WHERE post_type_id = " . $post_type . " ";

        $q .= "ORDER BY UNIX_TIMESTAMP(date_created)DESC
                LIMIT :limit";

        $stringSize = Yii::app()->params['article_max_homepage_length'];

        if ($limit == null) {
            $limit = intval($count);
        }

        $dp = new CSqlDataProvider($q, array('pagination' => false, 'totalItemCount' => $count, 'sort' => array(
            'attributes' => array(
                'date_created',
            ), 'class' => 'CSort',
        ),));
        $dp->params = array(':size' => $stringSize, ':limit' => $limit);

        Yii::log(CVarDumper::dumpAsString($dp->getData()));

        return $dp;
    }

    public static function getReadArticleData($id)
    {

        $q = "SELECT
        article_id AS id,
	title,
        DATE_FORMAT(date_created, '%M %d, %h:%i%p') AS date_created,
	description,
        source,
	username,
        article_image
FROM v_article
WHERE article_id = :id
";

        $cmd = Yii::app()->db->createCommand($q);
        $cmd->bindParam(':id', $id, PDO::PARAM_INT);
        return $cmd->queryRow();
    }

}