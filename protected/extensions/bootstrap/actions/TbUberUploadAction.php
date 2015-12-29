<?php
/**
 * TbUberUploadAction CAction Component
 *
 *	An action to handle the upload operation for TbUberUploadCropper widget.
 */

Yii::import('bootstrap.components.fineuploader',true);
Yii::import('bootstrap.components.GdImage');
class TbUberUploadAction extends CAction
{
	/**
	 * @var string the name of the model we are going to toggle values to
	 */
	public $modelName;
	
	/**
	 * 
	 * @var string the upload path for the image
	 */
	public $uploadPath;
	
	/**
	 * 
	 * @var array the list of allowed extensions for upload
	 */
	public $allowedExtensions=array('jpeg','jpg','gif','png');
	
	/**
	 * @var long max file size in bytes
	 */
	public $sizeLimit= 2097152;
	
	/**
	 *
	 * @var integer set the width to resize in px during upload, default to 500, it should match with the same field in upload action.
	 */
	public $resizeWidth=400;
	
	/**
	 * Widgets run function
	 * @param integer $id
	 * @param string $attribute
	 * @throws CHttpException
	 */
	public function run()
	{
		if (Yii::app()->getRequest()->isPostRequest)
		{
			if(!file_exists($this->uploadPath))
				throw new CHttpException(Yii::t('zii', 'Invalid upload path'));
			
			$uploader = new qqFileUploader($this->allowedExtensions, $this->sizeLimit);
			$result = $uploader->handleUpload($this->uploadPath, true, session_id());
			
			$gd = new GdImage();
			
			// step 1: make a copy of the original
			$filePath = $this->uploadPath.'/'. $result['filename'];
			$copyName = $gd->createName($result['filename'], '_FULLSIZE');
			$gd->copy($filePath, $this->uploadPath.'/'.$copyName);
			
			// step 2: Scale down or up this image so it fits in the browser nicely, lets say 500px is safe
			$oldSize = $gd->getProperties($filePath);
			if ($oldSize['w']>=$this->resizeWidth) {
				$newSize = $gd->getAspectRatio($oldSize['w'], $oldSize['h'], $this->resizeWidth, 0);
				$gd->resize($filePath, $newSize['w'], $newSize['h']);
			}
			
			echo json_encode($result);
			Yii::app()->end();
		} else
			throw new CHttpException(Yii::t('zii', 'Invalid request'));
	}

}
