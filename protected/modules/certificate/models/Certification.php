<?php

/**
 * This is the model class for table "{{certification}}".
 *
 * The followings are the available columns in table '{{certification}}':
 * @property integer $post_item_id
 * @property integer $certification_cat_id
 * @property string $provider
 * @property string $cert_image
 * @property integer $provider_id
 *
 * The followings are the available model relations:
 * @property Employer $provider
 * @property PostItem $postItem
 * @property CertificationCat $certificationCat
 */
class Certification extends CActiveRecord
{
	const POST_TYPE=6;
	const IMAGE_PATH = '/files/images/certifications/';
	const IMAGE_DEFAULT = 'cert_default.png';
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Certification the static model class
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
		return '{{certification}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('certification_cat_id, provider', 'required'),
			array('post_item_id, certification_cat_id, provider_id', 'numerical', 'integerOnly'=>true),
			array('provider, cert_image', 'length', 'max'=>100),
			array('cert_image', 'safe', 'on' => 'insert'),
			array('cert_image', 'file', 'types' => 'jpg, jpeg, gif, png', 'maxSize' => 1024 * 1024 * 2, 'tooLarge' => 'Images have to be smaller than 2MB', 'allowEmpty' => true),
			
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('user_id, title, is_active, description, certification_cat_name, excerpt, post_item_id, certification_cat_id, provider, cert_image, provider_id', 'safe', 'on'=>'search'),
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
			'provider' => array(self::BELONGS_TO, 'Employer', 'provider_id'),
			'postItem' => array(self::BELONGS_TO, 'PostItem', 'post_item_id'),
			'certificationCat' => array(self::BELONGS_TO, 'CertificationCat', 'certification_cat_id'),
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
			'post_item_id' => Yii::t('model','certification.post_item_id'),
			'certification_cat_id' => Yii::t('model','certification.certification_cat_id'),
			'provider' => Yii::t('model','certification.provider'),
			'cert_image' => Yii::t('model','certification.cert_image'),
			'provider_id' => Yii::t('model','certification.provider_id'),
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search($checkActive=false)
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('post_item_id',$this->post_item_id);
		$criteria->compare('t.certification_cat_id',$this->certification_cat_id);
		$criteria->compare('provider',$this->provider,true);
		$criteria->compare('cert_image',$this->cert_image,true);
		$criteria->compare('provider_id',$this->provider_id);
		
		if($checkActive)
			$criteria->compare('postItem.is_active',true);
		
		$criteria->with=array('postItem'=>array('together'=>true,'joinType'=>'INNER JOIN'),
				'certificationCat'=>array('together'=>true,'joinType'=>'INNER JOIN','condition'=>'certificationCat.is_active=1'),
		);

		return $this->relatedSearch(
				$criteria
				//array('pagination'=>array('pageSize'=>2))
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
	
	public function afterValidate(){
		parent::afterValidate();
		if(isset($this->cert_image)&& $this->cert_image!=null){
			
		}
	}
	
	public function getCertImageUrl(){
		if(isset($this->cert_image) && $this->cert_image!=null){
			return Yii::app()->baseUrl.self::IMAGE_PATH.$this->getCertImageName();
		}
		return null;
	}
	
	public function getCertImagePath(){
		if(isset($this->cert_image) && $this->cert_image!=null){
			return Yii::app()->basePath . '/..'.self::IMAGE_PATH.$this->getCertImageName();
		}
		return null;
	}
	
	public function removeCertImage(){
		if(isset($this->cert_image) && $this->cert_image!=null){
			$path=$this->getCertImagePath();
			if(file_exists($path))
				unlink($path);
		}
	}
	
	public function getCertImageName(){
		if(isset($this->cert_image) && $this->cert_image!=null){
			return $this->post_item_id.'-cert-'.$this->cert_image;
		}
		return null;
	}
	
	function behaviors() {
		return array(
				'relatedsearch'=>array(
						'class'=>'RelatedSearchBehavior',
						'relations'=>array(
								// Field where search value is different($this->deviceid)
								'user_id'=>array('field'=> 'postItem.user_id','partialMatch'=>false),
								'is_active'=>array('field'=> 'postItem.is_active','partialMatch'=>false),
								'certification_cat_name'=>array('field'=>'certificationCat.certification_cat_name','partialMath'=>false),
								'excerpt'=>'postItem.excerpt',
								'title'=>'postItem.title',
								'description'=>'postItem.description',
								// Next line describes a field we do not search,
								// but we define it here for convienience
								//'mylocalreference'=>'field.very.far.away.in.the.relation.tree',
						),
				),
		);
	}
	
	public static function deleteCertificationPost($id,$userId=''){
		$criteria=new CDbCriteria();
		$criteria->compare('post_item_id', $id);
		$criteria->compare('user_id', $userId);
		$cmd=Yii::app()->db->commandBuilder->createUpdateCommand('{{post_item}}',array('is_active'=>false), $criteria);
		return $cmd->execute()==1;
	}
	
	public static function getCertification($id,$checkActive=false){
		if (!isset($id)||$id==null) {
			throw new CException('Certification id is required.');
		}
	
		$criteria=new CDbCriteria();
		
		if($checkActive)
			$criteria->compare('postItem.is_active', true);
		
		$criteria->with=array('postItem'=>array('together'=>true,'joinType'=>'INNER JOIN'),'certificationCat'=>array('together'=>true,'joinType'=>'INNER JOIN','condition'=>'certificationCat.is_active=1'),);
		$criteria->join='INNER JOIN {{post_item}} p ON t.post_item_id=p.post_item_id '.
				'LEFT JOIN {{employer}} emp ON t.provider_id=emp.user_id ';
	
		return self::model()->findByPk($id,$criteria);
	}
	
	public static function getAllProviders(){
		$criteria=new CDbCriteria();
		$criteria->distinct=true;
		$criteria->select='provider';
		$command=Yii::app()->db->getCommandBuilder()->createFindCommand('{{certification}}', $criteria);
		return $command->queryAll();
	}
	
}