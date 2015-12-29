<?php

/**
 * This is the model class for table "{{user}}".
 *
 * The followings are the available columns in table '{{user}}':
 * @property integer $user_id
 * @property string $username
 * @property string $email
 * @property string $first_name
 * @property string $last_name
 * @property string $password
 * @property string $profile_image
 * @property integer $user_group_id
 * @property integer $membership_level_id
 * @property string $is_notify
 * @property string $is_active
 * @property string $is_verified
 * @property string $date_created
 * @property string $date_updated
 *
 * The followings are the available model relations:
 * @property Employer $employer
 * @property PostItem[] $postItems
 * @property Reply[] $replies
 * @property Student $student
 * @property UserGroup $userGroup
 * @property UserVerification $userVerification
 * @property UserStats $userStats
 * @property MembershipLevel $membershipLevel
 * @property CollegeAdmin $collegeAdmin
 */
class User extends CActiveRecord
{
	public $isNewPassword=false;
//public $confirmPassword;
//public $password;
	public $profileImagePath;
    const defaultImage = 'avatar_default.png';

	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return User the static model class
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
		return '{{user}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('username, email, first_name, last_name, password, user_group_id', 'required'),
                  //  array('confirmPassword', 'required'),    
                   // array('confirmPassword', 'safe'),
                      //array('confirmPassword','compare','compareAttribute'=>'password','message'=>'Confirm Password does not match the password TEST from user.'),
			array('user_group_id, membership_level_id', 'numerical', 'integerOnly'=>true),
			array('username', 'length', 'max'=>50),
			array('email', 'length', 'max'=>100),
			array('email', 'email','allowEmpty'=>false),
			array('first_name, last_name', 'length', 'max'=>20),
			array('password', 'length', 'max'=>255),
			array('profile_image', 'length', 'max'=>30),
			array('is_notify, is_active, is_verified', 'length', 'max'=>1),
			array('date_updated', 'safe'),
			array('username, email','unique','allowEmpty'=>false),
			array('profileImagePath','file','allowEmpty'=>true, 'safe'=>true, 'maxSize'=>2097152,'types'=>'gif,png,jpg'),
				
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('user_id, username, userGroupName,email, first_name, last_name, user_group_id, membership_level_id, is_notify, is_active, date_created, date_updated', 'safe', 'on'=>'search'),
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
			'employer' => array(self::HAS_ONE, 'Employer', 'user_id'),
			'postItems' => array(self::HAS_MANY, 'PostItem', 'user_id'),
			'replies' => array(self::HAS_MANY, 'Reply', 'user_id'),
			'student' => array(self::HAS_ONE, 'Student', 'user_id'),
			'userGroup' => array(self::BELONGS_TO, 'UserGroup', 'user_group_id'),
            'userVerification' => array(self::HAS_ONE, 'UserVerification', 'user_id'),
            'userStats' => array(self::HAS_ONE, 'UserStats', 'user_id'),
			'membershipLevel' => array(self::BELONGS_TO, 'MembershipLevel', 'membership_level_id'),
			'collegeAdmin' => array(self::HAS_ONE, 'CollegeAdmin', 'user_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'user_id' => Yii::t('model', 'user.user_id'),
			'username' => Yii::t('model', 'user.username'),
			'email' => Yii::t('model', 'user.email'),
			'first_name' => Yii::t('model', 'user.first_name'),
			'last_name' => Yii::t('model', 'user.last_name'),
			'password' => Yii::t('model', 'user.password'),
			'profile_image' => Yii::t('model', 'user.profile_image'),
			'user_group_id' => Yii::t('model', 'user.user_group_id'),
			'membership_level_id' => Yii::t('model', 'user.membership_level_id'),
			'is_notify' => Yii::t('model', 'user.is_notify'),
			'is_active' => Yii::t('model', 'user.is_active'),
			'date_created' => Yii::t('model', 'user.date_created'),
			'date_updated' => Yii::t('model', 'user.date_updated'),
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
		$criteria->compare('username',$this->username,true);
		$criteria->compare('email',$this->email,true);
		$criteria->compare('first_name',$this->first_name,true);
		$criteria->compare('last_name',$this->last_name,true);
		
		$criteria->compare('profile_image',$this->profile_image,true);
		$criteria->compare('user_group_id',$this->user_group_id);
		$criteria->compare('membership_level_id',$this->membership_level_id);
		$criteria->compare('is_notify',$this->is_notify);
		$criteria->compare('is_active',$this->is_active);
		$criteria->compare('date_created',$this->date_created,true);
		$criteria->compare('date_updated',$this->date_updated,true);
		$criteria->with=array('userGroup'=>array('joinType'=>'INNER JOIN'));
		
		return $this->relatedSearch(
				$criteria
		);
	}
	
