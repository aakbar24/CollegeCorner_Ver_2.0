<?php
class DBViewActiveRecord extends CActiveRecord
{
	public function save($runValidation=true,$attributes=null)
	{
		throw CException('save is not available on view.');
	}
	
	public function insert($attributes=null)
	{
		throw CException('insert is not available on view.');
	}
	
	public function update($attributes=null)
	{
		throw CException('update is not available on view.');
	}
	
	public function saveAttributes($attributes)
	{
		throw CException('save is not available on view.');
	}
	
	public function delete()
	{
		throw CException('delete is not available on view.');
	}
	
	public function updateByPk($pk,$attributes,$condition='',$params=array())
	{
		throw CException('update is not available on view.');
	}
	
	public function updateAll($attributes,$condition='',$params=array())
	{
		throw CException('update is not available on view.');
	}
	
	public function deleteByPk($pk,$condition='',$params=array())
	{
		throw CException('delete is not available on view.');
	}
	
	public function deleteAll($condition='',$params=array())
	{
		throw CException('delete is not available on view.');
	}
	
	public function deleteAllByAttributes($attributes,$condition='',$params=array())
	{
		throw CException('delete is not available on view.');
	}
}