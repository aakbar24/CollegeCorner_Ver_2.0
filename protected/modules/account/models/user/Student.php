<?php

/**
 * This is the model class for table "{{student}}".
 *
 * The followings are the available columns in table '{{student}}':
 * @property integer $user_id
 * @property integer $college_id
 * @property integer $program_id
 * @property integer $education_level_id
 * @property string $program_code
 * @property string $major_name
 * @property string $enrollment_date
 * @property string $about_me
 *
 * The followings are the available model relations:
 * @property User $user
 * @property EducationLevel $educationLevel
 * @property College $college
 * @property Program $program
 * @property JobTitle[] $jobTitles
 * @property StudentJobTitle[] $studentJobTitles
 * @property Workshop[] $workshops
 */
class Student extends CActiveRecord
{
	const USER_GROUP_ID=1;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Student the static model class
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
		return '{{student}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
            //Temporary comment to remove program name require error at 24/05/2014
			//array('college_id, program_id, education_level_id', 'required'),
            array('college_id, education_level_id', 'required'),
			array('user_id, college_id, program_id, education_level_id', 'numerical', 'integerOnly'=>true),
			array('program_code', 'length', 'max'=>20),
			array('major_name', 'length', 'max'=>80),
			array('about_me', 'length', 'max'=>200),
			array('enrollment_date', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('user_id, college_id, program_id, education_level_id, program_code, major_name, enrollment_date, about_me', 'safe', 'on'=>'search'),
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
			'educationLevel' => array(self::BELONGS_TO, 'EducationLevel', 'education_level_id'),
			'college' => array(self::BELONGS_TO, 'College', 'college_id'),
			'program' => array(self::BELONGS_TO, 'Program', 'program_id'),
			'jobTitles' => array(self::MANY_MANY, 'JobTitle', '{{student_job_title}}(user_id, job_title_id)'),
			'studentJobTitles' => array(self::HAS_MANY, 'StudentJobTitle', 'user_id'),
			'workshops' => array(self::MANY_MANY, 'Workshop', '{{student_workshop}}(user_id, post_item_id)'),
			'events' => array(self::MANY_MANY, 'Event', '{{student_event}}(user_id, post_item_id)'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			//'user_id' => 'User',
			'college_id' => Yii::t('model', 'student.college_id'),
			'program_id' => Yii::t('model', 'student.program_id'),
			'education_level_id' => Yii::t('model', 'student.education_level_id'),
			'program_code' => Yii::t('model', 'student.program_code'),
			'major_name' => Yii::t('model', 'student.major_name'),
			'enrollment_date' => Yii::t('model', 'student.enrollment_date'),
			'about_me' => Yii::t('model', 'student.about_me'),
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
		$criteria->compare('college_id',$this->college_id);
		$criteria->compare('program_id',$this->program_id);
		$criteria->compare('education_level_id',$this->education_level_id);
		$criteria->compare('program_code',$this->program_code,true);
		$criteria->compare('major_name',$this->major_name,true);
		$criteria->compare('enrollment_date',$this->enrollment_date,true);
		$criteria->compare('about_me',$this->about_me,true);

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
	 * Searches the last job title posted and in its job category. 
	 * @return CArrayDataProvider - the results in an array data provider
	 */
	/* public function searchLatestJobTitles()
	{
		$dbc=Yii::app()->db->createCommand();
		$dbc->selectDistinct('t.job_cat_id,jt.*, count(jt.job_title_id) as count, c.job_cat_name')->
		from('{{job_title}} t')->
		join(
				'(SELECT job_title_id,user_id,date_created FROM {{student_job_title}} ORDER BY date_created DESC) jt', 
				't.job_title_id=jt.job_title_id AND jt.user_id=:user_id',
				array(':user_id'=>$this->user_id)
		)->
		join('{{job_cat}} c','c.job_cat_id=t.job_cat_id')->
		group('t.job_cat_id');
		
		$dbc->prepare();
		$rawData=$dbc->queryAll(true);
		return new CArrayDataProvider($rawData,
				array(
						
						'keyField'=>'job_cat_id',
						
						'id'=>'job_cat_id',
						'sort'=>array(
								'attributes'=>array(
										'job_cat_name',
										'count',
										'date_created',
										)
								
								),
						));
	} */
	
	/**
	 * Searches all the job titles applied by the current student in the selected category.
	 * @param integer $jobCat - the selected job category
	 */
	/* public function searchStudentJobsByCat($jobCat)
	{
		$criteria=new CDbCriteria;
		$criteria->with=array(
				'jobTitles'=>array('condition'=> 'jobTitles.job_cat_id=:jobCat','params'=>array(':jobCat'=>$jobCat)),
				);
		//$this->query($criteria);
		return new CActiveDataProvider($this,array('criteria'=>$criteria));
	} */
	
	/**
	 * 
	 * Takes a saved valid user and save the current student object to the database.
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
				array('label'=>'Main Manu'),
				array('label'=>'Post Resume', 'icon'=>'folder-open', 'url'=>array('/resume/resumePost/post')),
				array('label'=>'View Workshops', 'icon'=>'pencil', 'url'=>array('/workshop/workshop/index')),
				array('label'=>'Student Community', 'icon'=>'home', 'url'=>array('/community/forum/index')),

				array('label'=>'My Archive'),
				array('label'=>'My Profile', 'icon'=>'user', 'url'=>array('/account/profile/view')),
				array('label'=>'My Resumes', 'icon'=>'folder-open', 'url'=>array('/resume/resumePost/index'),'active'=>$controller->id=='resumePost'&&$controller->getAction()->id!='post'),
			array('label'=>'My InterviewshghTest', 'icon'=>'calendar', 'label2'=>'pop','url'=>array('/resume/studentInterview/index'),),
				array('label'=>'Hiring History', 'icon'=>'check', 'url'=>array('/resume/studentHired/index'),),
				array('label'=>'My Events', 'icon'=>'flag', 'url'=>array('/event/studentEvent/index'),'active'=>$controller->id=='studentEvent'),
				array('label'=>'My Workshops', 'icon'=>'wrench', 'url'=>array('/workshop/studentWorkshop/index'),'active'=>$controller->id=='studentWorkshop'),
				array('label'=>'Today\'s Topics', 'icon'=>'th-list', 'url'=>array('/community/forum/todaysTopics')),
				array('label'=>'My Topics', 'icon'=>'comment', 'url'=>array('/community/forum/myTopics')),
				array('label'=>'Latest Replies', 'icon'=>'share', 'url'=>array('/community/forum/latestReplies')),
				
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
				array('label'=>Yii::t('view', 'menu.student_corner_lb'),'url'=>array('/account/profile/index'),'active'=>false),
				array('label'=>Yii::t('view', 'menu.resume_lb'),'url'=>array('/resume/resumePost/post'),'active'=>false),
				array('label'=>Yii::t('view', 'menu.workshop_lb'),'url'=>array('/workshop/workshop/index'),'active'=>false),
				array('label'=>Yii::t('view', 'menu.community_lb'),'url'=>array('/community/forum/index'),'active'=>false),
		);
	}

    public static function notVerifiedText()
    {
        return Yii::t('view', 'student.not_verified_text') . " <br/><br/> " . CHtml::tag("div", array('class'=>'center-text'), CHtml::link(Yii::t('view', 'support.contact_us.concerns'), array('/site/contact')));
    }
}
?>