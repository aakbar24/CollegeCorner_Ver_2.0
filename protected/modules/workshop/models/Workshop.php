<?php

/**
 * This is the model class for table "{{workshop}}".
 *
 * The followings are the available columns in table '{{workshop}}':
 * @property integer $post_item_id
 * @property integer $workshop_cat_id
 * @property integer $workshop_facilitator_id
 * @property string $company
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
 * @property string $website
 * @property string $workshop_file
 * @property string $is_approved
 * @property string $is_active
 * @property string $is_running
 * @property string $workshop_image
 *
 * The followings are the available model relations:
 * @property Student[] $Students
 * @property PostItem $postItem
 * @property WorkshopCat $workshopCat
 * @property WorkshopFacilitator $workshopFacilitator
 * @property Country $country
 */
class Workshop extends CActiveRecord
{
	
	const POST_TYPE=5;
	
	public $employerCompany=null;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Workshop the static model class
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
		return '{{workshop}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('workshop_cat_id, country_id', 'required'),
            array('address, company, emp_user_id, city, province, postal_code, phone, start_date, end_date, start_time, end_time', 'required',  'on'=>'running'),
			array('post_item_id, workshop_cat_id, workshop_facilitator_id, country_id', 'numerical', 'integerOnly'=>true),
			array('company, address, website, workshop_file, workshop_image', 'length', 'max'=>100),
			array('city, province, phone', 'length', 'max'=>20),
			array('postal_code', 'length', 'max'=>7),
			array('ext', 'length', 'max'=>5),
            array('start_date, end_date, start_time, end_time', 'default', 'setOnEmpty' => true, 'value' => null),
			array('end_date','ext.cs-validators.CompareStartEndDates','compare'=>'start_date'),
			array('end_time','ext.cs-validators.CompareStartEndTimes','compare'=>'start_time','startDate'=>'start_date','endDate'=>'end_date'),
			array('is_approved', 'length', 'max'=>1),
            array('is_running', 'length', 'max'=>1),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('userId,title, description, post_item_id, workshop_cat_id, workshop_facilitator_id,is_active, workshop_cat_name, address, city, province, postal_code, country_id, phone, ext, start_date, end_date, start_time, end_time, website, is_approved, is_running, workshop_image', 'safe', 'on'=>'search'),
            array('start_date, end_date, start_time, end_time', 'safe'),
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
			'students' => array(self::MANY_MANY, 'Student', '{{student_workshop}}(post_item_id, user_id)'),
			'postItem' => array(self::BELONGS_TO, 'PostItem', 'post_item_id'),
			'workshopCat' => array(self::BELONGS_TO, 'WorkshopCat', 'workshop_cat_id'),
			'workshopFacilitator' => array(self::BELONGS_TO, 'WorkshopFacilitator', 'workshop_facilitator_id'),
			'country' => array(self::BELONGS_TO, 'Country', 'country_id'),
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
			'post_item_id' => Yii::t('model','workshop.post_item_id'),
			'workshop_cat_id' => Yii::t('model','workshop.workshop_cat_id'),
			'workshop_facilitator_id' => Yii::t('model','workshop.workshop_facilitator_id'),
            'company' => Yii::t('model','workshop.company'),
			'address' => Yii::t('model','workshop.address'),
			'city' => Yii::t('model','workshop.city'),
			'province' => Yii::t('model','workshop.province'),
			'postal_code' => Yii::t('model','workshop.postal_code'),
			'country_id' => Yii::t('model','workshop.country_id'),
			'phone' => Yii::t('model','workshop.phone'),
			'ext' => Yii::t('model','workshop.ext'),
			'start_date' => Yii::t('model','workshop.start_date'),
			'end_date' => Yii::t('model','workshop.end_date'),
			'start_time' => Yii::t('model','workshop.start_time'),
			'end_time' => Yii::t('model','workshop.end_time'),
			'website' => Yii::t('model','workshop.website'),
			'is_approved' => Yii::t('model','workshop.is_approved'),
            'is_running' => Yii::t('model','workshop.is_running'),
			'workshop_image' => Yii::t('model','workshop.workshop_image'),
                        'emp_user_id' => Yii::t('model','workshop.emp_user_id'),
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
		$criteria->compare('t.workshop_cat_id',$this->workshop_cat_id);
		$criteria->compare('t.workshop_facilitator_id',$this->workshop_facilitator_id);
		$criteria->compare('address',$this->address,true);
		$criteria->compare('city',$this->city,true);
		$criteria->compare('province',$this->province,true);
		$criteria->compare('postal_code',$this->postal_code,true);
		$criteria->compare('t.country_id',$this->country_id);
		$criteria->compare('phone',$this->phone,true);
		$criteria->compare('ext',$this->ext,true);
		$criteria->compare('start_date',$this->start_date,true);
		$criteria->compare('end_date',$this->end_date,true);
		$criteria->compare('start_time',$this->start_time,true);
		$criteria->compare('end_time',$this->end_time,true);
		$criteria->compare('website',$this->website,true);
		$criteria->compare('is_approved',$this->is_approved,true);
        $criteria->compare('is_running',$this->is_running,true);
		$criteria->compare('workshop_image',$this->workshop_image,true);

