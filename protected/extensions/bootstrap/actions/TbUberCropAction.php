<?php
/**
 * TbUberUploadAction CAction Component
 *
 *	An action to handle the upload operation for TbUberUploadCropper widget.
 */

Yii::import('bootstrap.components.GdImage');
class TbUberCropAction extends CAction
{
	/**
	 * 
	 * @var string the upload path for the image
	 */
	public $uploadPath;
	
	/**
	 * 
	 * @var integer set the width to resize in px during upload, default to 500, it should match with the same field in upload action.
	 */
	public $resizeWidth=400;
	
	/**
	 *
	 * @var integer set the width to crop in px, default to 200, it should match with the same field in upload action.
	 */
	public $cropWidth=200;
	
	/**
	 * Widgets run function
	 * @throws CHttpException
	 */
	public function run()
	{
		if (Yii::app()->getRequest()->isPostRequest)
		{
			if(!file_exists($this->uploadPath))
				throw new CHttpException(Yii::t('zii', 'Invalid upload path'));
			
			$gd=new GdImage();
			foreach($_POST['imgcrop'] as $k => $v) {
								
				// 1) delete resized, move to full size
				$filePath = $this->uploadPath.'/'. $v['filename'];
				$fullSizeFilePath = $this->uploadPath.'/'. $gd->createName($v['filename'], '_FULLSIZE');
				unlink($filePath);
				rename($fullSizeFilePath, $filePath);
				
				// 2) compute the new coordinates
				$scaledSize = $gd->getProperties($filePath);
				if ($scaledSize['w']>=$this->resizeWidth) {
					$percentChange = $scaledSize['w'] / $this->resizeWidth; // we know we scaled by width of px in upload
				}else{
					$percentChange = 1;
				}
				
				$newCoords = array(
						'x' => $v['x'] * $percentChange,
						'y' => $v['y'] * $percentChange,
						'w' => $v['w'] * $percentChange,
						'h' => $v['h'] * $percentChange
				);
				
				// 3) crop the full size image
				$gd->crop($filePath, $newCoords['x'], $newCoords['y'], $newCoords['w'], $newCoords['h']);
				
				// 4) resize the cropped image to whatever size we need (lets go with 200 wide)
				$ar = $gd->getAspectRatio($newCoords['w'], $newCoords['h'], $this->cropWidth, 0);
				$gd->resize($filePath, $ar['w'], $ar['h']);
			}
			
			echo '1';
			Yii::app()->end();
		} else
			throw new CHttpException(Yii::t('zii', 'Invalid request'));
	}

}
