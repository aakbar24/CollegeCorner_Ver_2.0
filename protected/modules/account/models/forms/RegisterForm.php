<?php/** * This model is used as the base registration form. * @author Wenbin * *@property User $user */class RegisterForm extends CFormModel{	public $user;	public $confirmPassword;       //public  $passtest; //$passtest->user->password; //$ret11=$this->user->password;	public $consented;		public function __construct()	{		$this->user=new User();               	}		public function rules()	{//$passtest=$this->user->password;		return array(				array('user','checkUser'),				// confirm password and consented are required				array('confirmPassword, consented', 'required'),                               // array('consented', 'required'),				// censtend needs to be a boolean				array('consented', 'boolean','allowEmpty'=>false),				array('consented','compare','compareValue'=>true,'message'=>'Please read the privacy policy'),				// confirm password needs to be checked against $user->password                              // array('confirmPassword','compare','compareAttribute'=>'passtest','message'=>'Confirm Password does not match the password TEST from user.'),				array('confirmPassword', 'confirmPassword'),										);	}		public function checkUser($attribute,$params)	{		$ret=$this->user->validate();		if (!$ret) {			$this->addErrors($this->user->getErrors());		}	}		public function save()	{		if (!$this->user->hasErrors()) {			return $this->user->save(true,null,false);			}		return false;	}		public function confirmPassword($attribute,$params) {				if (!$this->user->hasErrors('password')) {                    $test = $_POST['User'];                    $ver  = $test['password'];			//if ($this->confirmPassword!==$this->user->password) {                        if ($this->confirmPassword!== $ver) {                               //if ($this->confirmPassword!==user->password) {				$this->addError($attribute,'Confirm Password does not match the password.');			}		}	}		/**	 * Declares attribute labels.	 */	public function attributeLabels()	{		return array(				'confirmPassword'=>Yii::t('model', 'register.confirmpassword'),				'consented'=>Yii::t('model', 'register.consented'). " " . CHtml::link(Yii::t('model', 'register.privacy_policy'), array('/site/page', 'view' => 'policy'), array('target'=>'_blank')) ,		);	}}