<?php
class FileController extends CController
{
	
	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
				'accessControl', // perform access control
		);
	}
	
	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(
				array('allow', 
						'actions'=>array('download'),
						'users'=>array('@'),
                        'expression'=>'$user->isAdmin() || $user->isSuperAdmin()',
				),
				array('deny',  // deny all users
						'users'=>array('*'),
				),
		);
	}
	
	public function actionDownload($name, $id)
	{
		if ($name!==null) {
			$userFilePath=Yii::getPathOfAlias('site.files').'/workshops/' . $id;
			$userFilePath.="/". $name;
			if(!FileHelper::outputFile($name,$userFilePath))
			{
				throw new CHttpException(404,'File not found');
			}
		}
	}
}