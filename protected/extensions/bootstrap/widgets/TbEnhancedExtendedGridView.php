<?php
Yii::import('bootstrap.widgets.TbExtendedGridView');
Yii::import('bootstrap.widgets.TbPageSizeDropDown');
/**
 * TbExtendedGridView is an extended version of TbGridView.
 *
 * Features are:
 *  - Display an extended summary of the records shown. The extended summary can be configured to any of the
 *  {@link TbOperation} type of widgets.
 *  - Automatic chart display (using TbHighCharts widget), where user can 'switch' between views.
 *  - Selectable cells
 *  - Sortable rows
 *
 * @property CActiveDataProvider $dataProvider the data provider for the view.
 * @property TbDataColumn[] $columns
 */
class TbEnhancedExtendedGridView extends TbExtendedGridView
{
	public $enablePageSizeDropdown=false;
	
	//private static $PAGE_SIZE_TEMPLATE=' {pageSize} items per page';
	
	public $pageSizeDropdownOptions=array();
	
	//public $pageSizeDropdownValues=array(5=>5,10=>10,15=>15,20=>20,30=>30);
	
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
		$this->pageSizeDropdownOptions['containerWidgetType']=TbPageSizeDropDown::TYPE_GRIDVIEW;
		//$dropDownHtml=CHtml::dropDownList($name, $selectedValue, $listValues,$htmlOptions);
		
		return $this->widget('bootstrap.widgets.TbPageSizeDropDown',$this->pageSizeDropdownOptions,true);//str_replace('{pageSize}', $dropDownHtml, $template);
	}
	
}
