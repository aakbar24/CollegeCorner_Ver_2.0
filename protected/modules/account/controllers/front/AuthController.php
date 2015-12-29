<?php

class AuthController extends DefaultAuthController
{
    public $layout = '//layouts/column1';

    public function actionIndex()
    {
        $this->actionLogin();
    }


public function actionLogin()
{
   $model = new LoginForm;
 
    // if it is ajax validation request
    if (isset($_POST['ajax']) && $_POST['ajax'] === 'login-form')
    {
        $errors = CActiveForm::validate($model);
        if ($errors != '[]')
        {
            echo $errors;
            Yii::app()->end();
        }
    }
 
    // collect user input data
    if (isset($_POST['LoginForm']))
    {
        $model->attributes = $_POST['LoginForm'];
        // validate user input and redirect to the previous page if valid
        if ($model->validate() && $model->login())
        {
            if (isset($_POST['ajax']) && $_POST['ajax'] === 'login-form')
            {
                echo CJSON::encode(array(
                    'authenticated' => true,
                    'redirectUrl' => Yii::app()->user->returnUrl
                    //"param" => "Any additional param"
                ));
                Yii::app()->end();
            }
            $this->redirect(Yii::app()->user->returnUrl);
        }
    }
    // display the login form
    $this->render('login', array('model' => $model));
}
   
    
    
    
   protected function performAjaxValidation($model)
{
    if(isset($_POST['ajax']) && $_POST['ajax']==='login-form')
    {
        echo CActiveForm::validate($model);
        Yii::app()->end();
    }
}

    private function _verifyUser()
    {
        if (Yii::app()->user->getState('is_verified') != '1') {
            $isVerified = "Check your e-mail for a verification message";
            if (Yii::app()->user->isEmployer())
                $isVerified = Employer::notVerifiedText();
            else if (Yii::app()->user->isStudent())
                $isVerified = Student::notVerifiedText();

            Yii::app()->user->logout();

           // $model=new LoginForm;

            echo $this->render('application.modules.account.views.common.login', array('model' => $model, 'isVerified' => $isVerified), true);
            Yii::app()->end();
        }
    }

/*    private function _loginNewUser($email, $password){
        $identity=new UserIdentity($email,$password);
        if ($identity->authenticate()===UserIdentity::ERROR_NONE && Yii::app()->user->login($identity)) {

            Yii::app()->user->setFlash('success', sprintf(Yii::t('app', 'msg.welcom_new_register'),Yii::app()->user->name));
            $this->redirect(Yii::app()->createAbsoluteUrl($this->getModule()->returnUrl),true);
            Yii::app()->end(0);
        }
        else{
            throw new CException('Unknown Registration error.' . $identity->errorCode);
        }
    }*/

}