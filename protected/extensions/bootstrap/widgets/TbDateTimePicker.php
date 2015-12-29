<?php
/**
 * TbDateTimePicker - a bootstrap datetime picker widget, referenced TbDatePicker for implementation.
 * @author Wenbin
 *
 */
class TbDateTimePicker extends CInputWidget
{
	/**
	 * Indicates the rendered date time picker will be linked to a hidden input field. 
	 * @var boolean - default to false, meaning to use a text input 
	 */
	public $hidden=false;

	/**
	 * Indicates the date time picker should be rendered inline instead of the default dropdown style
	 * @var boolean - default to false, meaning to render as default dropdown
	 */
	public $inline=false;
	/**
	 * @var TbActiveForm when created via TbActiveForm.
	 * This attribute is set to the form that renders the widget
	 * @see TbActionForm->inputRow
	 */
	public $form;

	/**
	 * @var array the options for the Bootstrap JavaScript plugin.
	 */
	public $options = array();

	/**
	 * @var string[] the JavaScript event handlers.
	 */
	public $events = array();

	/**
	 *### .init()
	 *
	 * Initializes the widget.
	 */
	public function init()
	{
		$this->htmlOptions['type'] = 'text';
		$this->htmlOptions['autocomplete'] = 'off';

		if (!isset($this->options['language']))
			$this->options['language'] = substr(Yii::app()->getLanguage(), 0, 2);

		if (!isset($this->options['format']))
			$this->options['format'] = 'mm/dd/yyyy';

		if (!isset($this->options['weekStart']))
			$this->options['weekStart'] = 0; // Sunday
	}

	/**
	 *### .run()
	 *
	 * Runs the widget.
	 */
	public function run()
	{
		list($name, $id) = $this->resolveNameID();

		//start buffering the input field
		ob_start();
		if ($this->hasModel())
		{
			if ($this->form){
				if($this->hidden)
					echo $this->form->hiddenField($this->model, $this->attribute, $this->htmlOptions);
				else
					echo $this->form->textField($this->model, $this->attribute, $this->htmlOptions);
			}
			else{
				if ($this->hidden)
					echo CHtml::activeHiddenField($this->model, $this->attribute, $this->htmlOptions);
				else
					echo CHtml::activeTextField($this->model, $this->attribute, $this->htmlOptions);
			}

		} else {
			if($this->hidden)
				echo CHtml::hiddenField($name, $this->value, $this->htmlOptions);
			else
				echo CHtml::textField($name, $this->value, $this->htmlOptions);
		}
		$field=ob_get_clean();
		
		//checks the inline option 
		if ($this->inline) {
			//sets the default inline options
			$inlineOptions=array('linkField'=>$id,'linkFormat'=>'yyyy-mm-dd hh:ii');
			if (empty($this->options)) {
				$this->options=$inlineOptions;
			}
			else{
				//merge the options if we have one
				$this->options=CMap::mergeArray($this->options, $inlineOptions);
			}
			//sets the id to another element, so the widget will be rendered on this element instead of the input field
			$id='inline-'.$id;
			//creates the date time picker container to be rendered and passes in the input field as a child
			echo CHtml::tag('div',array('id'=>$id),$field,true);
		}else{
			echo $field;
		}
		

		$this->registerClientScript();
		$this->registerLanguageScript();
		$options = !empty($this->options) ? CJavaScript::encode($this->options) : '';

		ob_start();
		echo "jQuery('#{$id}').datetimepicker({$options})";
		foreach ($this->events as $event => $handler)
			echo ".on('{$event}', " . CJavaScript::encode($handler) . ")";

		Yii::app()->getClientScript()->registerScript(__CLASS__ . '#' . $this->getId(), ob_get_clean() . ';');

	}

	/**
	 *### .registerClientScript()
	 *
	 * Registers required client script for bootstrap datepicker. It is not used through bootstrap->registerPlugin
	 * in order to attach events if any
	 */
	public function registerClientScript()
	{
	 Yii::app()->bootstrap->registerAssetCss('bootstrap-datetimepicker.css');
	 Yii::app()->bootstrap->registerAssetJs('bootstrap-datetimepicker.min.js');
	}

	public function registerLanguageScript()
	{
		if (isset($this->options['language']) && $this->options['language'] != 'en')
		{
			$file = 'locales/bootstrap-datetimepicker.'.$this->options['language'].'.js';
			if (@file_exists(Yii::getPathOfAlias('bootstrap.assets').'/js/'.$file))
				Yii::app()->bootstrap->registerAssetJs('locales/bootstrap-datetimepicker.'.$this->options['language'].'.js', CClientScript::POS_END);
		}
	}
}
