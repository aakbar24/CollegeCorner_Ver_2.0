<?php

/**
 * This is the model class for table "{{employer}}".
 *
 * The followings are the available columns in table '{{employer}}':
 * @property integer $user_id
 * @property string $company_name
 * @property string $address
 * @property string $city
 * @property string $province
 * @property string $postal_code
 * @property integer $country_id
 * @property string $phone
 * @property string $ext
 * @property string $website
 *
 * The followings are the available model relations:
 * @property User $user
 * @property Country $country
 * @property FavoriteStudentJobTitle[] $favoriteStudentJobTitles
 * @property InterviewStudentJobTitle[] $interviewStudentJobTitles
 */
class Employer extends CActiveRecord
{
	const USER_GROUP_ID=2;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Employer the static model class
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
		return '{{employer}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('company_name, address, city, province, postal_code, country_id, phone', 'required'),
			array('user_id, country_id', 'numerical', 'integerOnly'=>true),
			array('company_name', 'length', 'max'=>50),
			array('address, website', 'length', 'max'=>100),
			array('city, province, phone', 'length', 'max'=>20),
			array('postal_code', 'length', 'max'=>7),
			array('ext', 'length', 'max'=>5),
			array('website', 'url', 'defaultScheme'=>'http'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('user_id, company_name, address, city, province, postal_code, country_id, phone, ext, website', 'safe', 'on'=>'search'),
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
			'country' => array(self::BELONGS_TO, 'Country', 'country_id'),
			'favoriteStudentJobTitles' => array(self::HAS_MANY, 'FavoriteStudentJobTitle', 'employer_id'),
			'interviewStudentJobTitles' => array(self::HAS_MANY, 'InterviewStudentJobTitle', 'employer_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'user_id' => Yii::t('model', 'employer.user_id'),
			'company_name' => Yii::t('model', 'employer.company_name'),
			'address' => Yii::t('model', 'employer.address'),
			'city' => Yii::t('model', 'employer.city'),
			'province' => Yii::t('model', 'employer.province'),
			'postal_code' => Yii::t('model', 'employer.postal_code'),
			'country_id' => Yii::t('model', 'employer.country_id'),
			'phone' => Yii::t('model', 'employer.phone'),
			'ext' => Yii::t('model', 'employer.ext'),
			'website' => Yii::t('model', 'employer.website'),
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

		$criteria->compare('user_id',$this->user_id);
		$criteria->compare('company_name',$this->company_name,true);
		$criteria->compare('address',$this->address,true);
		$criteria->compare('city',$this->city,true);
		$criteria->compare('province',$this->province,true);
		$criteria->compare('postal_code',$this->postal_code,true);
		$criteria->compare('country_id',$this->country_id);
		$criteria->compare('phone',$this->phone,true);
		$criteria->compare('ext',$this->ext,true);
		$criteria->compare('website',$this->website,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

    public function searchInactive()
    {
        $dataProvider = $this->search();

        $criteria = $dataProvider->criteria;

        $criteria->with = array('user');
        $criteria->compare('is_verified', '0');
        $criteria->order = 'date_created';

        $dataProvider->setCriteria($criteria);

        return $dataProvider;
    }
	
	/**
	 *
	 * Take a saved valid user and save the current employer object to the database.
	 * It calls the default CActiveRecord::save() function.
	 * @see CActiveRecord::save()
	 * @param User $user
	 * @param boolean $runValidation
	 * @param array $attributes
	 *
	 */
	public function save($runValidation=true,$attributes=null,$user=null) {
		if ($this->isNewRecord) 
		{
			if ($user!=null && $user->primaryKey!=null) 
			{
				$this->user_id=$user->primaryKey;
				return parent::save($runValidation,$attributes);
			}
			else 
			{
				throw new CException('A valid user is required');
			}
		}
		else 
		{
			return parent::save($runValidation,$attributes);
		}
	}
	
	/**
	 * Returns the profile navigation sidebar items.
	 */
	public static function getProfileNavItems($controller){
	
		return array(
				array('label'=>'Main Menu'),
				array('label'=>'Browse Resumes', 'icon'=>'eye-open','url'=>array('/resume/employer/index')),
				array('label'=>'Request Workshop', 'icon'=>'wrench','url'=>array('/workshop/workshop/create')),
				array('label'=>'Add Certification', 'icon'=>'certificate','url'=>array('/certificate/certification/create')),
				//array('label'=>'Add Job Title', 'icon'=>'folder-open','url'=>array('#')),
				array('label'=>'My Archive'),
				array('label'=>'My Profile', 'icon'=>'user', 'url'=>array('/account/profile/view')),
				array('label'=>'Hired Students', 'icon'=>'check','url'=>array('/resume/employerHired/index')),
				array('label'=>'Interview List', 'icon'=>'calendar','url'=>array('/resume/employerInterview/index')),
				array('label'=>'Favorite Resumes', 'icon'=>'star','url'=>array('/resume/employerFav/index')),
				array('label'=>'My Workshops', 'icon'=>'wrench','url'=>array('/workshop/workshop/manage'),'active'=>$controller->id=='workshop'&&($controller->getAction()->id=='manage'||$controller->getAction()->id=='update')),
				array('label'=>'My Certifications', 'icon'=>'certificate','url'=>array('/certificate/certification/manage'),'active'=>$controller->id=='certification'&&($controller->getAction()->id=='manage'||$controller->getAction()->id=='update')),
				//array('label'=>'Suggested Job Titles', 'icon'=>'folder-open','url'=>array('#')),
				array('label'=>'User Settings'),
				array('label'=>'Edit Account', 'icon'=>'cog', 'url'=>array('/account/profile/editAccount')),
				array('label'=>'Edit Profile', 'icon'=>'user', 'url'=>array('/account/profile/editProfile')),
		);
	}
	
	/**
	 * Returns the main navigation bar items.
	 */
	public static function getMainNavItems(){
	
		return array(
						array('label'=>Yii::t('view', 'menu.employer_corner_lb'),'url'=>array('/resume/employer/index'),'active'=>false),
						array('label'=>Yii::t('view', 'menu.resume_search_lb'),'url'=>array('/resume/employer/index'),'active'=>false),
						array('label'=>Yii::t('view', 'menu.request_workshop_lb'),'url'=>array('/workshop/workshop/create'),'active'=>false),
				);
	}
	
	public static function getAllEmployers(){
		$dependency=new CDbCacheDependency('SELECT count(e.user_id) FROM tbl_employer e INNER JOIN tbl_user u on u.user_id=e.user_id AND u.is_active="1"');
		return self::model()->with(array('user'=>array('select'=>false,'condition'=>'is_active="1"')))->cache(Yii::app()->params['dbCacheIntervalLong'],$dependency)->findAll('is_active=1');
	}

    public static function notVerifiedText()
    {
        return Yii::t('view', 'employer.not_verified_text') . " <br/><br/> " . CHtml::tag("div", array('class'=>'center-text'), CHtml::link(Yii::t('view', 'support.contact_us.concerns'), array('/site/contact')));
    }

    public static function getAllCompanies(){
        return Yii::app()->db->createCommand()
            ->select('company_name')
            ->from('tbl_employer')
            ->queryColumn();
    }
}
