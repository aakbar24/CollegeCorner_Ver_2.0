<?php
Yii::import('bootstrap.widgets.TbListView');
Yii::import('bootstrap.widgets.TbPageSizeDropDown');
/**
 * Extended Bootstrap Zii list view.
 */
class TbListViewExtended extends TbListView
{
	
	public $enablePageSizeDropdown=false;
	public $pageSizeDropdownOptions=array();
	
	public function renderContent()
	{
		if ($this->enablePageSizeDropdown) {
			if(!isset($this->summaryText)){
				$this->summaryText='Displaying {start}-{end} of {count} result(s).';
			}
			$this->summaryText.=$this->renderPageSizeDropdown();
		}
		parent::renderContent();
	}
	
	protected function renderPageSizeDropdown(){
		$this->pageSizeDropdownOptions['name']=$this->id.'-page-size';
	
		if ($this->pageSizeDropdownOptions!==null) {
			if (isset($this->pageSizeDropdownOptions['name'])) {
				$this->pageSizeDropdownOptions['name']=$this->id.'-'.$this->pageSizeDropdownOptions['name'];
			}
		}
	
		if(isset($this->dataProvider)){
			$this->pageSizeDropdownOptions['name']=$this->dataProvider->getId().'[pageSize]';
		}
	
		$this->pageSizeDropdownOptions['containerId']=$this->id;
		$this->pageSizeDropdownOptions['containerWidgetType']=TbPageSizeDropDown::TYPE_LISTVIEW;
		//$dropDownHtml=CHtml::dropDownList($name, $selectedValue, $listValues,$htmlOptions);
	
		return $this->widget('bootstrap.widgets.TbPageSizeDropDown',$this->pageSizeDropdownOptions,true);//str_replace('{pageSize}', $dropDownHtml, $template);
	}
}
