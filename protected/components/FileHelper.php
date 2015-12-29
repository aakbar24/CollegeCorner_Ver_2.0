<?php 
class FileHelper extends CFileHelper
{
	public static function getFilePath($path,$createNotExist=true)
	{
		if (!file_exists ($path))
			mkdir ($path, 0775, true);
		
		return $path;
	}
	
	public static function outputFile($name,$filePath,$mimeType =null,$terminate=true)
	{		 
		if (file_exists ($filePath))
		{
			Yii::app()->request->sendFile($name, file_get_contents($filePath),$mimeType,$terminate);
		}
		else
		{
			return false;
		}
	}
}