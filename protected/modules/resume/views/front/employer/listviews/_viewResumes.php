
<?php
$this->widget('bootstrap.widgets.TbListViewExtended', array(
		'id'=>'view-resumes',
		'dataProvider' => $model->searchLatestStuJobResumesWithEmployer(Yii::app()->user->id),//new CArrayDataProvider($data,array('keyField'=>false)),
		'itemView'=>'itemviews/_resumeListDetails',
		'enablePageSizeDropdown'=>true,
		'ajaxUpdate'=>false, //we defined our own update handler
		//'template'=>"\n{summary}\n{items}\n{pager}",
		'pageSizeDropdownOptions'=>array(
				'selectedValue'=>$model->pageSize,
				'htmlOptions'=>array('class'=>'pageSize-dropdown'),
				'registerScript'=>false,
				),
		
));

