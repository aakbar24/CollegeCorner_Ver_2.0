<?php
/**
 * TbTagit widget class file. It generates a text input field that uses the tagit jquery library.
 * @license http://www.opensource.org/licenses/bsd-license.php New BSD License
 * @package bootstrap.widgets
 * @author Wenbin
 *
 */
class TbTagit extends CInputWidget
{
	/**
	 * The bootstrap active form instance.
	 * @var TbActiveForm
	 */
	public $form;
	
	/**
	 * @var string[] the JavaScript event handlers.
	 */
	public $events = array();
	
	/**
	 * The tagit javascript options
	 * @var array
	 */
	public $options;
	
		
	/**
	 * Runs the widget.
	 */
	public function run()
	{
		list($name, $id) = $this->resolveNameID();
	
		if ($this->hasModel())
		{
			if($this->form)
				echo $this->form->textField($this->model, $this->attribute, $this->htmlOptions);
			else
				echo CHtml::activeTextField($this->model, $this->attribute, $this->htmlOptions);
	
		} else
			echo CHtml::textField($name, $this->attribute, $this->htmlOptions);
	
		$this->registerClientScript($id);
	}
	
	/**
	 * Registers required client script for tagit. It is not used through bootstrap->registerPlugin
	 * in order to attach events if any
	 */
	public function registerClientScript($id)
	{
		Yii::app()->bootstrap->registerAssetCss('jquery.tagit.css');
		Yii::app()->clientScript->registerCoreScript('jquery.ui');
		Yii::app()->bootstrap->registerAssetJs('tag-it.min.js');
	
		$options = !empty($this->options) ? CJavaScript::encode($this->options) : '';
	
		ob_start();
		echo "jQuery('#{$id}').tagit({$options})";
		foreach ($this->events as $event => $handler)
			echo ".on('{$event}', " . CJavaScript::encode($handler) . ")";
	
			Yii::app()->getClientScript()->registerScript(__CLASS__ . '#' . $this->getId(), ob_get_clean() . ';');
	}
}