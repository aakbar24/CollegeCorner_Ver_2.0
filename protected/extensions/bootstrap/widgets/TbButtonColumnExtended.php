<?php
/*##  TbButtonColumn class file.
 *
 * @author Christoffer Niska <ChristofferNiska@gmail.com>
 * @copyright  Copyright &copy; Christoffer Niska 2011-
 * @license [New BSD License](http://www.opensource.org/licenses/bsd-license.php) 
 * @package bootstrap.widgets
 * @since 0.9.8
 */

Yii::import('bootstrap.widgets.TbButtonColumn');

/**
 * Bootstrap button column widget.
 * Used to set buttons to use Glyphicons instead of the defaults images.
 */
class TbButtonColumnExtended extends TbButtonColumn
{
	public $id=false;
	public $dataAttr=false;
	protected function renderDataCellContent($row, $data){
		ob_start();
		parent::renderDataCellContent($row, $data);
		$cellContent=ob_get_contents();
		ob_clean();
		ob_end_clean();
		if ($this->id===false && $this->dataAttr===false) {
			echo $cellContent;
		}else if(isset($this->id)||isset($this->dataAttr)) {
			$containerHtmlOptions=array();
			
			if (is_string($this->id)) {
				$id=$this->evaluateExpression($this->id,array('row'=>$row,'data'=>$data));
				$containerHtmlOptions['id']=$id;
			}
			
			if (is_array($this->dataAttr)) {
				foreach ($this->dataAttr as $name=>$value) {
					$containerHtmlOptions[$name]=$this->evaluateExpression($value,array('row'=>$row,'data'=>$data));
				}
			}
			echo CHtml::tag('div',$containerHtmlOptions,$cellContent,true);
		}
	}
}
