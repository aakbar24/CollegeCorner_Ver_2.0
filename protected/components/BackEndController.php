<?php

/**
 * The base backend controller
 * @author Wenbin
 *
 */
class BackEndController extends Controller
{
	/**
	 * 
	 * @var string the layout file to use, default to the main layout 
	 */
    public $layout='//layouts/main';
    
    public function filters()
    {
        return array(
            'accessControl',
        );
    }
 
    /**
     * define the access rules for all inheried controller to only allow authorized user to perform any actions
     * @see CController::accessRules()
     */
    public function accessRules()
    {
        return array(
            array('allow',
                'users'=>array('*'),
                'actions'=>array('login','error','captcha'),
            ),
            array('allow',
                'users'=>array('@'),
            	'expression'=>'UserGroup::allowBackendAccess($user->user_group_id)' //only allow authorized user group to access
            ),
            array('deny',
                'users'=>array('*'),
            ),
        );
    }
}

?>