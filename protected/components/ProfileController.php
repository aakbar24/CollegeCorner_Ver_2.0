<?php
/**
 * Controller is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 */
class ProfileController extends Controller
{
	/**
	 * @var string the default layout for the controller view. Defaults to '//layouts/column1',
	 * meaning using a single column layout. See 'protected/views/layouts/column1.php'.
	 */
	public $layout='//layouts/profile';
	
	/**
	 * Valid options are 'icon', 'title', 'backLink', 'subtitle'
	 * @var array - an array which contains list of variables that might be use in displaying the section title. 
	 */
	public $sectionTitle=array();
}