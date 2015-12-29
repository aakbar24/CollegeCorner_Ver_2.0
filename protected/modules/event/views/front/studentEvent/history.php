<?php
/* @var $this Controller */

$this->pageTitle="My Events - History";

$this->tabMenus=array(
		array('label'=>'Registered', 'url'=>array('/event/studentEvent/index')),
		array('label'=>'History','active'=>true,),
);

$this->widget('bootstrap.widgets.TbGridView',array(
		'id'=>'event-grid',
		'dataProvider'=>$model->search(true),
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