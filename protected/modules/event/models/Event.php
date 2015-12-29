<?php

/**
 * This is the model class for table "{{event}}".
 *
 * The followings are the available columns in table '{{event}}':
 * @property integer $post_item_id
 * @property string $address
 * @property string $city
 * @property string $province
 * @property string $postal_code
 * @property integer $country_id
 * @property string $phone
 * @property string $ext
 * @property string $start_date
 * @property string $end_date
 * @property string $start_time
 * @property string $end_time
 * @property string $event_image
 * @property integer $college_id
 * @property string $excerpt
 *
 * The followings are the available model relations:
 * @property College $college
 * @property PostItem $postItem
 * @property Student[] $tblStudents
 */
class Event extends CActiveRecord
{
	const POST_TYPE=2;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Event the static model class
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
		return '{{event}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('address, city, province, postal_code, country_id, phone, start_date, end_date, start_time, end_time', 'required'),
			array('post_item_id, country_id, college_id', 'numerical', 'integerOnly'=>true),
			array('address, event_image', 'length', 'max'=>100),
			array('city, province, phone', 'length', 'max'=>20),
			array('postal_code', 'length', 'max'=>7),
			array('ext', 'length', 'max'=>5),
			array('end_date','ext.cs-validators.CompareStartEndDates','compare'=>'start_date'),
			array('end_time','ext.cs-validators.CompareStartEndTimes','compare'=>'start_time','startDate'=>'start_date','endDate'=>'end_date'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('userId, excerpt, is_active, title, description, collegeName, post_item_id, address, city, province, postal_code, country_id, phone, ext, start_date, end_date, start_time, end_time, college_id', 'safe', 'on'=>'search'),
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
			'postItem' => array(self::BELONGS_TO, 'PostItem', 'post_item_id'),
			'country' => array(self::BELONGS_TO, 'Country', 'country_id'),
			'students' => array(self::MANY_MANY, 'Student', '{{student_event}}(post_item_id, user_id)'),
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
			'post_item_id' => Yii::t('model','event.post_item_id'),
			'address' => Yii::t('model','event.address'),
			'city' => Yii::t('model','event.city'),
			'province' => Yii::t('model','event.province'),
			'postal_code' => Yii::t('model','event.postal_code'),
			'country_id' => Yii::t('model','event.country_id'),
			'phone' => Yii::t('model','event.phone'),
			'ext' => Yii::t('model','event.ext'),
			'start_date' => Yii::t('model','event.start_date'),
			'end_date' => Yii::t('model','event.end_date'),
			'start_time' => Yii::t('model','event.start_time'),
			'end_time' => Yii::t('model','event.end_time'),
			'event_image' => Yii::t('model','event.event_image'),
			'college_id' => Yii::t('model','event.college_id'),
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

		$criteria->compare('t.post_item_id',$this->post_item_id);
		$criteria->compare('address',$this->address,true);
		$criteria->compare('city',$this->city,true);
		$criteria->compare('province',$this->province,true);
		$criteria->compare('postal_code',$this->postal_code,true);
		$criteria->compare('country_id',$this->country_id);
		$criteria->compare('phone',$this->phone,true);
		$criteria->compare('ext',$this->ext,true);
		$criteria->compare('start_date',$this->start_date,true);
		$criteria->compare('end_date',$this->end_date,true);
		$criteria->compare('start_time',$this->start_time,true);
		$criteria->compare('end_time',$this->end_time,true);
		$criteria->compare('college_id',$this->college_id);
		
		$criteria->with=array('postItem'=>array('together'=>true,'joinType'=>'INNER JOIN'));
		$sort=array(
				'defaultOrder'=>'start_date DESC, end_date DESC, start_time DESC, end_time DESC',
				);
		return $this->relatedSearch(
				$criteria,
				array('sort'=>$sort)
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
		
	public static function deleteEventPost($id,$userId=''){
		$criteria=new CDbCriteria();
		$criteria->compare('post_item_id', $id);
		$criteria->compare('user_id', $userId);
		$cmd=Yii::app()->db->commandBuilder->createUpdateCommand('{{post_item}}',array('is_active'=>false), $criteria);
		return $cmd->execute()==1;
	}
	
	function behaviors() {
		return array(
				'relatedsearch'=>array(
						'class'=>'RelatedSearchBehavior',
						'relations'=>array(
								// Field where search value is different($this->deviceid)
								'userId'=>array('field'=> 'postItem.user_id','partialMatch'=>false),
								'is_active'=>array('field'=> 'postItem.is_active','partialMatch'=>false),
								'excerpt'=>'postItem.excerpt',
								'title'=>'postItem.title',
								'description'=>'postItem.description',
								'collegeName'=>'college.college_name',
								'countryName'=>'country.country_name',
								// Next line describes a field we do not search,
								// but we define it here for convienience
								//'mylocalreference'=>'field.very.far.away.in.the.relation.tree',
						),
				),
		);
	}
	
	public function isPublic(){
		return $this->college_id=='' || $this->college_id==null;
	}
	
	public function getSignupType(){
		return $this->isPublic()?'Public':"Restricted<br/>({$this->collegeName})";
	}
	
	/**
	 * Search for events in a range, if the range is not set, defaults to 1 month range.
	 * The results are returned as an array for data feed processing.
	 * @param long $start - start datetime in unix timestampe, default null
	 * @param long $end - end datetime in unix timestampe, default null
	 */
	public function searchEventsForFeed($collegeId,$start=null,$end=null){
		$criteria=new CDbCriteria();
		$criteria->select='t.post_item_id, start_date, start_time, end_date, end_time, event_text_color, event_background_color, title, college_name';
		$criteria->with=array('postItem'=>array('together'=>true,'joinType'=>'INNER JOIN','select'=>'title'));
		$criteria->join='INNER JOIN {{post_item}} p ON t.post_item_id=p.post_item_id '.
		'LEFT JOIN {{college_details}} cd ON t.college_id=cd.college_id '.
		'LEFT JOIN {{college}} c ON t.college_id=c.college_id';
		//$criteria->with=array('college.collegeDetails'=>array('together'=>true,'select'=>'event_background_color,event_text_color,college_name'));
		
		if ($start!=null && $end!=null) {
			$start=date('Y-m-d',$start);
			$end=date('Y-m-d',$end);
		}else{
			$start=date('Y-m-d',strtotime('first day'));
			$end=date('Y-m-d',strtotime('last day'));
		}
		
		$criteria->addBetweenCondition('ADDTIME(start_date,start_time)', $start, $end)->
		addBetweenCondition('ADDTIME(end_date,end_time)', $start, $end,'OR');
		$criteria->compare('p.is_active', '1');
		$criteria->addCondition('t.college_id IS NULL');
		if ($collegeId!=null) {
			$criteria->compare('t.college_id', $collegeId,false,'OR');
		}
		$command=Yii::app()->db->getCommandBuilder()->createFindCommand('{{event}}', $criteria);
		return $command->queryAll();
	}
	
	public function isHistory(){
		$endtimestamp=DateTime::createFromFormat("Y-m-d h:i A", $this->end_date.' '.$this->end_time)->getTimestamp();
		return $endtimestamp<=time();
	}
	
	public function afterFind(){
		parent::afterFind();
		$time=DateTime::createFromFormat('G:i:s', $this->start_time);
		$this->start_time=$time->format('h:i A');
		$time=DateTime::createFromFormat('G:i:s', $this->end_time);
		$this->end_time=$time->format('h:i A');
	}
	
	public function beforeSave(){
		$time=DateTime::createFromFormat('g:i A', $this->start_time);
		$this->start_time=$time->format('G:i');
		$time=DateTime::createFromFormat('g:i A', $this->end_time);
		$this->end_time=$time->format('G:i');
		return parent::beforeSave();
                //return true;
	}
	
	public static function getEvent($id){
		if(Yii::app()->user->isGuest || Yii::app()->user->user_group_id==Student::USER_GROUP_ID){
			return Event::model()->with(
					array(
							'country',
							'postItem'=>array('condition'=>'is_active="1"')
							)
					)->together()->findByPk($id);
		}
		else if (Yii::app()->user->isAdmin() || Yii::app()->user->isSuperAdmin() ) {
			return Event::model()->with(
					array(
							'postItem',
							'country',
							'postItem.user'=>array(
									'select'=>'user_group_id',
									'joinType'=>'INNER JOIN'
							)
					)
			)->together()->findByPk($id);
		}else if(Yii::app()->user->isCollegeAdmin()){
			return Event::model()->with('country','postItem')->together()->
			findByPk($id,'postItem.user_id=:user_id',array(':user_id'=>Yii::app()->user->id));
		}
	}

    public static function getLatestEventsSnippet($amount = 5, $collegeId = null)
    {

        $criteria=new CDbCriteria();
        $criteria->select='t.post_item_id AS id, city, title, city, DATE_FORMAT(start_date, "%b %d, %Y") AS start_date, DATE_FORMAT(end_date, "%b %d, %Y") AS end_date, DATE_FORMAT(start_time, "%l:%i %p") AS start_time, DATE_FORMAT(end_time, "%l:%i %p") AS end_time';
        $criteria->join = 'INNER JOIN {{post_item}} p ON t.post_item_id=p.post_item_id';
        $criteria->limit = $amount;
        $criteria->addCondition('end_date > DATE(NOW())');
        $criteria->addCondition('is_active="1"');
        if (!empty($collegeId))
        {
            $criteria->addCondition('college_id = :collegeId OR college_id IS NULL');
            $criteria->params = array(':collegeId' => $collegeId);
        }
        else
            $criteria->addCondition('college_id IS NULL');

        $criteria->order = "start_date";

        $command = Yii::app()->db->getCommandBuilder()->createFindCommand('{{event}}', $criteria);

        $dataProvider = new CSqlDataProvider($command, array('pagination'=>false,));

        Yii::log(CVarDumper::dumpAsString($command->text));

        return $dataProvider;
    }
	
}