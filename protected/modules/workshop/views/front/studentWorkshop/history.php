<?php
/* @var $this Controller */

$this->pageTitle="My Workshops - History";

$this->tabMenus=array(
		array('label'=>'Registered', 'url'=>array('/workshop/studentWorkshop/index')),
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
					'viewButtonUrl'=>'Yii::app()->createAbsoluteUrl("workshop/workshop/view",array("id"=>$data->post_item_id))'
				),
		),
)); ?>