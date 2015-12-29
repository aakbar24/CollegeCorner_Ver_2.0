<?php 
/* @var $this Controller */
?>
<li class="span6 ">
<?php $box = $this->beginWidget('bootstrap.widgets.TbBox', array(
	'title' => CHtml::link(CHtml::encode($data->title),array('view','id'=>$data->post_item_id)).CertificationHelper::getCertficationCatLabel($data),
	//'headerIcon' => 'icon-user',
	// when displaying a table, if we include bootstra-widget-table class
	// the table will be 0-padding to the box
	'htmlOptions' => array('class'=>'thumbnail certification')
));?>
<div class="view">

	<?php 
	/* $this->widget('bootstrap.widgets.TbDetailView', array(
		'type'=>array('bordered','striped','condensed'),
		'data'=>$data,
		    'attributes'=>array(
		    	'user_id',
		    	'certification_cat_name',
		    	//'name'=>array('label'=>'Name','value'=>$data->first_name.' '.$data->last_name),
				'provider',		    	
	    		'is_active:boolean',
		    ),
		)); */
	$this->renderPartial('certificate.views.common.certification._certificationPart',array('data'=>$data,'span'=>'span6'));
	?>
</div>

<?php $this->endWidget();?>
</li>