	/**
	 * It only updates the password column whenever a new password flag is set to true and the model is not new. 
	 * @see CActiveRecord::save()
	 */
	public function save($runValidation=true,$attributes=null,$transaction=true)
	{
		
		if ($runValidation && !$this->validate($attributes)) {
			return false;
		}
		if ($this->isNewRecord) 
		{
			$this->date_created=new CDbExpression('NOW()');
			if (!$this->hasErrors('password')) {
				$this->password=crypt($this->password, Randomness::blowfishSalt());
			}
		}
		else 
		{
			$this->date_updated=new CDbExpression('NOW()');
			
			if($this->isNewPassword)
			{
				$this->password=crypt($this->password, Randomness::blowfishSalt());
			}
		}
		$saveWithProfileImage=false;
		if ($transaction) {
			$tr=Yii::app()->db->beginTransaction();
			try {
				$saveWithProfileImage=$this->saveWithProfileImage($runValidation,$attributes);
				$tr->commit();
			} catch (Exception $e) {
				$tr->rollback();
				throw $e;
			}
		}else{
			$saveWithProfileImage=$this->saveWithProfileImage($runValidation,$attributes);
		}

		//null indicates there is no profile image uploaded, so we perform a normal save
		if ($saveWithProfileImage==null) {
			return parent::save($runValidation,$attributes);
		}else{
			return $saveWithProfileImage;
		}
		
	}
	
	protected function saveWithProfileImage($runValidation=true,$attributes=null){
		
		if ($this->profileImagePath!=null && $this->profileImagePath!='') {
				if(parent::save($runValidation,$attributes)){
						
					$profileImage=substr($this->profileImagePath, strrpos($this->profileImagePath, '/'));
					$ext=CFileHelper::getExtension($profileImage);
						
					$avatarImageName=$this->primaryKey.'-avatar.'.$ext;
						
					$imageUploadPath=self::getProfileImageUploadPath().$profileImage;
					$imageSavePath=self::getProfileImageSavedPath().'/'.$avatarImageName;
			
					if (!copy($imageUploadPath, $imageSavePath)) {
						$this->addError('profileImagePath', 'Unable to save the profile image.');
						unlink($imageUploadPath);
						return false;
					}else{
						$this->profile_image=$avatarImageName;
					}
					if(parent::save($runValidation,$attributes)){
						unlink($imageUploadPath);
						return true;
					}
				}
				return false;
		}else{
			return null;
		}
	}
	
	/**
	 * It persists user account info and it can take either a CWebuser or UserIdentity instance.
	 * @param mixed $userSession - it can be either an instance of CWebUser or UserIdentity depends on the isWebUser flag
	 * @param boolean $isWebUser - indicates whehter the $userSession is an instance of CWebUser
	 */
	public function setState($userSession,$isWebUser=false)
	{
		if (isset($userSession) && ($userSession instanceof UserIdentity || $userSession instanceof CWebUser)) 
		{
			if (($isWebUser==true && !$userSession->isGuest)||
					($isWebUser==false && isset($userSession->errorCode) && $userSession->errorCode===UserIdentity::ERROR_NONE)) 
			{
				$userSession->setState('email', $this->email);
				$userSession->setState('username', $this->username);
				$userSession->setState('first_name', $this->first_name);
				$userSession->setState('last_name', $this->last_name);
				$userSession->setState('profile_image', $this->profile_image);
				$userSession->setState('user_group_id', $this->user_group_id);
				$userSession->setState('user_group_name', $this->userGroup->user_group_name);
				$userSession->setState('membership_level_id',$this->membership_level_id);
				$userSession->setState('is_notify',$this->is_notify);
                $userSession->setState('is_verified',$this->is_verified);
			}	
		}
	}
	
	public function getName(){
		return $this->first_name." ".$this->last_name;
	}
	
	public function getProfileImageUrl(){
		return Yii::app()->baseUrl.'/files/images/avatars/'.$this->profile_image;
	}
	
	function behaviors() {
		return array(
				'relatedsearch'=>array(
						'class'=>'RelatedSearchBehavior',
						'relations'=>array(
								// Field where search value is different($this->deviceid)
								'userGroupName'=>'userGroup.user_group_name'
	
								// Next line describes a field we do not search,
								// but we define it here for convienience
								//'mylocalreference'=>'field.very.far.away.in.the.relation.tree',
						),
				),
		);
	}
	
	public function delete(){
		if ($this->isNewRecord) {
			throw new CException("Cannot delete a new record");
		}
		
		$this->is_active='0'; //virtually delete it
		return $this->save();
	}

    public function verify()
    {
        if ($this->is_verified == '1')
            throw new CHttpException(404,'Account has already been activated.');

        $this->is_verified = 1;
        return $this->save(false) ? true : false;
    }
	
	public static function getProfileImageUploadPath(){
		return Yii::getPathOfAlias('site.files').'/uploads/avatars';
	}
	
	public static function getProfileImageSavedPath(){
		return Yii::getPathOfAlias('site.files').'/images/avatars';
	}

    public static function getProfileImageUploadUrl(){
        return Yii::app()->baseUrl.'/files/images/avatars/';
    }

    public static function increaseLoginCount($userId)
    {
    $userStats = UserStats::model()->findByPk($userId);
    if (empty($userStats))
    {
        $userStats = new UserStats();
        $userStats->user_id = $userId;
        $userStats->num_logins = 1;
        $userStats->save(false);
        return false;
    }
        else{
            /** @var $userStats UserStats */
            $userStats->num_logins++;
            $userStats->save(false);
            return true;
        }

    }

}