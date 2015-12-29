<?php
class TbPageSizeDropDown extends CWidget{
	
	const TYPE_GRIDVIEW=1;
	const TYPE_LISTVIEW=2;

	public $containerId;
	public $containerWidgetType=self::TYPE_GRIDVIEW;
	private static $DEFAULT_PAGE_CLASS_CSS=' input-small page-size-dropdown';
	public $listValues=array(5=>5,10=>10,15=>15,20=>20,30=>30);
	public $selectedValue=5;
	public $persistDefaultPageSize=false;
	public $template=' {pageSize} items per page';
	public $htmlOptions=array();
	public $name;
	public $registerScript=true;
	public $onchange=null;
	
	private $widgetType='yiiGridView';

	public function init(){
		if (!isset($this->name) || !isset($this->containerId) || !isset($this->containerWidgetType)) {
			throw new CException('{name}, {containerId}, and {containerWidgetType} are required');
		}
		
		if ($this->containerWidgetType==self::TYPE_LISTVIEW) {
			$this->widgetType='yiiListView';
		}
		elseif ($this->containerWidgetType==self::TYPE_GRIDVIEW)
		{
			$this->widgetType='yiiGridView';
		}
		else{
			throw new CException('Invalid container widget type '.$this->containerWidgetType);
		}
		
		$globalDefaultPageSize=isset(Yii::app()->params['defaultPageLimit'])?Yii::app()->params['defaultPageLimit']:5;
		$selectedValue=Yii::app()->user->isGuest?$globalDefaultPageSize:Yii::app()->user->getState('defaultPageSize',$globalDefaultPageSize);
			
		$this->htmlOptions['class'].=self::$DEFAULT_PAGE_CLASS_CSS;
		
		if (Yii::app()->user->isGuest) {
			$this->persistDefaultPageSize=false;
		}
		
		if ($this->persistDefaultPageSize) {
			if (!Yii::app()->user->isGuest) {
				Yii::app()->user->setState('defaultPageSize',$selectedValue,$globalDefaultPageSize);
			}
		}
	}
	
	public function run(){
		$this->renderContent();
		if ($this->registerScript) {
			$this->registerClientScript();
		}
		
	}
	
	protected function renderContent(){
		$dropDownHtml=CHtml::dropDownList($this->name, $this->selectedValue, $this->listValues,$this->htmlOptions);
		echo str_replace('{pageSize}', $dropDownHtml, $this->template);
	}

	protected function registerClientScript()
	{
		if ($this->onchange!==null)
		{
			if ((!$this->onchange instanceof CJavaScriptExpression) && strpos($this->onchange,'js:')!==0)
				$this->onchange=new CJavaScriptExpression($this->onchange);
		}
		else
			$this->onchange = "var filters=$.param($('#{$this->containerId} .filters input, #{$this->containerId} .filters select, #{$this->containerId} .page-size-dropdown '));
				$.fn.{$this->widgetType}.update('{$this->containerId}',{data:filters});";
		
		//$onchange = CJavaScript::encode($this->onchange);
		//register the page size dropdown script
		$cs=Yii::app()->getClientScript();
		$cs->registerScript(__CLASS__ . '#' . $this->containerId, "
				$(document).on('change','#{$this->containerId} .page-size-dropdown ',function(e){
				{$this->onchange}
		});
		",CClientScript::POS_READY);
	}

}