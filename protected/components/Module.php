<?php
/**
 * Base module class derived from CWebModule. It is extended with the flexibility to add dependencies, and provide common view path.
 * @author Wenbin
 *
 */
class Module extends CWebModule
{
	/**
	 * Module denpendencies, specified using path alias.
	 * <p>For example: if we have two modules, A and B. 
	 * <p>Module B requires the models from A, then the dependency will be B.models.*
	 * @var Array - list of all dependencies
	 */
	public $moduleDependencies;
	public $returnUrl;
	
	private $_assetsUrl;
	private $_baseViewPath;
	
	public function init()
	{
		// this method is called when the module is being created
		// you may place code here to customize the module or the application
		
		
		if ($this->_checkModuleDependencies()) {
			// import the module-level models and components
			$this->setImport($this->getModuleImport());
			$this->_baseViewPath=$this->getViewPath().DIRECTORY_SEPARATOR.'common';
			// Raise onModuleCreate event.
			Yii::app()->onModuleCreate(new CEvent($this));
		}
	}
	
	/**
	 * Returns the default list of import alias. Default to [MODULE].models.* and [MODULE].components.*
	 * @return Array - an array of classes to import
	 */
	protected function getModuleImport(){
		$currentModuleName=$this->name;
		return CMap::mergeArray($this->moduleDependencies, array(
					$currentModuleName.'.models.*',
					$currentModuleName.'.components.*',
			));
	}
	
	/**
	 * Checks the module dependencies if specified, otherwise, exception is thrown.
	 * @return boolean true if all dependencies are found or no denpendencies specified
	 * @throws CException
	 */
	private function _checkModuleDependencies(){
		if ($this->moduleDependencies!=null && !empty($this->moduleDependencies)) {
			$msg=array();
			foreach ($this->moduleDependencies as $key=>$dependency){
				if (!Yii::getPathOfAlias($dependency)) {
					$msg[]=$dependency.' is required.';
				}
			}
			if (!empty($msg)) {
				throw new CException(implode(" ",$msg));
			}
			else {
				return true;
			}
		}
		return true;
	}
	
	/**
	 * Handles publishing of the assets (images etc).
	 * @return string URL of assets folder
	 */
	public function getAssetsUrl() {
		if (YII_DEBUG||$this->_assetsUrl === null) {
			$this->_assetsUrl = Yii::app()->getAssetManager()->publish(
					Yii::getPathOfAlias('application.modules.'.$this->name.'.assets'),true,-1,true
			);
		}
		return $this->_assetsUrl;
	}
	
	public function getBaseViewPath()
	{
		return $this->_baseViewPath;
	}
}