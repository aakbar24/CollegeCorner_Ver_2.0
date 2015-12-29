<?php $this->widget('bootstrap.widgets.TbGridView',array(
	'id'=>'workshop-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'post_item_id',
		array('filter'=>CHtml::listData(WorkshopCat::getAllCategories(), 'workshop_cat_id', 'workshop_cat_name'),
				'name'=>'workshop_cat_id','value'=>'$data->workshop_cat_name'),
		//array('name'=> 'workshop_facilitator_id','value'=>'$data->workshop_facilitator_id==null?"Pending":$data->workshop_facilitator_id'),
		'title',
		'start_date:date',
		'end_date:date',
			
		'start_time:time',
		'end_time:time',
		array(
				'name'=>'is_approved',
				'filter'=>array('1'=>'Yes','0'=>'No'),
				'value'=>'Yii::app()->format->formatBoolean($data->is_approved)',
		),
		
		array(
			'class'=>'bootstrap.widgets.TbButtonColumn',
			'afterDelete'=>'function(link,success,data){if(success)jQuery("#alert-div").html(data);}'
		),
	),
));