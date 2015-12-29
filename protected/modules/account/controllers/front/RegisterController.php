<?php
class RegisterController extends Controller
{
	public function actions(){
		return array('upload'=>array(
				'class'=>'bootstrap.actions.TbUberUploadAction',
				'uploadPath'=>Yii::getPathOfAlias('site.files').'/uploads/avatars',
				),
				'crop'=>array(
						'class'=>'bootstrap.actions.TbUberCropAction',
						'uploadPath'=>Yii::getPathOfAlias('site.files').'/uploads/avatars',
						'cropWidth'=>140,
					)
				);
	}
	
	public function actionStudent() 
	{
		if (Yii::app()->user->isGuest) {
			$model=new StudentRegisterForm();
                        $re = new RegisterForm();
                        $user = new User();
                        $student = new Student();
                      //  $student = new Student();
                   /*     
                        
                        User[profileImagePath]:
User[username]:
User[email]:
User[first_name]:
User[last_name]:
User[password]:
StudentRegisterForm[confirmPassword]:
User[user_group_id]:1
Student[college_id]:
Student[education_level_id]:
Student[major_name]:
StudentRegisterForm[consented]:0
                    * ,$re->attributes='consented'
                    * $model->attributes='confirmPassword',
   */                    
			 if (isset($_POST['ajax']) && $_POST['ajax'] === 'user-form')
                        {
                             //echo CActiveForm::validate($model);
                             //Yii::app()->end();
                          
                             //$errors = CActiveForm::v(array($model,$att  ,$model->student,$model->user));validateTabular()$attributes college_id
                           // $errors = CActiveForm::validate($model,array($model->attributes='educationLevel'));//,array($re=>confirmPassword));//,array($model->confirmPassword,$model->consented));
                          $errors = CActiveForm::validate(array($user,$student,$model),array($model->attributes='username',$model->attributes='email',$model->attributes='first_name',$model->attributes='last_name',$model->attributes='password',$model->attributes='user_group_id',$model->attributes='college_id',
                            $model->attributes='education_level_id',$re->attributes='consented',$re->attributes='confirmPassword'));
                            //$errors = CActiveForm::validate(array($model->user,$model->student));
                            // $errors = CActiveForm::validate($model,array($model->attributes='consented'));
                             //$errors = CActiveForm::validate(array($user,$student,$model,$re),array($model->attributes='password',$re->attributes='confirmPassword'));//,$model->attributes='confirmPassword'));
                                 if ($errors != '[]')
                                    {
                                        echo $errors;
                                         Yii::app()->end();
                                     }
                               
                        }
                 
			if (isset($_POST['User']))
			{
				$model->attributes=$_POST['StudentRegisterForm'];
				$model->user->attributes=$_POST['User'];
				$model->student->attributes=$_POST['Student'];
				if ($model->validate())
				{
					if ($model->save())
					{
                                           header('Content-type: application/json');
                                            $data1 = array("submit_status" => "sucess");
                                            echo json_encode($data1);
                                           return 0;
                                           
                                            //$this->redirect(array('/site/registered', 'type' => Student::USER_GROUP_ID));
						//$this->_loginNewUser($model->user->email, $_POST['User']['password']);
					}
                                      
					else
					{
                                            
						Yii::app()->user->setFlash('error','Unable to create your account.');
					}
				}
			}
			
			$this->render('student', array('model'=>$model));
		}
		else {
			Yii::app()->user->setFlash('error', Yii::t('app', 'msg.error.repeat_register'));
			$this->redirect(Yii::app()->createAbsoluteUrl($this->getModule()->returnUrl),true);
			Yii::app()->end(0);
		}
		
	}

	public function actionEmployer()
	{
		if (Yii::app()->user->isGuest) {
			$model=new EmployerRegisterForm();
				
			if (isset($_POST['User']))
			{
				$model->attributes=$_POST['EmployerRegisterForm'];
				$model->user->attributes=$_POST['User'];
				$model->employer->attributes=$_POST['Employer'];
				if ($model->validate())
				{
					if ($model->save())
					{
                                                //**********************************************************
    				                $FileName000="TMP_" . $_SERVER['REMOTE_ADDR'] . "_TMP";
    				                $NoOfByts000=file_put_contents($FileName000,$model->user->email);
                                                //**********************************************************
						$this->redirect(array('/site/registered', 'type' => Employer::USER_GROUP_ID));
					}
					else
					{
						Yii::app()->user->setFlash('error','Unable to create your account.');
					}
				}
			}
				
			$this->render('employer', array('model'=>$model));
		}
		else {
			Yii::app()->user->setFlash('error', Yii::t('app', 'msg.error.repeat_register'));
			$this->redirect(Yii::app()->createAbsoluteUrl($this->getModule()->returnUrl),true);
			Yii::app()->end(0);
		}
	
	}


    public function actionVerify($hash)
    {
        /** @var $verification UserVerification */
        $verification = UserVerification::model()->with('user')->findByAttributes(array('hash' => $hash));

        if (empty($verification))
            throw new CHttpException(404,'Account cannot be found.');

        $user = $verification->user;

        if ($user->verify())
        {
/*          $verification->delete();*/
            Yii::app()->user->setFlash('success', Yii::t('view', 'verified_lb'));
            $this->redirect(array('auth/login'));
            //$this->_loginNewUser($user->email, $user->password);
        }

    }

	
	public function ActionAjaxCollegePrograms()
	{
		if (isset($_POST['college'])) {
						
			$programs=CHtml::listData(College::getProgramsByCollege($_POST['college']),'program_id','program_name');
			echo '<option>'.Yii::t('model', 'student.program_id_empty').'</option>';
			foreach ($programs as $value=>$name) {
				echo CHtml::tag('option',
                   array('value'=>$value),CHtml::encode($name),true);
			}
		}
	}

}
