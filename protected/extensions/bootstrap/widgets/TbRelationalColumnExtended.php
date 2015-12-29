<?php
/**
 * TbRelationalColumnExtended class
 *
 * An extended version.
 *
 * @author: Wenbin Cai
 */

Yii::import('bootstrap.widgets.TbRelationalColumn');
class TbRelationalColumnExtended extends TbRelationalColumn
{
	/**
	 * (non-PHPdoc)
	 * Composite primary keys are joined by "-". 
	 * <p>
	 * @see TbRelationalColumn::getPrimaryKey()
	 */
	public function getPrimaryKey($data){
		$key=parent::getPrimaryKey($data);
		return str_replace(',', '-', $key);
	}
	
	/**
	 * Register script that will handle its behavior
	 */
	public function registerClientScript()
	{
		Yii::app()->bootstrap->registerAssetCss('bootstrap-relational.css');
		/** @var $cs CClientScript */
		$cs = Yii::app()->getClientScript();
		if ($this->afterAjaxUpdate!==null)
		{
			if ((!$this->afterAjaxUpdate instanceof CJavaScriptExpression) && strpos($this->afterAjaxUpdate,'js:')!==0)
				$this->afterAjaxUpdate=new CJavaScriptExpression($this->afterAjaxUpdate);
		}
		else
			$this->afterAjaxUpdate = 'js:$.noop';
	
		$this->ajaxErrorMessage = CHtml::encode($this->ajaxErrorMessage);
		$afterAjaxUpdate = CJavaScript::encode($this->afterAjaxUpdate);
		$span = count($this->grid->columns);
		$loadingPic = CHtml::image(Yii::app()->bootstrap->getAssetsUrl().'/img/loading.gif');
		$cache = $this->cacheData? 'true':'false';
		$data = !empty($this->submitData) && is_array($this->submitData)? $this->submitData : 'js:{}';
		$data = CJavascript::encode($data);
		$token=Yii::app()->request->enableCsrfValidation?Yii::app()->request->csrfToken:'';
		$cssClass='.'.(str_replace(' ', '.', $this->cssClass));
		$js =<<<EOD
$(document).on('click','{$cssClass}', function(){
	var span = $span;
	var that = $(this);
	var afterAjaxUpdate = {$afterAjaxUpdate};

	toggleRelateCol(span, that,afterAjaxUpdate);
	
});
EOD;
		$cs->registerScript(__CLASS__.'#'.$this->id, $js);
		
		$fn=<<<EOD
function toggleRelateCol(span, that, tr, afterAjaxUpdate){
	
	var status = that.data('status');
	var rowid = that.data('rowid');
	var tr = $('#relatedinfo'+rowid);
	var parent = that.parents('tr').eq(0);

	if (status && status=='on'){return}
		that.data('status','on');
	
	if (tr.length && !tr.is(':visible') && {$cache})
	{
		tr.slideDown();
		that.data('status','off');
		return;
	}else if (tr.length && tr.is(':visible'))
	{
		tr.hide();
		that.data('status','off');
		return;
	}
	if (tr.length)
	{
		tr.find('td').html('{$loadingPic}');
		if (!tr.is(':visible')){
			tr.slideDown();
		}
	}
	else
	{
		var td = $('<td/>').html('{$loadingPic}').attr({'colspan':span,'class':'relatedinfo-container'});
		tr = $('<tr/>').prop({'id':'relatedinfo'+rowid}).append(td);
		/* we need to maintain zebra styles :) */
		var fake = $('<tr class="hide"/>').append($('<td/>').attr({'colspan':span,'class':'relatedinfo-container'}));
		parent.after(tr);
		tr.after(fake);
	}
	var data = $.extend({$data}, {id:rowid,YII_CSRF_TOKEN:'{$token}'});
	$.ajax({
		url: '{$this->url}',
		data: data,
		type: 'post',
		success: function(data){
			tr.find('td').html(data);
			that.data('status','off');
			if ($.isFunction(afterAjaxUpdate))
			{
				afterAjaxUpdate(tr,rowid,data);
			}
		},
		error: function()
		{
			tr.find('td').html('{$this->ajaxErrorMessage}');
			that.data('status','off');
		}
	});
}		
EOD;
		$cs->registerScript(__CLASS__.'Functions', $fn,CClientScript::POS_END);
	}
}
