<?php
/**
 * TbPickerColumnExtended
 *
 * The TbPickerColumn works with TbJsonGridView and allows you to create a column that will display a picker element
 * The picker is a special plugin that renders a dropdown on click, which contents can be dynamically updated.
 *
 * This class is extended to provide custom wrapper container as oppose to the default anchor tag only. 
 * @author: Wenbin Cai
 */
Yii::import('bootstrap.widgets.TbPickerColumn');

class TbPickerColumnExtended extends TbPickerColumn
{
	/**
	 * HTML tag that is going to used as the column content container.
	 * Defaults to the anchor "a" tag
	 * @var String
	 */
	public $containerTag='a';
	
	/**
	 * The html options for the container tag.
	 * @var Array
	 */
	public $containerHtmlOptions=array();

	/**
	 * Initialization function
	 */
	public function init()
	{
		if (!$this->class)
			$this->class = 'bootstrap-picker';
		$this->registerClientScript();
	}

	/**
	 * Renders a data cell content, wrapping the value with the link that will activate the picker
	 * @param int $row
	 * @param mixed $data
	 */
	public function renderDataCellContent($row, $data)
	{

		if ($this->value !== null)
			$value = $this->evaluateExpression($this->value, array('data' => $data, 'row' => $row));
		else if ($this->name !== null)
			$value = CHtml::value($data, $this->name);

		$class = preg_replace('/\s+/', '.', $this->class);
		
		if ($this->containerHtmlOptions!==null) {
			$this->containerHtmlOptions['class'].=' '.$class;
		}else{
			$this->containerHtmlOptions=array('class' => $class);
		}
		
		$value = !isset($value) ? $this->grid->nullDisplay : $this->grid->getFormatter()->format($value, $this->type);
		$value = CHtml::tag($this->containerTag,$this->containerHtmlOptions,$value);

		echo $value;
	}

	/**
	 * Registers client script data
	 * Note: Extended the default behavior of how the tooltip is toggle. Before the tooltip only toggles on the trigger target's click event.
	 * Now the any click 
	 */
	public function registerClientScript()
	{
	
		$class = preg_replace('/\s+/', '.', $this->class);
		/** @var $cs CClientScript */
		$cs = Yii::app()->getClientScript();
		$assetsUrl = Yii::app()->bootstrap->getAssetsUrl();
	
		$cs->registerCssFile($assetsUrl . '/css/bootstrap-picker.css');
		$cs->registerScriptFile($assetsUrl . '/js/bootstrap.picker.js');
		$cs->registerScript(__CLASS__ . '#' . $this->id, "$(document).on('click','#{$this->grid->id} $this->containerTag.{$class}', function(e){
	e.stopPropagation(); 
	if ($(this).hasClass('pickeron'))
	{
		$(this).removeClass('pickeron').picker('toggle');
		return;
	}
	$('#{$this->grid->id} {$this->containerTag}.pickeron').removeClass('pickeron').picker('toggle');
	$(this).picker(" . CJavaScript::encode($this->pickerOptions) . ").picker('toggle').addClass('pickeron'); return false;});
		
	$(document).on('click','.picker',function(e){e.stopPropagation();return;});
	
	$(document).on('click','body',function(e){
		$('.pickeron').removeClass('pickeron').picker('hide');
		return;
	});
		");
	}
}