		$criteria->with=array('postItem'=>array('together'=>true,'joinType'=>'INNER JOIN'),
				'workshopCat'=>array('together'=>true,'joinType'=>'INNER JOIN'),
				);
		$sort=array(
				'defaultOrder'=>'is_active DESC, is_approved DESC, is_running DESC, start_date DESC, end_date DESC, start_time DESC, end_time DESC',
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
	
	public static function deleteWorkshopPost($id,$userId=''){
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
								'workshop_cat_name'=>array('field'=>'workshopCat.workshop_cat_name','partialMath'=>false),
								'excerpt'=>'postItem.excerpt',
								'title'=>'postItem.title',
								'description'=>'postItem.description',
								'countryName'=>'country.country_name',
								// Next line describes a field we do not search,
								// but we define it here for convienience
								//'mylocalreference'=>'field.very.far.away.in.the.relation.tree',
						),
				),
		);
	}
	
	public function isHistory(){
        if ($this->end_date != null)
        {
		$endtimestamp=DateTime::createFromFormat("Y-m-d h:i A", $this->end_date.' '.$this->end_time)->getTimestamp();
		return $endtimestamp<=time();
        }
        return false;
	}
	
	public function afterFind(){
		parent::afterFind();

        if ($this->start_time != null && $this->end_time != null)
        {
		$time=DateTime::createFromFormat('G:i:s', $this->start_time);
		$this->start_time=$time->format('h:i A');
		$time=DateTime::createFromFormat('G:i:s', $this->end_time);
		$this->end_time=$time->format('h:i A');
        }
	}
	
	public function beforeSave(){
        if ($this->start_time != null && $this->end_time != null)
        {
		$time=DateTime::createFromFormat('g:i A', $this->start_time);
		$this->start_time=$time->format('G:i');
		$time=DateTime::createFromFormat('g:i A', $this->end_time);
		$this->end_time=$time->format('G:i');
        }
		return parent::beforeSave();
	}
	
	/**
	 * Search for workshops in a range, if the range is not set, defaults to 1 month range.
	 * The results are returned as an array for data feed processing.
	 * @param long $start - start datetime in unix timestamp, default null
	 * @param long $end - end datetime in unix timestamp, default null
	 */
	public function searchWorkshopsForFeed($start=null,$end=null){
		$criteria=new CDbCriteria();
		$criteria->select='t.post_item_id, start_date, start_time, end_date, end_time, title, emp.company_name as employer, emp.user_id as emp_user_id';
		$criteria->with=array('postItem'=>array('together'=>true,'joinType'=>'INNER JOIN','select'=>'title'));
		$criteria->join='INNER JOIN {{post_item}} p ON t.post_item_id=p.post_item_id '.
				'LEFT JOIN {{employer}} emp ON p.user_id=emp.user_id ';
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
		$criteria->compare('t.is_approved', '1');
        $criteria->compare('t.is_running', '1');
		
		$command=Yii::app()->db->getCommandBuilder()->createFindCommand('{{workshop}}', $criteria);
		return $command->queryAll();
	}
	
	public static function getWorkshop($id,$checkApproved=false){
		if (!isset($id)||$id==null) {
			throw new CException('Workshop id is required.');
		}
		
		$criteria=new CDbCriteria();
		$criteria->select.=',emp.company_name AS employerCompany';
		$criteria->with=array('postItem'=>array('together'=>true,'joinType'=>'INNER JOIN'));
		$criteria->join='INNER JOIN {{post_item}} p ON t.post_item_id=p.post_item_id '.
				'LEFT JOIN {{employer}} emp ON p.user_id=emp.user_id ';

		if ($checkApproved==true && !Yii::app()->user->isAdmin() && !Yii::app()->user->isSuperAdmin()&&!Yii::app()->user->isEmployer()) {
			$criteria->compare('t.is_approved', '1');
		}
		
		return self::model()->findByPk($id,$criteria); 
	}

    public static function getLatestWorkshopsSnippet($amount = 5, $userId = null)
    {

        $criteria=new CDbCriteria();
        $criteria->select='t.workshop_id AS id, workshop_cat_name, title, city, DATE_FORMAT(start_date, "%b %d, %Y") AS start_date, DATE_FORMAT(end_date, "%b %d, %Y") AS end_date, DATE_FORMAT(start_time, "%l:%i %p") AS start_time, DATE_FORMAT(end_time, "%l:%i %p") AS end_time, s.user_id AS registered';
        $criteria->limit = $amount;
        $criteria->join = "LEFT JOIN (SELECT user_id, post_item_id FROM tbl_student_workshop WHERE user_id = :userId) s ON s.post_item_id = t.workshop_id";
		$criteria->addCondition('is_approved="1" AND is_active="1"');
        $criteria->addCondition('end_date > DATE(NOW())');
        $criteria->order = 'start_date';

        $criteria->params = array(':userId' => $userId);

        $command = Yii::app()->db->getCommandBuilder()->createFindCommand('v_workshop', $criteria);

        $dataProvider = new CSqlDataProvider($command, array('pagination'=>false,));

        return $dataProvider;
    }

    public static function getUpcomingWorkshops()
    {
        $cmd = Yii::app()->db->createCommand('SELECT COUNT(*) FROM `v_workshop` WHERE is_approved="1" AND is_active="1"');
        $count = $cmd->queryScalar();

        $criteria=new CDbCriteria();
        $criteria->select='t.workshop_id AS id, emp.company_name AS employerCompany, workshop_cat_name, facil_first_name, facil_last_name, facil_image, title, description, company, t.city, DATE_FORMAT(start_date, "%b %e") AS start_date, DATE_FORMAT(end_date, "%b %e") AS end_date, DATE_FORMAT(start_time, "%l:%i %p") AS start_time, DATE_FORMAT(end_time, "%l:%i %p") AS end_time, is_running';

        $criteria->join=
            'LEFT JOIN {{employer}} emp ON t.user_id=emp.user_id ';
        $criteria->addCondition('is_approved="1" AND is_active="1"');
        /*$criteria->addCondition('end_date > DATE(NOW())');*/
        $criteria->order = 'is_running DESC, start_date DESC, title';

        $command = Yii::app()->db->getCommandBuilder()->createFindCommand('v_workshop', $criteria);

        $dataProvider = new CSqlDataProvider($command, array(
            'totalItemCount' => $count,
            'pagination' => array(
                'pageSize' => 10,
            ),
        ));

        return $dataProvider;
    }

    public function generateWorkshopFileUrl()
    {
        if ($this->workshop_file!==null)
        {
            return Yii::app()->createAbsoluteUrl('workshop/file/download',array('name'=>$this->workshop_file, 'id'=>$this->post_item_id));
        }
        return null;

    }

    public function removeFile()
    {
        if (!empty($this->workshop_file))
            unlink(Yii::getPathOfAlias('site.files') . '/workshops/' . $this->primaryKey . "/" . $this->workshop_file);
    }

}
