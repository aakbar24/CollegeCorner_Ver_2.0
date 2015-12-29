<?php
/* @var $this Controller */
$this->pageTitle="My Events - Registered";
$this->tabMenus=array(
		array('label'=>'Registered', 'active'=>true,),
		array('label'=>'History', 'url'=>array('/event/studentEvent/history')),
);

$this->widget('bootstrap.widgets.TbGridView',array(
		'id'=>'event-grid',
		'dataProvider'=>$model->search(),
		'filter'=>$model,
		'columns'=>array(
				'post_item_id',
				'title',
				'start_date:date',
				'end_date:date',
				'start_time:time',
				'end_time:time',
				
				array(
					'class'=>'bootstrap.widgets.TbButtonColumn',
					'template'=>'{view}',
					'viewButtonUrl'=>'Yii::app()->createAbsoluteUrl("event/event/view",array("id"=>$data->post_item_id))'
				),
		),
)); ?>